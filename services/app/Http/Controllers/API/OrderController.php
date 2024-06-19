<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class OrderController extends Controller
{
    public function getAll()
    {
        $email = request('email');
        $orders = Order::with('service')->where('customer_email', $email)->latest()->get();
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Transaction berhasil diambil',
            'data' => $orders
        ]);
    }

    public function store()
    {
        $validator = FacadesValidator::make(request()->all(), [
            'customer_name' => ['required'],
            'customer_email' => ['required'],
            'service_id' => ['required'],
            'customer_address' => ['required'],
            'pickup_date' => ['required'],
            'item_name' => ['required'],
            'qty' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'code' => 422,
                'message' => $validator->errors(),
                'data' => NULL
            ]);
        }

        $service = Service::find(request('service_id'));
        $total_amount = request('qty') * $service->PricePerUnit;

        $order = Order::create([
            'code' => Carbon::now()->format('Ymd') . rand(1, 999) . rand(100, 99999),
            'customer_name' => request('customer_name'),
            'customer_email' => request('customer_email'),
            'customer_address' => request('customer_address'),
            'service_id' => request('service_id'),
            'pickup_date' => request('pickup_date'),
            'item_name' => request('item_name'),
            'qty' => request('qty'),
            'total_amount' => $total_amount,
            'status' => 'Menunggu Penjemputan Barang'
        ]);

        if ($order) {
            return response()->json([
                'status' => 'success',
                'code' => 400,
                'message' => 'Transaksi berhasil dibuat.',
                'data' => $order
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => 'Ada kesalahan sistem.',
                'data' => NULL
            ]);
        }
    }
}
