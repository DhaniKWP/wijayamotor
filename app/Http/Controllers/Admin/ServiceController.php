<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Tampilkan halaman tabel master servis
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        // UBAH: Arahkan ke view admin.services.index
        return view('admin.services.index', compact('services'));
    }

    // Proses simpan servis baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'price_estimate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Layanan dengan nama ini sudah terdaftar. Silakan edit data yang sudah ada.',
        ]);

        Service::create($request->all());

        // UBAH: Redirect ke route admin.services.index
        return redirect()->route('admin.services.index')->with('success', 'Data servis berhasil ditambahkan!');
    }

    // Proses update servis
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id,
            'price_estimate' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Layanan dengan nama ini sudah terdaftar. Silakan edit data yang sudah ada.',
        ]);

        $service->update($request->all());

        // UBAH: Redirect ke route admin.services.index
        return redirect()->route('admin.services.index')->with('success', 'Data servis berhasil diperbarui!');
    }

    // Proses hapus servis
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        // UBAH: Redirect ke route admin.services.index
        return redirect()->route('admin.services.index')->with('success', 'Layanan servis berhasil dihapus permanen!');
    }
}