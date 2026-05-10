<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User; // <-- TAMBAHKAN IMPORT INI
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = \App\Models\User::find(Auth::id());

        // 1. Ambil data booking dari session (jika ada)
        $pendingBooking = session('pending_booking');

        // 2. CEK JIKA BELUM VERIFIKASI (Alur OTP)
        if ($user->email_verified_at === null) {
            $otp = rand(100000, 999999);
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => \Carbon\Carbon::now()->addMinutes(10)
            ]);

            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

            // Logout sementara untuk verifikasi
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            session(['otp_verify_email' => $user->email]);
            
            // Simpan kembali data booking agar tidak hilang saat session di-invalidate
            if ($pendingBooking) {
                session(['pending_booking' => $pendingBooking]);
            }

            return redirect()->route('otp.verify')->withErrors(['otp' => 'Akun belum diverifikasi. Silakan masukkan OTP.']);
        }

        // 3. JIKA SUDAH VERIFIKASI (LOGIN BERHASIL)
        // Kita cek: Apakah dia login setelah ngisi form booking?
        if ($pendingBooking) {
            // Simpan Kendaraan
            $vehicle = \App\Models\Vehicle::firstOrCreate(
                ['plate_number' => $pendingBooking['plate_number']],
                [
                    'user_id' => $user->id,
                    'name' => $pendingBooking['brand'] . ' ' . $pendingBooking['model'],
                    'year' => $pendingBooking['year'],
                ]
            );

            // Simpan Booking
            \App\Models\Booking::create([
                'user_id' => $user->id,
                'vehicle_id' => $vehicle->id,
                'service_id' => 1, // Sesuaikan ID service
                'tanggal' => $pendingBooking['preferred_date'],
                'jam' => $pendingBooking['preferred_time'],
                'keluhan' => $pendingBooking['complaint'] ?? null,
                'status' => 'pending',
            ]);

            // Hapus session titipan
            session()->forget('pending_booking');

            return redirect()->intended(route('dashboard'))->with('success', 'Login sukses dan jadwal servis Anda telah tercatat!');
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}