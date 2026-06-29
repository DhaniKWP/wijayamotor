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

        // Hitung Pemasukan (Dari Servis)
        $todayRevenue = \App\Models\ServiceTransaction::where('payment_status', 'paid')
                                ->whereDate('updated_at', Carbon::today())
                                ->sum('total_cost');
        
        $monthRevenue = \App\Models\ServiceTransaction::where('payment_status', 'paid')
                                ->whereMonth('updated_at', Carbon::now()->month)
                                ->whereYear('updated_at', Carbon::now()->year)
                                ->sum('total_cost');

        // Tambah dari Sparepart Online jika ada
        $todayOrderRevenue = \App\Models\Order::whereIn('status', ['paid', 'shipped', 'done'])
                                ->whereDate('updated_at', Carbon::today())
                                ->sum('total_price');
        
        $monthOrderRevenue = \App\Models\Order::whereIn('status', ['paid', 'shipped', 'done'])
                                ->whereMonth('updated_at', Carbon::now()->month)
                                ->whereYear('updated_at', Carbon::now()->year)
                                ->sum('total_price');

        $todayRevenue += $todayOrderRevenue;
        $monthRevenue += $monthOrderRevenue;

        // Data untuk Grafik Tren Servis (7 Hari Terakhir)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('d M');
            $chartData[] = Booking::whereDate('tanggal', $date)->count();
        }

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
            'recentBookings',
            'todayRevenue',
            'monthRevenue',
            'chartLabels',
            'chartData'
        ));
    }

    // 2. HALAMAN MANAJEMEN BOOKING (TABEL FULL)
    public function index(Request $request)
    {
        // Query Data dengan Filter
        $query = Booking::with(['user', 'vehicle', 'service']);

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('tanggal', $request->date);
        }

        // Sort Order
        $sortOrder = $request->get('sort', 'asc'); // default asc
        if ($sortOrder === 'desc') {
            $query->orderBy('tanggal', 'desc')->orderBy('jam', 'desc');
        } else {
            $query->orderBy('tanggal', 'asc')->orderBy('jam', 'asc');
        }

        // Default tab is 'active' if not specified and not explicitly 'all'
        $statusTab = $request->get('status', 'active');

        if ($statusTab == 'active') {
            $query->whereIn('status', ['pending', 'confirmed', 'process']);
        } elseif ($statusTab == 'history') {
            $query->whereIn('status', ['done', 'cancelled']);
        } elseif ($statusTab != 'all') {
            $query->where('status', $statusTab);
        }

        $bookings = $query->paginate(15);
        $bookings->appends([
            'status' => $statusTab,
            'date' => $request->date,
            'sort' => $sortOrder
        ]); // Keep query string in pagination

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