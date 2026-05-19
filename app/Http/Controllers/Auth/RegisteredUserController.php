<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\SendOtpMail;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi: HAPUS rule 'unique' di email
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Cek apakah email sudah ada di database
        $existingUser = User::where('email', $request->email)->first();

        // Siapkan OTP dan waktu expired
        $otp = rand(100000, 999999);
        $otpExpires = Carbon::now()->addMinutes(10);

        if ($existingUser) {
            // Jika akun SUDAH VERIFIED
            if ($existingUser->email_verified_at !== null) {
                throw ValidationException::withMessages([
                    'email' => 'Email ini sudah terdaftar dan terverifikasi. Silakan langsung ke menu Login.',
                ]);
            }

            // Jika akun BELUM VERIFIED (User kabur dari halaman OTP dan nyoba register ulang)
            // Update datanya pakai inputan terbaru + OTP baru
            $existingUser->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'otp_code' => $otp,
                'otp_expires_at' => $otpExpires,
            ]);

            $user = $existingUser;

        } else {
            // 3. Jika email BENER-BENER BARU, buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'role' => 'customer',
                'password' => Hash::make($request->password),
                'otp_code' => $otp,
                'otp_expires_at' => $otpExpires,
            ]);
        }

        // 4. Kirim email OTP (Pake fungsi yang udah lu buat)
        Mail::to($user->email)->send(new SendOtpMail($otp));

        // 5. SELAMATKAN DATA BOOKING SEMENTARA
        $pendingBooking = session('pending_booking');

        // BISA JADI DI SINI ADA AUTH::LOGIN ATAU SESSION INVALIDATE
        // (Pastikan ini dijalankan setelah proses bikin user selesai)

        // 6. SIMPAN SESSION UNTUK HALAMAN OTP DAN KEMBALIKAN DATA BOOKING
        session(['otp_verify_email' => $user->email]);
        if ($pendingBooking) {
            session(['pending_booking' => $pendingBooking]);
        }

        // 7. Lempar ke halaman Verifikasi OTP
        return redirect()->route('otp.verify');
    }
}