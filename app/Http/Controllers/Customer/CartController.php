<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Sparepart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang.
     */
    public function index()
    {
        $cartItems = CartItem::with('sparepart')->where('user_id', Auth::id())->get();
        return view('customer.cart.index', compact('cartItems'));
    }

    /**
     * Tambah barang ke keranjang.
     */
    public function add(Request $request)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:spareparts,id',
            'quantity'     => 'required|integer|min:1',
        ]);

        $sparepart = Sparepart::findOrFail($request->sparepart_id);
        
        // Cek keranjang apakah sudah ada
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('sparepart_id', $request->sparepart_id)
            ->first();

        $newQty = $cartItem ? $cartItem->qty + $request->quantity : $request->quantity;

        if ($sparepart->stock < $newQty) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi. Tersisa ' . $sparepart->stock . ' unit.']);
        }

        if ($cartItem) {
            $cartItem->update(['qty' => $newQty]);
        } else {
            CartItem::create([
                'user_id'      => Auth::id(),
                'sparepart_id' => $request->sparepart_id,
                'qty'          => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update qty barang di keranjang.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        
        if ($cartItem->sparepart->stock < $request->qty) {
            return back()->withErrors(['qty' => 'Stok ' . $cartItem->sparepart->name . ' tidak mencukupi.']);
        }

        $cartItem->update(['qty' => $request->qty]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    /**
     * Hapus barang dari keranjang.
     */
    public function remove($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }

    /**
     * Proses checkout.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'exists:cart_items,id'
        ], [
            'selected_items.required' => 'Pilih minimal satu barang untuk checkout.'
        ]);

        $cartItems = CartItem::with('sparepart')
            ->where('user_id', Auth::id())
            ->whereIn('id', $request->selected_items)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'Barang yang dipilih tidak valid.']);
        }

        // Cek stok kembali
        foreach ($cartItems as $item) {
            if ($item->sparepart->stock < $item->qty) {
                return back()->withErrors(['cart' => 'Stok ' . $item->sparepart->name . ' tidak mencukupi untuk jumlah di keranjang.']);
            }
        }

        DB::transaction(function () use ($cartItems, &$order) {
            $totalPrice = 0;
            
            // Hitung total harga
            foreach ($cartItems as $item) {
                $totalPrice += ($item->sparepart->price * $item->qty);
            }

            // Buat order
            $order = Order::create([
                'user_id'     => Auth::id(),
                'total_price' => $totalPrice,
                'status'      => 'pending',
            ]);

            // Buat order items & kurangi stok
            foreach ($cartItems as $item) {
                $subtotal = $item->sparepart->price * $item->qty;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'sparepart_id' => $item->sparepart_id,
                    'qty'          => $item->qty,
                    'price'        => $item->sparepart->price,
                    'subtotal'     => $subtotal,
                ]);

                $item->sparepart->decrement('stock', $item->qty);
                $item->delete(); // Kosongkan keranjang
            }
        });

        return redirect()->route('customer.order.success', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }
}
