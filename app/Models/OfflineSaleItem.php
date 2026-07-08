<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflineSaleItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'offline_sale_id',
        'sparepart_id',
        'qty',
        'price',
        'subtotal',
    ];

    public function offlineSale()
    {
        return $this->belongsTo(OfflineSale::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
