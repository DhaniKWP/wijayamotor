<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Tampilkan halaman dashboard admin & tabel servis
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('services'));
    }

    // Proses simpan servis baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_estimate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Data servis berhasil ditambahkan!');
    }

    // Proses update servis
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price_estimate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $service->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Data servis berhasil diperbarui!');
    }

    // Proses hapus servis
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Layanan servis berhasil dihapus permanen!');
    }
}