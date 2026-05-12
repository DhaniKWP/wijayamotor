<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\OtpVerificationController;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'mekanik') {
            return redirect()->route('mekanik.dashboard');
        }
        
        // Default untuk customer
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/verify-otp', [OtpVerificationController::class, 'show'])->name('otp.verify');
Route::post('/verify-otp', [OtpVerificationController::class, 'verify'])->name('otp.verify.post');

Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// =========================================
// ROUTE KHUSUS CUSTOMER
// =========================================
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $vehicles = \App\Models\Vehicle::where('user_id', $user->id)->get();
        $bookings = \App\Models\Booking::where('user_id', $user->id)
                        ->with('vehicle')
                        ->orderBy('tanggal', 'asc')
                        ->get();

        return view('dashboard', compact('vehicles', 'bookings'));
    })->name('dashboard');

    Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');
    Route::post('/vehicle', [VehicleController::class, 'store'])->name('vehicle.store');
});

// =========================================
// ROUTE KHUSUS ADMIN
// =========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        // Ambil semua data servis buat ditampilin di tabel admin
        $services = \App\Models\Service::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('services'));
    })->name('dashboard');
    
    Route::post('/services', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_estimate' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        \App\Models\Service::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Data servis berhasil ditambahkan!');
    })->name('services.store');

});

// =========================================
// ROUTE KHUSUS MEKANIK
// =========================================
Route::middleware(['auth', 'role:mekanik'])->group(function () {
    Route::get('/mekanik/dashboard', function () {
        return view('mekanik.dashboard');
    })->name('mekanik.dashboard');
});

// =========================================
// ROUTE PROFILE (Bawaan Breeze)
// =========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';