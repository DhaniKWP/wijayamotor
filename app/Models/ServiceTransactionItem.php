<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ServiceTransaction;
use App\Models\Sparepart;

class ServiceTransactionItem extends Model
{
    use HasFactory;

    protected $table = 'service_transaction_items';

    /**
     * Mass assignable
     */
    protected $fillable = [
        'transaction_id',
        'sparepart_id',
        'qty',
        'price',
        'subtotal',
    ];

    /**
     * Casting
     */
    protected $casts = [
        'qty' => 'integer',
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // =========================
    // RELASI
    // =========================

    // Item milik transaksi servis
    public function transaction()
    {
        return $this->belongsTo(ServiceTransaction::class, 'transaction_id');
    }

    // Item punya sparepart
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    // =========================
    // AUTO HITUNG SUBTOTAL 🔥
    // =========================

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->subtotal = $item->qty * $item->price;
        });
    }
}
