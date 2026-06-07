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
        'service_cost',    // Total biaya JASA (service utama + jasa tambahan)
        'sparepart_cost',  // Total biaya SPAREPART yang dipakai
        'total_cost',      // service_cost + sparepart_cost
        'payment_status',  // 'pending' | 'paid'
        'payment_method',  // 'cash' | 'transfer' | null
    ];

    /**
     * Casting
     */
    protected $casts = [
        'service_cost'   => 'decimal:2',
        'sparepart_cost' => 'decimal:2',
        'total_cost'     => 'decimal:2',
    ];

    // =========================
    // RELASI
    // =========================

    /** Transaksi milik booking */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /** Semua item (sparepart + jasa tambahan) */
    public function items()
    {
        return $this->hasMany(ServiceTransactionItem::class, 'transaction_id');
    }

    /** Hanya item bertipe sparepart */
    public function sparepartItems()
    {
        return $this->hasMany(ServiceTransactionItem::class, 'transaction_id')
                    ->where('item_type', 'sparepart');
    }

    /** Hanya item bertipe jasa tambahan */
    public function jasaItems()
    {
        return $this->hasMany(ServiceTransactionItem::class, 'transaction_id')
                    ->where('item_type', 'jasa');
    }

    /** Pembayaran terkait */


    // =========================
    // HELPER (STATUS)
    // =========================

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    // =========================
    // LOGIC — HITUNG TOTAL 🔥
    // Pisahkan biaya jasa dan sparepart secara akurat
    // =========================

    public function calculateTotal(): void
    {
        // Total dari item bertipe 'jasa' (jasa tambahan manual)
        $jasaTotal = $this->items()->where('item_type', 'jasa')->sum('subtotal');

        // Total dari item bertipe 'sparepart'
        $sparepartTotal = $this->items()->where('item_type', 'sparepart')->sum('subtotal');

        // service_cost = harga service utama (dari booking) + jasa tambahan
        // Nilai service_cost dari service utama sudah diset saat create transaksi,
        // jadi kita tambahkan jasaTotal ke atasnya
        // CATATAN: Kalau mau re-kalkulasi penuh, set service_cost fresh dari luar
        $this->sparepart_cost = $sparepartTotal;
        $this->total_cost     = $this->service_cost + $sparepartTotal + $jasaTotal;

        $this->save();
    }
}
