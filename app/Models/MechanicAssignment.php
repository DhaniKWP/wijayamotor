<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Booking;
use App\Models\User;

class MechanicAssignment extends Model
{
    use HasFactory;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'booking_id',
        'mechanic_id',
    ];

    // =========================
    // RELASI
    // =========================

    // Assignment milik booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Assignment milik mekanik (user)
    public function mechanic()
    {
        return $this->belongsTo(User::class, 'mechanic_id');
    }
}
