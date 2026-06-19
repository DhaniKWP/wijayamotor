<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
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

        $user = User::find(Auth::id());
        $pendingBooking = session('pending_booking');

        // CEK JIKA BELUM VERIFIKASI (Alur OTP)
        if ($user->email_verified_at === null) {
            $otp = rand(100000, 999999);
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => \Carbon\Carbon::now()->addMinutes(10)
            ]);

            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            session(['otp_verify_email' => $user->email]);
            
            if ($pendingBooking) {
                session(['pending_booking' => $pendingBooking]);
            }

            return redirect()->route('otp.verify')->withErrors(['otp' => 'Akun belum diverifikasi. Silakan masukkan OTP.']);
        }

        // TENTUKAN ARAH REDIRECT BERDASARKAN ROLE
        $url = '/'; // Default customer

        if ($user->role === 'admin') {
            $url = route('admin.dashboard');
        } elseif ($user->role === 'mekanik') {
            $url = route('mekanik.dashboard');
        }

        // JIKA ADA GUEST BOOKING
        if ($pendingBooking) {
            $vehicle = \App\Models\Vehicle::firstOrCreate(
                ['plate_number' => $pendingBooking['plate_number']],
                [
                    'user_id' => $user->id,
                    'name' => $pendingBooking['brand'] . ' ' . $pendingBooking['model'],
                    'year' => $pendingBooking['year'],
                ]
            );

            \App\Models\Booking::create([
                'user_id' => $user->id,
                'vehicle_id' => $vehicle->id,
                'service_id' => 1,
                'tanggal' => $pendingBooking['preferred_date'],
                'jam' => $pendingBooking['preferred_time'],
                'keluhan' => $pendingBooking['complaint'] ?? null,
                'status' => 'pending',
            ]);

            session()->forget('pending_booking');

            return redirect($url)->with('success', 'Login sukses dan jadwal servis Anda telah tercatat!');
        }

        return redirect($url)->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar (Logout).');
    }
}