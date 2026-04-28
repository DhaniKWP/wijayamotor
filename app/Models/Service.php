<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ServiceTransaction;
use App\Models\Sparepart;

class Service extends Model
{
    use HasFactory;

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
    // HELPER 🔥
    // =========================

    public function calculateSubtotal()
    {
        $this->subtotal = $this->qty * $this->price;
        return $this->subtotal;
    }
}
