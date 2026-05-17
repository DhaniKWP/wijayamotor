<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Service;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman awal pilihan jenis booking (Bengkel / Home Service)
     */
    public function index()
    {
        return view('customer.booking.index');
    }

    /**
     * Menampilkan form booking servis bengkel
     */
    public function create()
    {
        // 1. Ambil data kendaraan khusus milik user yang login
        $vehicles = \App\Models\Vehicle::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
        
        // 2. Ambil data master servis
        $services = \App\Models\Service::all();
        
        return view('customer.booking.create', compact('vehicles', 'services'));
    }

    /**
     * Memproses data form booking ke Database
     */
    public function store(Request $request)
    {
        // 1. Validasi input harus SAMA PERSIS dengan name="..." di HTML
        $validatedData = $request->validate([
            'vehicle_id'       => 'required|exists:vehicles,id',
            'service_category' => 'required|in:berkala,lainnya',
            'km_service'       => 'nullable|integer',
            'addons'           => 'nullable|array',
            'custom_complaint' => 'nullable|string|max:250',
            'branch'           => 'required|string',
            'date'             => 'required|date',
            'time'             => 'required|string',
            'estimasi_harga'   => 'required|numeric',
        ]);

        // JIKA GUEST (Sistem Jaga-jaga kalau tembus tanpa login)
        if (!Auth::check()) {
            session(['pending_booking' => $validatedData]);
            return redirect()->route('register')
                ->withErrors(['email' => 'Silakan buat akun atau login untuk mengonfirmasi jadwal servis.']);
        }

        $user = Auth::user();

        // 2. Simpan Data Booking dengan Kolom Baru
        Booking::create([
            'user_id'        => $user->id,
            'vehicle_id'     => $validatedData['vehicle_id'], // Udah langsung dapet dari radio button Garasi
            'service_id'     => 1, // Biarkan default 1 dulu, atau sesuaikan relasi lu
            
            // Kolom Baru
            'cabang'         => $validatedData['branch'],
            'jenis_servis'   => $validatedData['service_category'],
            'kilometer'      => $validatedData['service_category'] === 'berkala' ? $validatedData['km_service'] : null,
            'addons'         => isset($validatedData['addons']) ? json_encode($validatedData['addons']) : null, // Ubah array Addons ke JSON
            'estimasi_harga' => $validatedData['estimasi_harga'],
            
            // Kolom Lama
            'tanggal'        => $validatedData['date'],
            'jam'            => $validatedData['time'],
            'keluhan'        => $validatedData['service_category'] === 'lainnya' ? $validatedData['custom_complaint'] : null,
            'status'         => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking servis Anda berhasil dibuat!');
    }

    public function createHomeService() {
    $vehicles = \App\Models\Vehicle::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
    return view('customer.booking.home-service', compact('vehicles'));
}
}