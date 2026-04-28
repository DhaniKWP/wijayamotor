<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Booking;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'user_id',
        'name',
        'plate_number',
        'year',
    ];

    /**
     * Casting
     */
    protected $casts = [
        'year' => 'integer',
    ];

    // =========================
    // RELASI
    // =========================

    // Kendaraan milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Kendaraan punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // =========================
    // HELPER 🔥
    // =========================

    public function fullName()
    {
        return $this->name . ' - ' . $this->plate_number;
    }
}
