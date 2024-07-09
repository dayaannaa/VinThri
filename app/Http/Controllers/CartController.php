<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
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
        try {
            $request->validate([
                'product_id' => 'required|exists:products,product_id',
                'quantity' => 'required|integer|min:1',
                'customer_id' => 'required|exists:customers,customer_id'
            ]);

            $cart = Cart::findOrFail($id);

            $cart->customer_id = $request->input('customer_id');
            $cart->product_id = $request->input('product_id');
            $cart->quantity = $request->input('quantity');
            $cart->save();

            return response()->json($cart, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cart not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $cart = Cart::findOrFail($id);
            $cart->delete();

            return response()->json(['message' => 'Cart deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Cart not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
