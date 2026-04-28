<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Service;
use App\Models\ServiceTransaction;
use App\Models\MechanicAssignment;


class Booking extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'service_id',
        'tanggal',
        'jam',
        'keluhan',
        'status',
    ];

    /**
     * Casting (biar otomatis tipe data benar)
     */
    protected $casts = [
        'tanggal' => 'date',
        'jam' => 'datetime:H:i',
    ];

    // RELASI

    // Booking milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Booking punya kendaraan
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Booking punya service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Booking punya 1 transaksi servis
    public function transaction()
    {
        return $this->hasOne(ServiceTransaction::class);
    }

    // Booking punya assignment mekanik
    public function mechanicAssignment()
    {
        return $this->hasOne(MechanicAssignment::class);
    }

    // HELPER (STATUS)

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isProcess()
    {
        return $this->status === 'process';
    }

    public function isDone()
    {
        return $this->status === 'done';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}
