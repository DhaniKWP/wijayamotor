<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Service;

class BookingController extends Controller
{
    public function create(Request $request)
{
    $vihicles = Auth::check() ? Vehicle::where("user_id", Auth::id())->get() : collect();
    $services = Service::all();

    return view('booking.create', compact('vihicles', 'services'));
}

public function store(Request $request)
    {
        // Sesuaikan validasi dengan nama input di form HTML lu
        $validatedData = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'plate_number' => 'required|string',
            'service_type' => 'required|string', 
            'preferred_date' => 'required|date',
            'preferred_time' => 'required|string',
            'complaint' => 'nullable|string',
        ]);

        // JIKA GUEST (BELUM LOGIN)
        if (!Auth::check()) {
            // Simpan ke session
            session(['pending_booking' => $validatedData]);
            
            // Tendang ke register
            return redirect()->route('register')
                ->withErrors(['email' => 'Silakan buat akun atau login untuk mengonfirmasi jadwal servis Anda.']);
        }

        // JIKA SUDAH LOGIN
        $user = Auth::user();

        // 1. Simpan atau Ambil Data Kendaraan
        $vehicle = Vehicle::firstOrCreate(
            ['plate_number' => $validatedData['plate_number']],
            [
                'user_id' => $user->id,
                'name' => $validatedData['brand'] . ' ' . $validatedData['model'],
                'year' => date('Y'),
            ]
        );

        // 2. Simpan Data Booking
        Booking::create([
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'service_id' => 1, // Nanti ganti pakai ID aslinya ($validatedData['service_type'])
            'tanggal' => $validatedData['preferred_date'],
            'jam' => $validatedData['preferred_time'],
            'keluhan' => $validatedData['complaint'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat!');
    }
}
