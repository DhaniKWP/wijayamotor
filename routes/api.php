<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SparepartController;
use App\Http\Controllers\Api\ServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// --- PUBLIC ROUTES (Tanpa perlu login) ---

// Login untuk mendapatkan token
Route::post('/login', [AuthController::class, 'login']);

// Ambil data master untuk ditampilkan di aplikasi mobile
Route::get('/spareparts', [SparepartController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);


// --- PROTECTED ROUTES (Harus bawa token Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Ambil profil user yang sedang login
    Route::get('/profile', [AuthController::class, 'profile']);
    
    // Logout (hapus token aktif)
    Route::post('/logout', [AuthController::class, 'logout']);

    // TODO: Nanti bisa ditambah rute untuk booking servis, order sparepart, dll.
});
