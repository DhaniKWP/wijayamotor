<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
{
    return view('booking.create', [
        'vehicles' => \App\Models\Vehicle::where('user_id', $request->user()->id)->get(),
        'services' => \App\Models\Service::all(),
    ]); 
}

public function store(Request $request)
{
    $request->validate([
        'vehicle_id' => 'required|exists:vehicles,id',
        'service_id' => 'required|exists:services,id',
        'tanggal' => 'required|date',
        'jam' => 'required',
        'keluhan' => 'required|string',
    ]);

    \App\Models\Booking::create([
        'user_id' => $request->user()->id,
        'vehicle_id' => $request->vehicle_id,
        'service_id' => $request->service_id,
        'tanggal' => $request->tanggal,
        'jam' => $request->jam,
        'keluhan' => $request->keluhan,
        'status' => 'pending',
    ]);

    return redirect()->route('dashboard')->with('success', 'Booking berhasil dibuat');
}
}
