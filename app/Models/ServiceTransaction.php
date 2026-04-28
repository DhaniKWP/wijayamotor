<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Booking;
use App\Models\ServiceTransactionItem;
use App\Models\Payment;

class ServiceTransaction extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'booking_id',
        'service_cost',
        'sparepart_cost',
        'total_cost',
        'payment_status',
        'payment_method',
    ];

    /**
     * Casting
     */
    protected $casts = [
        'service_cost' => 'decimal:2',
        'sparepart_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    // =========================
    // RELASI
    // =========================

    // Transaksi milik booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Transaksi punya banyak item (sparepart tambahan)
    public function items()
    {
        return $this->hasMany(ServiceTransactionItem::class, 'transaction_id');
    }

    // Transaksi punya pembayaran
    public function payments()
    {
        return $this->hasMany(Payment::class, 'booking_id', 'booking_id');
    }

    // =========================
    // HELPER (STATUS)
    // =========================

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    // =========================
    // LOGIC (HITUNG TOTAL) 🔥
    // =========================

    public function calculateTotal()
    {
        $sparepartTotal = $this->items()->sum('subtotal');

        $this->sparepart_cost = $sparepartTotal;
        $this->total_cost = $this->service_cost + $sparepartTotal;

        $this->save();
    }
}
