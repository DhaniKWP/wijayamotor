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
        $statusTab = $request->get('status', 'pending'); // Default langsung masuk ke "Menunggu"
        
        $filterDate = $request->input('date');
        // Default ke hari ini jika BUKAN tab menunggu dan user belum milih tanggal (fresh load)
        if ($statusTab != 'pending' && !$request->has('date')) {
            $filterDate = Carbon::today()->format('Y-m-d');
        }

        // Base Query untuk Hitung Statistik (supaya ngikutin filter tanggal)
        $statsQuery = Booking::query();
        if (!empty($filterDate)) {
            $statsQuery->whereDate('tanggal', $filterDate);
        }

        // Hitung Statistik untuk Stat Cards
        $pending   = (clone $statsQuery)->where('status', 'pending')->count();
        $confirmed = (clone $statsQuery)->where('status', 'confirmed')->count();
        $process   = (clone $statsQuery)->where('status', 'process')->count();
        $done      = (clone $statsQuery)->where('status', 'done')->count();

        // Query Data dengan Filter
        $query = Booking::with(['user', 'vehicle', 'service']);

        if (!empty($filterDate)) {
            $query->whereDate('tanggal', $filterDate);
        }

        if ($statusTab != 'all') {
            $query->where('status', $statusTab);
        }

        // Sort Order Cerdas
        if ($statusTab === 'pending') {
            // Menunggu: Siapa cepat booking dia dapat (diurutkan berdasarkan waktu dibuat)
            $query->orderBy('created_at', 'asc');
        } else {
            // Selain menunggu: Berdasarkan jadwal servis (waktu dan jam) terdekat
            $sortOrder = $request->get('sort', 'asc'); // default asc
            if ($sortOrder === 'desc') {
                $query->orderBy('tanggal', 'desc')->orderBy('jam', 'desc');
            } else {
                $query->orderBy('tanggal', 'asc')->orderBy('jam', 'asc');
            }
        }

        $bookings = $query->paginate(15);
        $bookings->appends([
            'status' => $statusTab,
            'date'   => $filterDate,
            'sort'   => $request->get('sort', 'asc')
        ]);

        return view('admin.booking.index', compact('bookings', 'pending', 'confirmed', 'process', 'done', 'statusTab', 'filterDate'));
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
        $booking->update(['status' => 'rejected']); 
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