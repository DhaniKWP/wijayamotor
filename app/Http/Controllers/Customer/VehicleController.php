<?php

namespace App\Http\Controllers\Customer;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    // Tampilkan halaman Garasi Saya
    public function index()
    {
        // Ambil data mobil khusus milik user yang lagi login
        $vehicles = Vehicle::where('user_id', Auth::id())->latest()->get();
        return view('customer.vehicle.garasi', compact('vehicles'));
    }

    // Proses simpan mobil baru
    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'name' => 'required|string|max:255', // Contoh: Honda CR-V
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
        ], [
            'plate_number.unique' => 'Plat nomor ini sudah terdaftar di sistem kami.',
        ]);

        Vehicle::create([
            'user_id' => Auth::id(),
            'plate_number' => strtoupper($request->plate_number),
            'name' => $request->name,
            'year' => $request->year,
        ]);

        return redirect()->route('garasi.index')->with('success', 'Kendaraan berhasil ditambahkan ke Garasi!');
    }

    // Proses hapus mobil
    public function destroy($id)
    {
        $vehicle = Vehicle::where('user_id', Auth::id())->findOrFail($id);
        $vehicle->delete();

        return redirect()->route('garasi.index')->with('success', 'Kendaraan berhasil dihapus dari Garasi.');
    }
}