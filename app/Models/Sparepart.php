<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderItem;
use App\Models\ServiceTransactionItem;

class Sparepart extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
    ];

    /**
     * Casting
     */
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // =========================
    // RELASI
    // =========================

    // Dipakai di order (penjualan)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Dipakai di servis (tambahan sparepart saat servis)
    public function serviceItems()
    {
        return $this->hasMany(ServiceTransactionItem::class, 'sparepart_id');
    }

    // =========================
    // HELPER (STOK) 🔥
    // =========================

    public function isInStock()
    {
        return $this->stock > 0;
    }

    public function isLowStock()
    {
        return $this->stock <= 5; // bisa kamu ubah threshold
    }
}
