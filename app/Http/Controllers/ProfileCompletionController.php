<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileCompletionController extends Controller
{
    public function edit()
    {
        // Jika sudah lengkap, redirect ke dashboard
        $user = Auth::user();
        if ($user->phone && $user->address) {
            return redirect()->route('user.dashboard');
        }

        return view('profile.complete');
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ], [
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        $user = Auth::user();
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('user.dashboard')->with('success', 'Data diri berhasil dilengkapi!');
    }
}
