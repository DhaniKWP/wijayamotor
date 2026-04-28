<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\OrderItem;
use App\Models\Payment;

class Order extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
    ];

    /**
     * Casting
     */
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // =========================
    // RELASI
    // =========================

    // Order milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Order punya banyak item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order punya pembayaran
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // =========================
    // HELPER STATUS 🔥
    // =========================

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isShipped()
    {
        return $this->status === 'shipped';
    }

    public function isDone()
    {
        return $this->status === 'done';
    }
}
