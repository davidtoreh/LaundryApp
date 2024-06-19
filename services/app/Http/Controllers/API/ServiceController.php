<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function getAll()
    {
        $items = Service::orderBy('serviceType', 'ASC')->get();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Service berhasil diambil',
            'data' => $items
        ]);
    }

    public function show($id)
    {
        $item = Service::find($id);
        if ($item) {
            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Service berhasil diambil',
                'data' => $item
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Service tidak ditemukan.',
                'data' => NULL
            ]);
        }
    }
}
