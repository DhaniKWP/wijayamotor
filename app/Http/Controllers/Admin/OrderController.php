<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmedMail;

class OrderController extends Controller
{
    /**
     * Daftar semua pesanan sparepart dari customer.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.sparepart'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search (nama customer / id order)
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('id', $request->search);
        }

        $orders    = $query->paginate(20)->withQueryString();
        $pending   = Order::where('status', 'pending')->count();
        $confirmed = Order::where('status', 'confirmed')->count();
        $done      = Order::where('status', 'done')->count();

        return view('admin.orders.index', compact('orders', 'pending', 'confirmed', 'done'));
    }

    /**
     * Konfirmasi order: barang disiapkan, customer bisa pickup.
     */
    public function confirm($id)
    {
        $order = Order::with(['user', 'items.sparepart'])->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->withErrors(['error' => 'Order tidak dalam status menunggu.']);
        }

        $order->update(['status' => 'confirmed']);

        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderConfirmedMail($order));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email order confirmed: ' . $e->getMessage());
        }

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' dikonfirmasi. Customer siap untuk pickup.');
    }

    /**
     * Tandai order sebagai lunas & selesai (setelah customer pickup & bayar).
     */
    public function markDone(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $order = Order::with(['user', 'items.sparepart'])->findOrFail($id);

        if ($order->status !== 'confirmed') {
            return back()->withErrors(['error' => 'Order harus dikonfirmasi terlebih dahulu sebelum ditandai lunas.']);
        }

        $order->update([
            'status'         => 'done',
            'payment_method' => $request->payment_method,
        ]);

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.order-invoice-print', compact('order'));

        // Cek email user
        if (!empty($order->user->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderInvoiceMail($order, $pdf->output()));
                $message = 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' lunas dan Nota PDF otomatis dikirim ke email pelanggan.';
            } catch (\Exception $e) {
                $message = 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' lunas, namun gagal mengirim email: ' . $e->getMessage();
            }
        } else {
            $message = 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' lunas. (Pelanggan tidak ada email, nota tidak dikirim).';
        }

        return redirect()->route('admin.orders.index')
                         ->with('success', $message);
    }

    /**
     * Membatalkan order dan mengembalikan stok
     */
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);

        $order = Order::with(['items.sparepart'])->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya order dengan status menunggu yang bisa dibatalkan.']);
        }

        // Kembalikan stok
        foreach ($order->items as $item) {
            if ($item->sparepart) {
                $item->sparepart->increment('stock', $item->qty);
            }
        }

        // Update status order
        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->cancel_reason,
        ]);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Order #ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . ' berhasil dibatalkan. Stok barang telah dikembalikan.');
    }

    /**
     * Halaman print struk / nota pembelian sparepart.
     */
    public function struk($id)
    {
        $order = Order::with(['user', 'items.sparepart'])->findOrFail($id);

        return view('admin.orders.struk', compact('order'));
    }
}
