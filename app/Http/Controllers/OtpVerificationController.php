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

        if ($user && $user->otp_code == $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
            
            $user->update([
                'email_verified_at' => now(), 
                'otp_code' => null,           
                'otp_expires_at' => null
            ]);

            $request->session()->forget('otp_verify_email');
            Auth::login($user);

            // TENTUKAN ARAH REDIRECT BERDASARKAN ROLE
            $url = route('dashboard'); // Default customer
            if ($user->role === 'admin') {
                $url = route('admin.dashboard');
            } elseif ($user->role === 'mekanik') {
                $url = route('mekanik.dashboard');
            }

            // PENANGKAP LAZY REGISTRATION (GUEST BOOKING)
            if (session()->has('pending_booking')) {
                $bookingData = session('pending_booking');
                
                $vehicle = Vehicle::firstOrCreate(
                    ['plate_number' => $bookingData['plate_number']],
                    [
                        'user_id' => $user->id,
                        'name' => $bookingData['brand'] . ' ' . $bookingData['model'],
                        'year' => $bookingData['year'],
                    ]
                );

                Booking::create([
                    'user_id' => $user->id,
                    'vehicle_id' => $vehicle->id,
                    'service_id' => 1, 
                    'tanggal' => $bookingData['preferred_date'],
                    'jam' => $bookingData['preferred_time'],
                    'keluhan' => $bookingData['complaint'] ?? null,
                    'status' => 'pending',
                ]);

                session()->forget('pending_booking');

                return redirect()->intended($url)->with('success', 'Akun dibuat dan Booking langsung terkonfirmasi!');
            }

            return redirect()->intended($url);
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
    }
}