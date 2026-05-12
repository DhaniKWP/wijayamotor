<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * Kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
     * Disesuaikan dengan migration lu.
     */
    protected $fillable = [
        'name',
        'description',
        'price_estimate',
    ];

    // =========================
    // RELASI
    // =========================

    // 1 Jenis servis bisa dipakai di banyak data booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}