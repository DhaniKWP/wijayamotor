<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\OtpVerificationController;
use App\Http\Controllers\Admin\SparepartController;
use App\Http\Controllers\Admin\ServiceController;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }
    return view('welcome');
});

Route::get('/verify-otp', [OtpVerificationController::class, 'show'])->name('otp.verify');
Route::post('/verify-otp', [OtpVerificationController::class, 'verify'])->name('otp.verify.post');

Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::get('/home-service', [BookingController::class, 'createHomeService'])->name('booking.homeservice');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// =========================================
// ROUTE KHUSUS CUSTOMER
// =========================================
Route::middleware(['auth', 'role:customer'])->group(function () {
    
   // Dashboard Utama Customer
    Route::get('/dashboard', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // 1. Ambil data kendaraan user
        $vehicles = \App\Models\Vehicle::where('user_id', $user->id)->get();
        
        // 2. Ambil data tiket booking user (INI YANG TADI HILANG)
        $bookings = \App\Models\Booking::where('user_id', $user->id)
                        ->with('vehicle')
                        ->orderBy('tanggal', 'asc')
                        ->get();

        // 3. Lempar kedua data ke view dashboard
        return view('customer.dashboard', compact('vehicles', 'bookings'));
    })->name('dashboard');
    // FITUR GARASI SAYA
    Route::get('/garasi', [VehicleController::class, 'index'])->name('garasi.index');
    Route::post('/garasi', [VehicleController::class, 'store'])->name('garasi.store');
    Route::delete('/garasi/{id}', [VehicleController::class, 'destroy'])->name('garasi.destroy');

});

// =========================================
// ROUTE KHUSUS ADMIN
// =========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [ServiceController::class, 'index'])->name('dashboard');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // =========================================
    // MASTER SPAREPART
    // =========================================
    Route::get('/spareparts', [SparepartController::class, 'index'])->name('spareparts.index');
    Route::post('/spareparts', [SparepartController::class, 'store'])->name('spareparts.store');
    Route::put('/spareparts/{id}', [SparepartController::class, 'update'])->name('spareparts.update');
    Route::delete('/spareparts/{id}', [SparepartController::class, 'destroy'])->name('spareparts.destroy');

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