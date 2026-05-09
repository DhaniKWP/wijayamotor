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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string'],
            'address' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'customer'
        ]);

        event(new Registered($user));

       // 1. Generate 6 digit OTP acak
        $otp = rand(100000, 999999);

        // 2. Simpan OTP ke database dengan expired time (misal: 10 menit)
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ]);

        // 3. Kirim Email OTP
        Mail::to($user->email)->send(new SendOtpMail($otp));

        // 4. Simpan email ke session untuk pengecekan di halaman verifikasi
        session(['otp_verify_email' => $user->email]);

        // Catatan: Baris Auth::login($user); DIHAPUS agar tidak langsung masuk dashboard

        // 5. Redirect ke halaman verifikasi OTP
        return redirect()->route('otp.verify');
    }
}
