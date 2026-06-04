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
     *
     * item_type  : 'sparepart' | 'jasa'
     * sparepart_id: diisi jika item_type = 'sparepart', null jika 'jasa'
     * item_name  : diisi jika item_type = 'jasa' (nama jasa manual), null jika 'sparepart'
     * note       : opsional, catatan tambahan per baris item
     */
    protected $fillable = [
        'transaction_id',
        'item_type',
        'sparepart_id',
        'item_name',
        'note',
        'qty',
        'price',
        'subtotal',
    ];

    /**
     * Casting
     */
    protected $casts = [
        'qty'      => 'integer',
        'price'    => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // =========================
    // RELASI
    // =========================

    /** Item milik transaksi servis */
    public function transaction()
    {
        return $this->belongsTo(ServiceTransaction::class, 'transaction_id');
    }

    /** Item berelasi ke sparepart (nullable — hanya ada jika item_type = 'sparepart') */
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class)->withDefault();
    }

    // =========================
    // HELPER
    // =========================

    /** Cek apakah item ini adalah sparepart */
    public function isSparepart(): bool
    {
        return $this->item_type === 'sparepart';
    }

    /** Cek apakah item ini adalah jasa tambahan manual */
    public function isJasa(): bool
    {
        return $this->item_type === 'jasa';
    }

    /**
     * Nama tampilan item:
     *  - Jika sparepart → ambil nama dari relasi sparepart
     *  - Jika jasa      → ambil dari kolom item_name
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->item_type === 'sparepart' && $this->sparepart) {
            return $this->sparepart->name;
        }
        return $this->item_name ?? '-';
    }

    // =========================
    // AUTO HITUNG SUBTOTAL 🔥
    // =========================

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->subtotal = ($item->qty ?? 1) * ($item->price ?? 0);
        });
    }
}
