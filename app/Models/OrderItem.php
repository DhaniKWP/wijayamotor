<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;
use App\Models\Sparepart;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    public $timestamps = false;

    protected $fillable = [
        'order_id',
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

    // Item milik order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Item punya sparepart
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
