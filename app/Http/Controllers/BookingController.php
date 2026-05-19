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
     * Menampilkan form booking Home Service (INI YANG TADI HILANG)
     */
    public function createHomeService()
    {
        // Ambil data kendaraan khusus milik user yang login
        $vehicles = \App\Models\Vehicle::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
        
        // Lempar ke view home-service
        return view('customer.booking.home-service', compact('vehicles'));
    }

    /**
     * Memproses data form booking ke Database
     */
    public function store(Request $request)
    {
        // 1. Cek ini booking Home Service atau Bengkel biasa
        $isHomeService = $request->input('tipe_booking') === 'home_service';

        // 2. Siapkan aturan validasi dasar
        $rules = [
            'vehicle_id'       => 'required|exists:vehicles,id',
            'service_category' => 'required|in:berkala,lainnya,umum',
            'date'             => 'required|date',
            'time'             => 'required|string',
            'estimasi_harga'   => 'required|numeric',
        ];

        // 3. Validasi dinamis: Kalau Bengkel wajib pilih Cabang, kalau Home Service wajib isi Alamat
        if ($isHomeService) {
            $rules['alamat_lengkap'] = 'required|string';
        } else {
            $rules['branch'] = 'required|string';
        }

        $validatedData = $request->validate($rules);

        // JIKA GUEST (Belum Login)
        if (!Auth::check()) {
            session(['pending_booking' => $request->all()]);
            return redirect()->route('register')
                ->withErrors(['email' => 'Silakan buat akun atau login untuk mengonfirmasi jadwal servis.']);
        }

        // 4. Siapkan data Addons / Perbaikan Umum untuk disimpan jadi JSON
        $addonsData = null;
        if ($request->service_category === 'berkala' && $request->has('addons')) {
            $addonsData = json_encode($request->addons);
        } elseif ($request->service_category === 'umum' && $request->has('general_repairs')) {
            $addonsData = json_encode($request->general_repairs); // Simpan pilihan Engine Oil, dll
        }

        // LOGIKA PENENTUAN SERVICE ID OTOMATIS
        $serviceIdMapped = 1; // Default Servis Berkala
        if ($request->service_category === 'umum') {
            $serviceIdMapped = 2;
        } elseif ($request->service_category === 'lainnya') {
            $serviceIdMapped = 3;
        }

        // 5. Masukkan ke Database
        Booking::create([
            'user_id'        => Auth::id(),
            'vehicle_id'     => $request->vehicle_id,
            
            // INI YANG DIUBAH, NGGAK LAGI HARDCODE ANGKA 1
            'service_id'     => $serviceIdMapped, 
            
            // Pembeda Utama
            'tipe_booking'   => $isHomeService ? 'home_service' : 'bengkel',
            'cabang'         => $isHomeService ? null : $request->branch,
            'alamat_lengkap' => $isHomeService ? $request->alamat_lengkap : null,
            
            // Detail Servis (Di sini detail ganti oli, dll udah aman kesimpen)
            'jenis_servis'   => $request->service_category,
            'kilometer'      => $request->service_category === 'berkala' ? $request->km_service : null,
            'addons'         => $addonsData,
            'estimasi_harga' => $request->estimasi_harga,
            
            // Jadwal & Lainnya
            'tanggal'        => $request->date,
            'jam'            => $request->time,
            'keluhan'        => $request->service_category === 'lainnya' ? $request->custom_complaint : '-',
            'status'         => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat!');
    }
}