<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OtpVerificationController;

// =========================================
// IMPORT CONTROLLER DENGAN ALIAS AGAR TIDAK BENTROK
// =========================================
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController; // Ini untuk Admin
use App\Http\Controllers\Customer\VehicleController;
use App\Http\Controllers\Customer\SparepartController as CustomerSparepartController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SparepartController as AdminSparepartController;

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

// PAKE CUSTOMER BOOKING CONTROLLER
Route::get('/booking', [CustomerBookingController::class, 'index'])->name('booking.index');
Route::get('/booking/create', [CustomerBookingController::class, 'create'])->name('booking.create');
Route::get('/home-service', [CustomerBookingController::class, 'createHomeService'])->name('booking.homeservice');
Route::post('/booking', [CustomerBookingController::class, 'store'])->name('booking.store');

// ROUTE AKSESORIS PAKE CONTROLLER CUSTOMER
Route::get('/aksesoris', [CustomerSparepartController::class, 'index'])->name('sparepart.index');
Route::get('/aksesoris/{id}', [CustomerSparepartController::class, 'show'])->name('sparepart.show');

// =========================================
// ROUTE KHUSUS CUSTOMER
// =========================================
Route::middleware(['auth', 'role:customer'])->group(function () {
    
   // Dashboard Utama Customer
    Route::get('/dashboard', function () {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $vehicles = \App\Models\Vehicle::where('user_id', $user->id)->get();
        
        $bookings = \App\Models\Booking::where('user_id', $user->id)
                        ->with('vehicle')
                        ->orderBy('tanggal', 'asc')
                        ->get();

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
// =========================================
// ROUTE KHUSUS ADMIN
// =========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // DASHBOARD REKAPAN
    Route::get('/dashboard', [AdminBookingController::class, 'dashboard'])->name('dashboard');
    
    // MANAJEMEN BOOKING
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings/{id}/accept', [AdminBookingController::class, 'accept'])->name('bookings.accept');
    Route::post('/bookings/{id}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{id}/process', [AdminBookingController::class, 'process'])->name('bookings.process');
    Route::post('/bookings/{id}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');

    // Route Master Servis
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // MASTER SPAREPART PAKE CONTROLLER ADMIN
    Route::get('/spareparts', [AdminSparepartController::class, 'index'])->name('spareparts.index');
    Route::post('/spareparts', [AdminSparepartController::class, 'store'])->name('spareparts.store');
    Route::put('/spareparts/{id}', [AdminSparepartController::class, 'update'])->name('spareparts.update');
    Route::delete('/spareparts/{id}', [AdminSparepartController::class, 'destroy'])->name('spareparts.destroy');

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