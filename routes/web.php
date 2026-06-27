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
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\OrderController;
use App\Models\Sparepart;
use App\Http\Controllers\Customer\CartController;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }

    $featuredSpareparts = Sparepart::where('stock', '>', 0)
                            ->latest()
                            ->take(8)
                            ->get();

    return view('welcome', compact('featuredSpareparts'));
});

Route::get('/verify-otp', [OtpVerificationController::class, 'show'])->name('otp.verify');
Route::post('/verify-otp', [OtpVerificationController::class, 'verify'])->name('otp.verify.post');

// PAKE CUSTOMER BOOKING CONTROLLER
Route::get('/booking', [CustomerBookingController::class, 'index'])->name('booking.index');
Route::get('/booking/create', [CustomerBookingController::class, 'create'])->name('booking.create');
Route::get('/home-service', [CustomerBookingController::class, 'createHomeService'])->name('booking.homeservice');
Route::post('/booking', [CustomerBookingController::class, 'store'])->name('booking.store');
Route::get('/api/check-quota', [CustomerBookingController::class, 'checkQuota'])->name('api.check_quota');
Route::get('/booking/{id}/edit', [CustomerBookingController::class, 'edit'])->name('booking.edit');
Route::put('/booking/{id}', [CustomerBookingController::class, 'update'])->name('booking.update');
Route::put('/booking/{id}/cancel', [CustomerBookingController::class, 'cancel'])->name('booking.cancel');

// ROUTE AKSESORIS PAKE CONTROLLER CUSTOMER
Route::get('/aksesoris', [CustomerSparepartController::class, 'index'])->name('sparepart.index');
Route::get('/aksesoris/{id}', [CustomerSparepartController::class, 'show'])->name('sparepart.show');

// ROUTE LOKASI BENGKEL (public)
Route::get('/lokasi', function () {
    return view('lokasi');
})->name('lokasi');

// ROUTE ARTIKEL TIPS & BERITA
Route::get('/artikel/kampas-rem', function () {
    return view('artikel.kampas-rem');
})->name('artikel.kampas-rem');

Route::get('/artikel/oli-gardan-transmisi', function () {
    return view('artikel.oli-gardan-transmisi');
})->name('artikel.oli-gardan-transmisi');

Route::get('/artikel/scan-kendaraan', function () {
    return view('artikel.scan-kendaraan');
})->name('artikel.scan-kendaraan');

Route::get('/artikel', function () {
    return view('artikel.index');
})->name('artikel.index');

// =========================================
// ROUTE KHUSUS CUSTOMER
// =========================================
Route::middleware(['auth', 'role:customer'])->group(function () {
    
    // Dashboard Ringkasan Akun
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pesanan Saya (halaman baru) — tab Servis & Sparepart
    Route::get('/pesanan-saya', [DashboardController::class, 'pesanan'])->name('customer.pesanan');

    // KERANJANG & CHECKOUT SPAREPART
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::put('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/keranjang/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // ORDER LANGSUNG (Beli Sekarang)
    Route::post('/order', [OrderController::class, 'store'])->name('customer.order.store');

    // ORDER SUCCESS
    Route::get('/order/{id}/sukses', [OrderController::class, 'success'])->name('customer.order.success');

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

    // WORK ORDER & TRANSAKSI SERVIS
    Route::get('/bookings/{id}/complete-form', [TransactionController::class, 'showCompleteForm'])->name('bookings.complete.form');
    Route::post('/bookings/{id}/complete-transaction', [TransactionController::class, 'store'])->name('bookings.complete.transaction');
    Route::get('/bookings/{id}/invoice', [TransactionController::class, 'invoice'])->name('bookings.invoice');
    Route::post('/bookings/{id}/mark-paid', [TransactionController::class, 'markPaid'])->name('bookings.mark.paid');

    // Route Master Servis
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // MASTER SPAREPART PAKE CONTROLLER ADMIN
    Route::get('/spareparts', [AdminSparepartController::class, 'index'])->name('spareparts.index');
    Route::post('/spareparts', [AdminSparepartController::class, 'store'])->name('spareparts.store');
    Route::put('/spareparts/{id}', [AdminSparepartController::class, 'update'])->name('spareparts.update');
    Route::post('/spareparts/{id}/add-stock', [AdminSparepartController::class, 'addStock'])->name('spareparts.add_stock');
    Route::delete('/spareparts/{id}', [AdminSparepartController::class, 'destroy'])->name('spareparts.destroy');

    // PESANAN SPAREPART (Order dari customer)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{id}/mark-done', [AdminOrderController::class, 'markDone'])->name('orders.mark.done');
    Route::get('/orders/{id}/struk', [AdminOrderController::class, 'struk'])->name('orders.struk');

    // LAPORAN KEUANGAN
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [ReportController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/export-pdf', [ReportController::class, 'exportPdf'])->name('laporan.export.pdf');

});

// =========================================
// ROUTE PROFILE (Bawaan Breeze)
// =========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================================
// ROUTE CHATBOT WIRA (PUBLIC)
// =========================================
use App\Http\Controllers\ChatbotController;
Route::post('/chatbot/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat');

require __DIR__.'/auth.php';