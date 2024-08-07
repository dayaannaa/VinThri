<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $customerId = $request->query('customer_id');

        if ($customerId) {
            $orders = Order::whereHas('customer', function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId);
                })
                ->with('customer')
                ->get();
        } else {
            $orders = Order::with('customer')->get();
        }
        // return view('orders.order-details', compact('orders', 'customerId'));
        return response()->json($orders);
    }
    public function getOrderProducts($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return response()->json($order->orderItems);
    }

    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $request->input('status');
        $order->save();

        return response()->json(['message' => 'Order status updated successfully']);
    }
}
