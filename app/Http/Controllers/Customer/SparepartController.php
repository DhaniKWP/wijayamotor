<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $query = Sparepart::query();

        // 1. Fitur Search (Cari Nama)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Fitur Filter Kategori (Mencocokkan kata pada nama produk)
        if ($request->filled('category')) {
            $query->where('name', 'like', '%' . $request->category . '%');
        }

        // 3. Fitur Filter Kisaran Harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 4. Fitur Urutkan (Sorting)
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'za':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest(); // Default produk terbaru
        }

        $spareparts = $query->get();

        // Daftar kategori tiruan ala Auto2000 untuk tombol filter
        $categories = ['Aki', 'Oli', 'Ban', 'Wiper', 'Busi', 'Filter'];

        return view('customer.spareparts.index', compact('spareparts', 'categories'));
    }


    public function show($id)
    {
        // Cari sparepart, kalau nggak ada bakal nampilin halaman 404
        $sparepart = \App\Models\Sparepart::findOrFail($id);
        
        return view('customer.spareparts.show', compact('sparepart'));
    }
}