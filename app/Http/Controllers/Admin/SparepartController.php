<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Wajib untuk cek folder

class SparepartController extends Controller
{
    // Nampilin halaman Gudang
    public function index()
    {
        $spareparts = Sparepart::orderBy('created_at', 'desc')->get();
        
        return view('admin.spareparts.spareparts', compact('spareparts'));
    }

    // Proses simpan data & foto
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ], [
            // Pesan error custom biar lu paham salahnya di mana
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'image.max' => 'Ukuran gambar maksimal 2MB!',
        ]);

        $data = $request->all();

        // 2. Logika Upload Gambar
        if ($request->hasFile('image')) {
            $path = public_path('uploads/spareparts');
            
            // Kalau folder belum ada, otomatis dibikinin
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // Bikin nama file unik biar nggak bentrok
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();  
            $request->image->move($path, $imageName);
            $data['image'] = $imageName;
        }

        // 3. Simpan ke Database
        Sparepart::create($data);

        return redirect()->route('admin.spareparts.index')->with('success', 'Data sparepart berhasil ditambahkan!');
    }

    // Proses Update Data
    public function update(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Kalau admin upload foto baru
        if ($request->hasFile('image')) {
            // 1. Hapus foto lama dari folder (biar server gak penuh)
            if ($sparepart->image) {
                $oldImagePath = public_path('uploads/spareparts/' . $sparepart->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // 2. Upload foto baru
            $path = public_path('uploads/spareparts');
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();  
            $request->image->move($path, $imageName);
            $data['image'] = $imageName;
        }

        $sparepart->update($data);

        return redirect()->route('admin.spareparts.index')->with('success', 'Data sparepart berhasil diperbarui!');
    }

    // Proses Tambah Stok Cepat
    public function addStock(Request $request, $id)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'added_stock' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('add_stock_error', true)
                ->with('add_stock_action', route('admin.spareparts.add_stock', $id))
                ->with('add_stock_name', Sparepart::find($id)->name)
                ->with('add_stock_current', Sparepart::find($id)->stock);
        }

        $sparepart = Sparepart::findOrFail($id);
        $sparepart->increment('stock', $request->added_stock);

        return redirect()->route('admin.spareparts.index')->with('success', 'Stok ' . $sparepart->name . ' berhasil ditambah sebanyak ' . $request->added_stock . ' unit!');
    }

    // Proses Hapus Data
    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);

        // Hapus foto dari folder fisik sebelum datanya dihapus
        if ($sparepart->image) {
            $imagePath = public_path('uploads/spareparts/' . $sparepart->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $sparepart->delete();

        return redirect()->route('admin.spareparts.index')->with('success', 'Barang berhasil dihapus dari gudang!');
    }
}