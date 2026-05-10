<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OtpVerificationController extends Controller
{
    public function show()
    {
        // Jika tidak ada session email pendaftar, tendang balik ke register
        if (!session('otp_verify_email')) {
            return redirect()->route('register');
        }
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', session('otp_verify_email'))->first();

        // Cek apakah user ada, OTP cocok, dan belum expired
        if ($user && $user->otp_code == $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
            
            // Verifikasi sukses! 
            $user->update([
                'email_verified_at' => now(), // Tandai email sudah diverifikasi
                'otp_code' => null,           // Hapus OTP agar tidak bisa dipakai lagi
                'otp_expires_at' => null
            ]);

            // Clear session dan login otomatis
            $request->session()->forget('otp_verify_email');
            Auth::login($user);

            // PENANGKAP LAZY REGISTRATION (GUEST BOOKING)
            if (session()->has('pending_booking')) {
                $bookingData = session('pending_booking');
                
                // 1. Simpan/Ambil Kendaraan
                $vehicle = Vehicle::firstOrCreate(
                    ['plate_number' => $bookingData['plate_number']],
                    [
                        'user_id' => $user->id,
                        'name' => $bookingData['brand'] . ' ' . $bookingData['model'],
                        'year' => date('Y'),
                    ]
                );

                // 2. Simpan Booking
                Booking::create([
                    'user_id' => $user->id,
                    'vehicle_id' => $vehicle->id,
                    'service_id' => 1, // Nanti ganti sesuai ID asli
                    'tanggal' => $bookingData['preferred_date'],
                    'jam' => $bookingData['preferred_time'],
                    'keluhan' => $bookingData['complaint'] ?? null,
                    'status' => 'pending',
                ]);

                // 3. Bersihkan Session
                session()->forget('pending_booking');

                return redirect()->route('dashboard')->with('success', 'Akun dibuat dan Booking langsung terkonfirmasi!');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
    }
}