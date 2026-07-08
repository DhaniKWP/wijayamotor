<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfflineSale;
use App\Models\OfflineSaleItem;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfflineSaleController extends Controller
{
    /**
     * Daftar riwayat penjualan offline.
     */
    public function index(Request $request)
    {
        $query = OfflineSale::with(['admin', 'items.sparepart'])->latest();

        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $sales = $query->paginate(20)->withQueryString();
        $totalToday = OfflineSale::whereDate('created_at', today())->sum('total_amount');
        $countToday = OfflineSale::whereDate('created_at', today())->count();

        return view('admin.offline-sales.index', compact('sales', 'totalToday', 'countToday'));
    }

    /**
     * Form kasir — pilih sparepart & qty.
     */
    public function create()
    {
        // Tampilkan semua sparepart, yang ada stok duluan
        $spareparts = Sparepart::orderByDesc('stock')->orderBy('name')->get();
        return view('admin.offline-sales.create', compact('spareparts'));
    }

    /**
     * Simpan transaksi penjualan offline.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'          => 'nullable|string|max:100',
            'payment_method'         => 'required|in:cash,transfer',
            'items'                  => 'required|array|min:1',
            'items.*.sparepart_id'   => 'required|exists:spareparts,id',
            'items.*.qty'            => 'required|integer|min:1',
        ]);

        $sale = null;

        DB::transaction(function () use ($request, &$sale) {
            $totalAmount = 0;

            // Validasi stok dulu sebelum menyimpan
            foreach ($request->items as $item) {
                $sparepart = Sparepart::findOrFail($item['sparepart_id']);
                if ($sparepart->stock < $item['qty']) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'items' => "Stok {$sparepart->name} tidak mencukupi. Sisa stok: {$sparepart->stock}.",
                    ]);
                }
            }

            // Buat header transaksi
            $sale = OfflineSale::create([
                'admin_id'       => Auth::id(),
                'customer_name'  => $request->customer_name ?: 'Pelanggan Umum',
                'payment_method' => $request->payment_method,
                'total_amount'   => 0, // akan diupdate setelah items dihitung
            ]);

            // Simpan item dan potong stok
            foreach ($request->items as $item) {
                $sparepart = Sparepart::findOrFail($item['sparepart_id']);
                $price     = $sparepart->price;
                $qty       = intval($item['qty']);
                $subtotal  = $price * $qty;

                OfflineSaleItem::create([
                    'offline_sale_id' => $sale->id,
                    'sparepart_id'    => $sparepart->id,
                    'qty'             => $qty,
                    'price'           => $price,
                    'subtotal'        => $subtotal,
                ]);

                $sparepart->decrement('stock', $qty);
                $totalAmount += $subtotal;
            }

            // Update total
            $sale->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('admin.offline-sales.show', $sale->id)
            ->with('success', 'Penjualan offline berhasil dicatat! Struk siap dicetak.');
    }

    /**
     * Detail / cetak struk penjualan offline.
     */
    public function show($id)
    {
        $sale = OfflineSale::with(['admin', 'items.sparepart'])->findOrFail($id);
        return view('admin.offline-sales.show', compact('sale'));
    }
}
