<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Statistik
        $pendingCount = Booking::where('status', 'pending')->count();
        $todayCount = Booking::whereDate('tanggal', Carbon::today())->count(); 
        $processCount = Booking::where('status', 'process')->count();
        $doneMonthCount = Booking::where('status', 'done')
                                ->whereMonth('updated_at', Carbon::now()->month)
                                ->count();

        // 2. Query Data dengan Filter
        // Tambahkan relasi user dan vehicle agar bisa dipanggil di view
        $query = Booking::with(['user', 'vehicle', 'service'])->orderBy('tanggal', 'asc')->orderBy('jam', 'asc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15);

        // 3. Return view
        return view('admin.dashboard', compact(
            'bookings', 
            'pendingCount', 
            'todayCount', 
            'processCount', 
            'doneMonthCount'
        ));
    }

    public function accept($id)
    {
        $booking = Booking::findOrFail($id);
        // Sesuaikan dengan enum migration
        $booking->update(['status' => 'confirmed']); 
        return redirect()->back()->with('success', 'Booking berhasil disetujui.');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        // Sesuaikan dengan enum migration
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