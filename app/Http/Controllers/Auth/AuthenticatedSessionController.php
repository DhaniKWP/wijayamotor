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

        // --- CEK JIKA BELUM VERIFIKASI ---
        if ($user->email_verified_at === null) {
            
            // 1. Generate OTP baru 
            $otp = rand(100000, 999999);
            
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => \Carbon\Carbon::now()->addMinutes(10)
            ]);

            // 2. Kirim ulang email OTP
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\SendOtpMail($otp));

            // 3. LOGOUT-KAN DULU DAN BERSIHKAN SESSION LAMA
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // 4. BARU SIMPAN SESSION EMAIL OTP DI SINI (Setelah dibersihkan)
            session(['otp_verify_email' => $user->email]);

            // 5. Tendang ke halaman verifikasi OTP
            return redirect()->route('otp.verify')->withErrors(['otp' => 'Akun belum diverifikasi. Kami telah mengirimkan OTP baru ke email Anda.']);
        }
        // --- BATAS TAMBAHAN ---

        return redirect()->intended(route('dashboard', absolute: false));
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