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

        // 1. Fitur Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori
        if ($request->filled('category')) {
            $query->where('name', 'like', '%' . $request->category . '%');
        }

        // 3. Kisaran Harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 4. Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'az':         $query->orderBy('name', 'asc');    break;
                case 'za':         $query->orderBy('name', 'desc');   break;
                case 'price_asc':  $query->orderBy('price', 'asc');   break;
                case 'price_desc': $query->orderBy('price', 'desc');  break;
                default:           $query->latest();                   break;
            }
        } else {
            $query->latest();
        }

        $spareparts = $query->get();

        // Kategori hardcoded (sesuai produk bengkel umum)
        $categories = ['Aki', 'Oli', 'Ban', 'Wiper', 'Busi', 'Filter'];

        return view('customer.spareparts.index', compact('spareparts', 'categories'));
    }

    public function show($id)
    {
        $sparepart = Sparepart::findOrFail($id);

        // Produk terkait: ambil 4 produk lain secara acak
        $related = Sparepart::where('id', '!=', $id)
                    ->where('stock', '>', 0)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();

        return view('customer.spareparts.show', compact('sparepart', 'related'));
    }
}