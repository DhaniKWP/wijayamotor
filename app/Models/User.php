<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// IMPORT MODEL LAIN
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Payment;
use App\Models\MechanicAssignment;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'otp_code',       // <-- Udah ditambahin
        'otp_expires_at', // <-- Udah ditambahin
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime', // <-- Ditambahin biar gampang cek expired
        ];
    }

      // RELASI
      public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    // User punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // User punya banyak order sparepart
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // User punya banyak pembayaran

}