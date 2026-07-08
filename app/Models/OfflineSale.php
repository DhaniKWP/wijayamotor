<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfflineSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'customer_name',
        'payment_method',
        'total_amount',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function items()
    {
        return $this->hasMany(OfflineSaleItem::class);
    }
}
