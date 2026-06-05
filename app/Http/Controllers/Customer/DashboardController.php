<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    /**
     * Halaman ringkasan akun (dashboard utama pelanggan).
     */
    public function index()
    {
        $user = Auth::user();

        $vehicles       = Vehicle::where('user_id', $user->id)->count();
        $totalBookings  = Booking::where('user_id', $user->id)->count();
        $activeBookings = Booking::where('user_id', $user->id)
                            ->whereIn('status', ['pending', 'confirmed', 'process'])
                            ->count();

        // Booking terakhir untuk preview
        $latestBooking = Booking::where('user_id', $user->id)
                            ->with(['vehicle', 'service', 'transaction'])
                            ->latest()
                            ->first();

        return view('customer.dashboard', compact(
            'vehicles',
            'totalBookings',
            'activeBookings',
            'latestBooking'
        ));
    }

    /**
     * Halaman "Pesanan Saya" — daftar lengkap semua booking + info tagihan.
     */
    public function pesanan()
    {
        $user = Auth::user();

        $bookings = Booking::where('user_id', $user->id)
                        ->with(['vehicle', 'service', 'transaction.items'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Info rekening bengkel (hardcoded sementara)
        $bankInfo = [
            'bank'   => 'BCA',
            'nomor'  => '1234567890',
            'atas_nama' => 'Wijaya Motor',
        ];

        return view('customer.pesanan', compact('bookings', 'bankInfo'));
    }
}
