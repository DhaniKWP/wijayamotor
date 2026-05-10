<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\OtpVerificationController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});


Route::get('/verify-otp', [OtpVerificationController::class, 'show'])->name('otp.verify');
Route::post('/verify-otp', [OtpVerificationController::class, 'verify'])->name('otp.verify.post');

Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $user = Illuminate\Support\Facades\Auth::user();
        
        // Ambil mobil milik user
        $vehicles = \App\Models\Vehicle::where('user_id', $user->id)->get();
        
        // Ambil booking milik user, gabungin sama data mobilnya
        $bookings = \App\Models\Booking::where('user_id', $user->id)
                        ->with('vehicle') // Pastiin ada relasi belongsTo di model Booking lu
                        ->orderBy('tanggal', 'asc')
                        ->get();

        return view('dashboard', compact('vehicles', 'bookings'));
    })->name('dashboard')->middleware('role:customer');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware('role:admin');

    Route::get('/mekanik/dashboard', function () {
        return view('mekanik.dashboard');
    })->name('mekanik.dashboard')->middleware('role:mekanik');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('vehicle.create');
    Route::post('/vehicle', [VehicleController::class, 'store'])->name('vehicle.store');
});

require __DIR__.'/auth.php';
