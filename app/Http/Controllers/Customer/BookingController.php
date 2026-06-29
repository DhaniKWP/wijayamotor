<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Service;
use App\Http\Controllers\Controller;

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
        $user = Auth::user();
        if (empty($user->phone) || empty($user->address)) {
            return redirect()->route('customer.profile.settings')->with('info', 'Silakan lengkapi nomor HP dan alamat Anda sebelum melakukan booking.');
        }

        $vehicles = \App\Models\Vehicle::where('user_id', Auth::id())->get();
        
        // Ambil SEMUA data master servis untuk dilempar ke Alpine.js
        $services = \App\Models\Service::all();
        
        return view('customer.booking.create', compact('vehicles', 'services'));
    }

    /**
     * Menampilkan form booking Home Service
     */
    public function createHomeService()
    {
        $user = Auth::user();
        if (empty($user->phone) || empty($user->address)) {
            return redirect()->route('customer.profile.settings')->with('info', 'Silakan lengkapi nomor HP dan alamat Anda sebelum melakukan booking Home Service.');
        }

        // Ambil data kendaraan khusus milik user yang login
        $vehicles = Vehicle::where('user_id', Auth::id())->get();
        
        // Ambil data servis buat jaga-jaga kalau form Home Service butuh milih servis
        $services = Service::all();
        
        // Lempar ke view home-service
        return view('customer.booking.home-service', compact('vehicles', 'services'));
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
            'sesi'             => 'required|in:pagi,siang',
            'estimasi_harga'   => 'required|numeric',
            'branch'           => 'required',
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

        // ==========================================
        // PENGECEKAN KUOTA DI BACKEND
        // ==========================================
        $currentCount = Booking::where('tanggal', $request->date)
                            ->where('sesi', $request->sesi)
                            ->where('status', '!=', 'cancelled')
                            ->count();
        
        $maxQuota = 4;
        if ($currentCount >= $maxQuota) {
            return back()->withErrors(['sesi' => 'Maaf, Sesi ' . ucfirst($request->sesi) . ' di tanggal tersebut sudah penuh. Silakan pilih sesi atau tanggal lain.'])->withInput();
        }

        // 4. Siapkan data Addons / Perbaikan Umum untuk disimpan jadi JSON
        $addonsData = null;
        if ($request->service_category === 'berkala' && $request->has('addons')) {
            $addonsData = json_encode($request->addons);
        } elseif ($request->service_category === 'umum' && $request->has('general_repairs')) {
            $addonsData = json_encode($request->general_repairs); 
        }

        // ==========================================
        // PERBAIKAN LOGIKA PENENTUAN SERVICE ID
        // ==========================================
        // Kita ambil ID servis pertama yang ada di database sebagai "Fallback/Default"
        // Biar nggak error Foreign Key kalau formnya nggak ngirim ID.
        $defaultService = Service::first();
        
        if (!$defaultService) {
            // Kalau admin bener-bener belum bikin data servis, kasih peringatan!
            return back()->withErrors(['service_id' => 'Sistem belum memiliki Master Servis. Harap hubungi Admin.'])->withInput();
        }

        // Kalau form ngirim 'service_id', pakai itu. Kalau nggak, pakai ID servis pertama.
        $finalServiceId = $request->filled('service_id') ? $request->service_id : $defaultService->id;
        // ==========================================

        // 5. Masukkan ke Database
        Booking::create([
            'user_id'        => Auth::id(),
            'vehicle_id'     => $request->vehicle_id,
            
            // INI YANG BIKIN AMAN
            'service_id'     => $finalServiceId, 
            
            // Pembeda Utama
            'tipe_booking'   => $isHomeService ? 'home_service' : 'bengkel',
            'cabang'         => $isHomeService ? null : $request->branch,
            'alamat_lengkap' => $isHomeService ? $request->alamat_lengkap : null,
            
            // Detail Servis
            'jenis_servis'   => $request->service_category,
            'kilometer'      => $request->service_category === 'berkala' ? (int) str_replace('.', '', $request->km_service) : null,
            'addons'         => $addonsData,
            'estimasi_harga' => $request->estimasi_harga,
            
            // Jadwal & Lainnya
            'tanggal'        => $request->date,
            'jam'            => null, // Jam diganti sesi
            'sesi'           => $request->sesi,
            'keluhan'        => $request->service_category === 'lainnya' ? $request->custom_complaint : '-',
            'status'         => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat!');
    }

    /**
     * API untuk cek ketersediaan kuota berdasarkan tanggal
     */
    public function checkQuota(Request $request)
    {
        $date = $request->query('date');
        
        if (!$date) {
            return response()->json(['error' => 'Date is required'], 400);
        }

        // Hitung booking yang ada di tanggal tersebut dan statusnya bukan cancelled
        $pagiCount = Booking::where('tanggal', $date)
                            ->where('sesi', 'pagi')
                            ->where('status', '!=', 'cancelled')
                            ->count();
                            
        $siangCount = Booking::where('tanggal', $date)
                             ->where('sesi', 'siang')
                             ->where('status', '!=', 'cancelled')
                             ->count();

        // Asumsi kuota aman adalah 4 per sesi (Total 8 per hari)
        $maxQuota = 4;

        return response()->json([
            'pagi' => [
                'count' => $pagiCount,
                'is_full' => $pagiCount >= $maxQuota,
                'label' => 'Sesi Pagi (08:00 - 12:00)'
            ],
            'siang' => [
                'count' => $siangCount,
                'is_full' => $siangCount >= $maxQuota,
                'label' => 'Sesi Siang (13:00 - 16:00)'
            ]
        ]);
    }

    public function edit($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($booking->status !== 'pending') {
            return redirect()->route('dashboard')->withErrors(['error' => 'Hanya booking berstatus pending yang dapat diedit.']);
        }
        
        $vehicles = Vehicle::where('user_id', Auth::id())->get();
        $services = Service::all();
        
        if ($booking->tipe_booking === 'home_service') {
            return view('customer.booking.home-service', compact('booking', 'vehicles', 'services'));
        }
        
        return view('customer.booking.create', compact('booking', 'vehicles', 'services'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($booking->status !== 'pending') {
            return redirect()->route('dashboard')->withErrors(['error' => 'Hanya booking berstatus pending yang dapat diedit.']);
        }

        $isHomeService = $request->input('tipe_booking') === 'home_service';

        $rules = [
            'vehicle_id'       => 'required|exists:vehicles,id',
            'service_category' => 'required|in:berkala,lainnya,umum',
            'date'             => 'required|date',
            'sesi'             => 'required|in:pagi,siang',
            'estimasi_harga'   => 'required|numeric',
        ];

        if ($isHomeService) {
            $rules['alamat_lengkap'] = 'required|string';
        } else {
            $rules['branch'] = 'required|string';
        }

        $validatedData = $request->validate($rules);

        if ($request->date !== $booking->tanggal || $request->sesi !== $booking->sesi) {
            $currentCount = Booking::where('tanggal', $request->date)
                                ->where('sesi', $request->sesi)
                                ->where('status', '!=', 'cancelled')
                                ->count();
            
            $maxQuota = 4;
            if ($currentCount >= $maxQuota) {
                return back()->withErrors(['sesi' => 'Maaf, Sesi ' . ucfirst($request->sesi) . ' di tanggal tersebut sudah penuh. Silakan pilih sesi atau tanggal lain.'])->withInput();
            }
        }

        $addonsData = null;
        if ($request->service_category === 'berkala' && $request->has('addons')) {
            $addonsData = json_encode($request->addons);
        } elseif ($request->service_category === 'umum' && $request->has('general_repairs')) {
            $addonsData = json_encode($request->general_repairs); 
        }

        $defaultService = Service::first();
        $finalServiceId = $request->filled('service_id') ? $request->service_id : ($defaultService ? $defaultService->id : $booking->service_id);

        $booking->update([
            'vehicle_id'     => $request->vehicle_id,
            'service_id'     => $finalServiceId, 
            'tipe_booking'   => $isHomeService ? 'home_service' : 'bengkel',
            'cabang'         => $isHomeService ? null : $request->branch,
            'alamat_lengkap' => $isHomeService ? $request->alamat_lengkap : null,
            'jenis_servis'   => $request->service_category,
            'kilometer'      => $request->service_category === 'berkala' ? (int) str_replace('.', '', $request->km_service) : null,
            'addons'         => $addonsData,
            'estimasi_harga' => $request->estimasi_harga,
            'tanggal'        => $request->date,
            'sesi'           => $request->sesi,
            'keluhan'        => $request->service_category === 'lainnya' ? $request->custom_complaint : '-',
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil diperbarui!');
    }

    public function cancel($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking berstatus pending yang dapat dibatalkan.']);
        }
        
        $booking->update(['status' => 'cancelled']);
        
        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}