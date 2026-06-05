<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Buat order baru (beli langsung dari halaman detail sparepart).
     */
    public function store(Request $request)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:spareparts,id',
            'quantity'     => 'required|integer|min:1',
        ]);

        $sparepart = Sparepart::findOrFail($request->sparepart_id);

        // Cek stok
        if ($sparepart->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi. Tersisa ' . $sparepart->stock . ' unit.']);
        }

        DB::transaction(function () use ($request, $sparepart, &$order) {
            $qty      = $request->quantity;
            $price    = $sparepart->price;
            $subtotal = $price * $qty;

            // Buat order
            $order = Order::create([
                'user_id'     => Auth::id(),
                'total_price' => $subtotal,
                'status'      => 'pending',
            ]);

            // Buat order item
            OrderItem::create([
                'order_id'     => $order->id,
                'sparepart_id' => $sparepart->id,
                'qty'          => $qty,
                'price'        => $price,
                'subtotal'     => $subtotal,
            ]);

            // Kurangi stok
            $sparepart->decrement('stock', $qty);
        });

        return redirect()->route('customer.order.success', $order->id);
    }

    /**
     * Halaman konfirmasi sukses setelah order dibuat.
     */
    public function success($id)
    {
        $order = Order::with(['items.sparepart'])->where('user_id', Auth::id())->findOrFail($id);

        $bankInfo = [
            'bank'      => 'BCA',
            'nomor'     => '1234567890',
            'atas_nama' => 'Wijaya Motor',
        ];

        return view('customer.orders.success', compact('order', 'bankInfo'));
    }
}
