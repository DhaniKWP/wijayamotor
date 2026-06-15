<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Menampilkan daftar semua layanan servis
     */
    public function index()
    {
        $services = Service::all();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berhasil mengambil data servis',
            'data'    => $services
        ], 200);
    }
}
