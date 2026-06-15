<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    /**
     * Menampilkan daftar semua sparepart
     */
    public function index()
    {
        $spareparts = Sparepart::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil data sparepart',
            'data'    => $spareparts
        ], 200);
    }
}
