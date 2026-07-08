<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Sparepart;
use App\Models\ServiceTransaction;
use App\Models\ServiceTransactionItem;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Tampilkan halaman Work Order (form selesaikan servis).
     * Admin input jasa tambahan + sparepart yang dipakai.
     */
    public function showCompleteForm($id)
    {
        $booking    = Booking::with(['user', 'vehicle', 'service'])->findOrFail($id);
        $spareparts = Sparepart::orderBy('name')->get();

        // Pastikan booking masih dalam status 'process'
        if ($booking->status !== 'process') {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Hanya booking berstatus "process" yang bisa diselesaikan.');
        }
        
        $homeServiceFee = 0;
        if ($booking->tipe_booking === 'home_service') {
            $totalKnown = 0;
            if ($booking->jenis_servis === 'umum') {
                $repairPrices = [
                    'engine_oil' => 498000, 'brake_service' => 286000,
                    'engine_tune_up' => 450000, 'fuel_filter' => 416000,
                    'brake_pads' => 607000, 'reset_alarm' => 63000,
                    'engine_diagnose' => 216000, 'other' => 0
                ];
                $repairs = json_decode($booking->addons, true) ?? [];
                foreach ($repairs as $r) {
                    $totalKnown += $repairPrices[$r] ?? 0;
                }
            } else {
                $totalKnown += $booking->service->price_estimate ?? 0;
                $addons = json_decode($booking->addons, true) ?? [];
                if (in_array('ac', $addons) || in_array('ac_care', $addons)) $totalKnown += 350000;
                if (in_array('engine', $addons) || in_array('engine_care', $addons)) $totalKnown += 400000;
                
                $km = $booking->kilometer;
                $serviceData = [
                    1000 => 0, 10000 => 550000, 20000 => 710000, 30000 => 550000,
                    40000 => 1020000, 50000 => 550000, 60000 => 710000, 70000 => 550000,
                    80000 => 1020000, 90000 => 550000, 100000 => 810000,
                ];
                $totalKnown += $serviceData[$km] ?? 0;
            }
            $homeServiceFee = $booking->estimasi_harga - $totalKnown;
            if ($homeServiceFee < 0) $homeServiceFee = 0;
        }

        return view('admin.booking.complete', compact('booking', 'spareparts', 'homeServiceFee'));
    }

    /**
     * Simpan Work Order → buat ServiceTransaction + items, ubah status ke 'done'.
     */
    public function store(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'payment_method'     => 'required|in:cash,transfer',
            'items'              => 'nullable|array',
            'items.*.item_type'  => 'required|in:sparepart,jasa',
            'items.*.qty'        => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
            // sparepart_id wajib kalau item_type=sparepart
            'items.*.sparepart_id' => 'nullable|exists:spareparts,id',
            // item_name wajib kalau item_type=jasa
            'items.*.item_name'  => 'nullable|string|max:255',
            'items.*.note'       => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $booking) {

            // Ambil biaya jasa dasar dari master katalog servis
            $serviceCost = floatval($booking->service->price_estimate ?? 0);

            // Buat transaksi induk
            $transaction = ServiceTransaction::create([
                'booking_id'     => $booking->id,
                'service_cost'   => $serviceCost,
                'sparepart_cost' => 0,
                'total_cost'     => 0,
                'payment_status' => 'paid',
                'payment_method' => $request->payment_method,
            ]);

            $jasaTotal      = 0;
            $sparepartTotal = 0;

            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $qty      = intval($item['qty']);
                    $price    = floatval($item['price']);
                    $subtotal = $qty * $price;

                    // Validasi item_type-spesifik
                    if ($item['item_type'] === 'sparepart') {
                        if (empty($item['sparepart_id'])) {
                            continue; // skip baris tidak valid
                        }

                        // Cek dan potong stok
                        $sparepart = Sparepart::find($item['sparepart_id']);
                        if (!$sparepart) {
                            continue;
                        }

                        if ($sparepart->stock < $qty) {
                            // Lempar error jika stok kurang
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                'items' => "Stok {$sparepart->name} tidak mencukupi. Sisa stok: {$sparepart->stock}.",
                            ]);
                        }

                        // Potong stok
                        $sparepart->decrement('stock', $qty);
                    }

                    if ($item['item_type'] === 'jasa' && empty($item['item_name'])) {
                        continue;
                    }

                    ServiceTransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'item_type'      => $item['item_type'],
                        'sparepart_id'   => $item['item_type'] === 'sparepart' ? $item['sparepart_id'] : null,
                        'item_name'      => $item['item_type'] === 'jasa'      ? $item['item_name']   : null,
                        'note'           => $item['note'] ?? null,
                        'qty'            => $qty,
                        'price'          => $price,
                        'subtotal'       => $subtotal,
                    ]);

                    if ($item['item_type'] === 'sparepart') {
                        $sparepartTotal += $subtotal;
                    } else {
                        $jasaTotal += $subtotal;
                    }
                }
            }

            // Update total di transaksi
            $transaction->update([
                'service_cost'   => $serviceCost + $jasaTotal,
                'sparepart_cost' => $sparepartTotal,
                'total_cost'     => $serviceCost + $jasaTotal + $sparepartTotal,
            ]);

            // Tandai booking selesai
            $booking->update(['status' => 'done']);
        });

        // Reload relations needed for PDF
        $booking->load(['user', 'vehicle', 'service', 'transaction.items.sparepart']);

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice-print', compact('booking'));
        
        // Kirim email ke user
        $message = 'Servis selesai dan Invoice telah dibuat.';
        if (!empty($booking->user->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($booking->user->email)->send(new \App\Mail\InvoiceMail($booking, $pdf->output()));
                $message = 'Servis selesai, pembayaran LUNAS, dan Invoice PDF otomatis dikirim ke email pelanggan.';
            } catch (\Exception $e) {
                $message = 'Servis selesai & LUNAS, namun gagal mengirim email ke pelanggan: ' . $e->getMessage();
            }
        }

        return redirect()->route('admin.bookings.invoice', $booking->id)
            ->with('success', $message);
    }

    /**
     * Admin tandai pembayaran sebagai LUNAS.
     */
    public function markPaid($id)
    {
        $booking = Booking::with([
            'user',
            'vehicle',
            'service',
            'transaction.items.sparepart',
        ])->findOrFail($id);

        if (!$booking->transaction) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $booking->transaction->update(['payment_status' => 'paid']);

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice-print', compact('booking'));
        
        // Cek email user
        if (!empty($booking->user->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($booking->user->email)->send(new \App\Mail\InvoiceMail($booking, $pdf->output()));
                $message = 'Pembayaran berhasil ditandai LUNAS dan Invoice PDF otomatis dikirim ke email pelanggan.';
            } catch (\Exception $e) {
                // If email fails, don't break the transaction update
                $message = 'Pembayaran LUNAS, namun gagal mengirim email ke pelanggan: ' . $e->getMessage();
            }
        } else {
            $message = 'Pembayaran LUNAS. (Pelanggan tidak memiliki email terdaftar, invoice tidak dikirim).';
        }

        return redirect()->route('admin.bookings.invoice', $booking->id)
            ->with('success', $message);
    }

    /**
     * Tampilkan Invoice / Struk Servis.
     */
    public function invoice($id)
    {
        $booking = Booking::with([
            'user',
            'vehicle',
            'service',
            'transaction.items.sparepart',
        ])->findOrFail($id);

        if (!$booking->transaction) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Invoice tidak ditemukan untuk booking ini.');
        }

        return view('admin.booking.invoice', compact('booking'));
    }
}
