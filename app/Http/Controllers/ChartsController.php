<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;

class ChartsController extends Controller
{
    public function salesChart()
    {
        $sales = OrderItem::join('products as p', 'order_items.product_id', '=', 'p.product_id')
            ->join('orders as o', 'order_items.order_id', '=', 'o.order_id')
            ->select(DB::raw('MONTHNAME(o.date) as month, SUM(order_items.quantity * p.price) as total'))
            ->groupBy(DB::raw('MONTHNAME(o.date), MONTH(o.date)'))
            ->orderBy(DB::raw('MONTH(o.date)'))
            ->get();

        $labels = $sales->pluck('month');
        $data = $sales->pluck('total');

        return response()->json(['data' => $data, 'labels' => $labels]);
    }

    public function itemChart()
    {
        $sales = OrderItem::join('products as p', 'order_items.product_id', '=', 'p.product_id')
            ->join('orders as o', 'order_items.order_id', '=', 'o.order_id')
            ->select(DB::raw('p.name as product, SUM(order_items.quantity) as quantity'))
            ->groupBy('p.name')
            ->orderByDesc('quantity')
            ->limit(10)
            ->get();

        $labels = $sales->pluck('product');
        $data = $sales->pluck('quantity');

        return response()->json(['data' => $data, 'labels' => $labels]);
    }

    public function customerChart()
    {
        $customers = Customer::select(DB::raw('MONTHNAME(created_at) as month, COUNT(*) as count'))
            ->groupBy(DB::raw('MONTHNAME(created_at), MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $labels = $customers->pluck('month');
        $data = $customers->pluck('count');

        return response()->json(['data' => $data, 'labels' => $labels]);
    }
}