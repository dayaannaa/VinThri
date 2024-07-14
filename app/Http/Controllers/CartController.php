<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
class CartController extends Controller
{
// public function index(Request $request)
// {
//     $request->validate([
//         'customer_id' => 'required|exists:customers,customer_id'
//     ]);

//
//     $customer_id = $request->input('customer_id');

//
//     $carts = Cart::where('customer_id', $customer_id)
//                  ->with('products:product_id,name,price,description') // Specify columns you need
//                  ->get();

//                  // Use dd() to dump and die to inspect $carts and products
//     dd([
//         'customer_id' => $customer_id,
//         'carts' => $carts->toArray(), // Convert to array for better inspection
//     ]);


//     return response()->json([
//         'customer_id' => $customer_id,
//         'carts' => $carts,

//     ]);

// }

// public function index()
// {
//     $carts = Cart::all();
//     return response()->json($carts);
// }

//WORKING
// public function index(Request $request)
// {
//     $customerId = $request->query('customer_id');

//     if ($customerId) {
//         $carts = Cart::where('customer_id', $customerId)->get();
//     } else {
//         $carts = Cart::all();
//     }

//     return response()->json($carts);
// }


public function index(Request $request)
{
    $customerId = $request->query('customer_id');

    if ($customerId) {
        $carts = Cart::where('customer_id', $customerId)
                     ->with('product:product_id,name,price,description,images')
                     ->get();
    } else {
        $carts = Cart::with('product:product_id,name,price,description,images')->get();
    }

    return response()->json($carts);
}



    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
            'customer_id' => 'required|exists:customers,customer_id'
        ]);

        $cart = new Cart();
        $cart->customer_id = $request->input('customer_id');
        $cart->product_id = $request->input('product_id');
        $cart->quantity = $request->input('quantity');
        $cart->save();

        return response()->json($cart, 201);
    }

    public function show($id)
    {
        try {
            $cart = Cart::findOrFail($id);
            return response()->json($cart);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cart not found.'], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'customer_id' => 'required|exists:customers,customer_id',
        ]);

        try {
            $cart = Cart::where('cart_id', $id)
                        ->where('customer_id', $request->input('customer_id'))
                        ->firstOrFail();

            $cart->quantity = $request->input('quantity');
            $cart->save();

            return response()->json($cart, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cart not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update cart.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $cart = Cart::findOrFail($id);
            $cart->delete();

            return response()->json(['message' => 'Cart item deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

//     public function checkout(Request $request)
//     {
//         $request->validate([
//             'customer_id' => 'required|exists:customers,customer_id',
//             'products' => 'required|array',
//             'products.*.product_id' => 'required|exists:products,product_id',
//             'status' => 'nullable|string|max:255',
//             'products.*.quantity' => 'required|integer|min:1'
//         ]);

//         try {
//             DB::beginTransaction();

//             $order = new Order();
//             $order->customer_id = $request->input('customer_id');
//             $order->date = now();
//             $order->status = $request->input('status') ?? 'pending';
//             $order->save();

//             foreach ($request->input('products') as $product) {
//                 $orderItem = new OrderItem();
//                 $orderItem->order_id = $order->order_id;
//                 $orderItem->product_id = $product['product_id'];
//                 $orderItem->quantity = $product['quantity'];
//                 $orderItem->save();

//                 Cart::where('customer_id', $order->customer_id)
//                     ->where('product_id', $product['product_id'])
//                     ->delete();
//             }

//             DB::commit();

//             return response()->json(['message' => 'Checkout successful'], 200);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return response()->json(['error' => 'Checkout failed', 'details' => $e->getMessage()], 500);
//         }
//     }
// }


public function checkout(Request $request)
{
    $request->validate([
        'customer_id' => 'required|exists:customers,customer_id',
        'products' => 'required|array',
        'products.*.product_id' => 'required|exists:products,product_id',
        'status' => 'nullable|string|max:255',
        'products.*.quantity' => 'required|integer|min:1'
    ]);

    try {
        DB::beginTransaction();
        $order = new Order();
        $order->customer_id = $request->input('customer_id');
        $order->date = now();
        $order->status = $request->input('status') ?? 'pending';
        $order->save();

        foreach ($request->input('products') as $product) {
            $inventory = Inventory::where('product_id', $product['product_id'])->first();

            if ($inventory && $inventory->stock >= $product['quantity']) {
                $inventory->stock -= $product['quantity'];
                $inventory->save();

                $orderItem = new OrderItem();
                $orderItem->order_id = $order->order_id;
                $orderItem->product_id = $product['product_id'];
                $orderItem->quantity = $product['quantity'];
                $orderItem->save();

                Cart::where('customer_id', $order->customer_id)
                    ->where('product_id', $product['product_id'])
                    ->delete();
            } else {
                throw new \Exception('Insufficient stock for product ID: ' . $product['product_id']);
            }
        }

        DB::commit();

        return response()->json(['message' => 'Checkout successful'], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Checkout failed', ['error' => $e->getMessage()]);

        return response()->json(['error' => 'Checkout failed', 'details' => $e->getMessage()], 500);
    }
}
}
