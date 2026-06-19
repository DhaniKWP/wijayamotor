<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\BookingAcceptedMail;

class BookingController extends Controller
{
    // 1. HALAMAN DASHBOARD (REKAPAN)
    public function dashboard()
    {
        // Hitung Statistik
        $pendingCount = Booking::where('status', 'pending')->count();
        $todayCount = Booking::whereDate('tanggal', Carbon::today())->count(); 
        $processCount = Booking::where('status', 'process')->count();
        $doneMonthCount = Booking::where('status', 'done')
                                ->whereMonth('updated_at', Carbon::now()->month)
                                ->count();

        // Ambil 5 bookingan terbaru buat mejeng di dashboard
        $recentBookings = Booking::with(['user', 'vehicle', 'service'])
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact(
            'pendingCount', 
            'todayCount', 
            'processCount', 
            'doneMonthCount',
            'recentBookings'
        ));
    }

    // 2. HALAMAN MANAJEMEN BOOKING (TABEL FULL)
    public function index(Request $request)
    {
        // Query Data dengan Filter
        $query = Booking::with(['user', 'vehicle', 'service'])
                        ->orderBy('tanggal', 'asc')
                        ->orderBy('jam', 'asc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15);

        // Arahin ke folder admin/booking/index.blade.php
        return view('admin.booking.index', compact('bookings'));
    }

    // FUNGSI AKSI STATUS (TETAP SAMA)
    public function accept($id)
    {
        $booking = Booking::with(['user', 'vehicle', 'service'])->findOrFail($id);
        $booking->update(['status' => 'confirmed']); 
        
        try {
            if ($booking->user && $booking->user->email) {
                Mail::to($booking->user->email)->send(new BookingAcceptedMail($booking));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email booking accepted: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Booking berhasil disetujui.');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'cancelled']); 
        return redirect()->back()->with('success', 'Booking berhasil ditolak.');
    }

    public function process($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'process']);
        return redirect()->back()->with('success', 'Status kendaraan sedang dikerjakan.');
    }

    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'done']);
        return redirect()->back()->with('success', 'Servis selesai.');
    }
}