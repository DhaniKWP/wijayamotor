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

        return view('admin.booking.complete', compact('booking', 'spareparts'));
    }

    /**
     * Simpan Work Order → buat ServiceTransaction + items, ubah status ke 'done'.
     */
    public function store(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'payment_method'     => 'required|in:cash,transfer',
            'items'              => 'required|array|min:1',
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

            // Hitung biaya dari service utama (estimasi jadi biaya dasar)
            $serviceCost = floatval($booking->estimasi_harga ?? 0);

            // Buat transaksi induk
            $transaction = ServiceTransaction::create([
                'booking_id'     => $booking->id,
                'service_cost'   => $serviceCost,
                'sparepart_cost' => 0,
                'total_cost'     => 0,
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            $jasaTotal      = 0;
            $sparepartTotal = 0;

            foreach ($request->items as $item) {
                $qty      = intval($item['qty']);
                $price    = floatval($item['price']);
                $subtotal = $qty * $price;

                // Validasi item_type-spesifik
                if ($item['item_type'] === 'sparepart' && empty($item['sparepart_id'])) {
                    continue; // skip baris tidak valid
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

            // Update total di transaksi
            $transaction->update([
                'service_cost'   => $serviceCost + $jasaTotal,
                'sparepart_cost' => $sparepartTotal,
                'total_cost'     => $serviceCost + $jasaTotal + $sparepartTotal,
            ]);

            // Tandai booking selesai
            $booking->update(['status' => 'done']);
        });

        return redirect()->route('admin.bookings.invoice', $booking->id)
            ->with('success', 'Servis selesai! Invoice telah dibuat.');
    }

    /**
     * Admin tandai pembayaran sebagai LUNAS.
     */
    public function markPaid($id)
    {
        $booking = Booking::with('transaction')->findOrFail($id);

        if (!$booking->transaction) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $booking->transaction->update(['payment_status' => 'paid']);

        return redirect()->route('admin.bookings.invoice', $booking->id)
            ->with('success', 'Pembayaran berhasil ditandai LUNAS.');
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
