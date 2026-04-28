<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Order;
use App\Models\Booking;

class Payment extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'user_id',
        'booking_id',
        'order_id',
        'amount',
        'payment_method',
        'proof',
        'status',
    ];

    /**
     * Casting
     */
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // =========================
    // RELASI
    // =========================

    // Pembayaran milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Pembayaran untuk booking (servis)
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Pembayaran untuk order (sparepart)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // =========================
    // HELPER STATUS 🔥
    // =========================

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isVerified()
    {
        return $this->status === 'verified';
    }
}
