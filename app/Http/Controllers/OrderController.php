<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
     // GET /orders/{user_id}
    public function getUserOrders($user_id)
    {
        $orders = Order::where('user_id', $user_id)->orderBy('order_date', 'desc')->get();

        return response()->json($orders);
    }

    // PUT /order
    public function storeOrder(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
            'order_date' => 'required|date'
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'total' => $request->total,
            'order_date' => $request->order_date
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Orden registrada correctamente',
            'order' => $order
        ], 201);
    }
}
