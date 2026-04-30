<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function create()
    {
        return view('vehicle.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'plate_number' => 'required',
            'year' => 'nullable|numeric',
        ]);

        Vehicle::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'plate_number' => $request->plate_number,
            'year' => $request->year,
        ]);

        return redirect('/dashboard')->with('success', 'Kendaraan berhasil ditambahkan');
    }
}
