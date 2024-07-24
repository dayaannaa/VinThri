<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;

class FeedbackController extends Controller
{
    // public function index()
    // {
    //     $feedbacks = Feedback::with(['customer', 'orderItem.product'])->get();
    //     return response()->json($feedbacks);
    // }

    // public function index(Request $request)
    // {
    //     $customerId = $request->input('customer_id');

    //     if ($customerId) {
    //         $feedbacks = Feedback::where('customer_id', $customerId)
    //             ->with('orderItem.product')  // Ensure the relationships are defined in your models
    //             ->get();
    //     } else {
    //         $feedbacks = Feedback::with('orderItem.product')->get();
    //     }

    //     return response()->json($feedbacks);
    // }

    public function index(Request $request)
{
    $customerId = $request->input('customer_id');

    $query = Feedback::with(['customer', 'orderItem.product']);

    if ($customerId) {
        $query->where('customer_id', $customerId);
    }

    $feedbacks = $query->get();

    return response()->json($feedbacks);
}

public function store(Request $request)
{
    $request->validate([
        'description' => 'required|string',
        'order_item_id' => 'required|exists:order_items,order_item_id',
        'customer_id' => 'required|exists:customers,customer_id',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $imageNames = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('imgs'), $imageName);
            $imageNames[] = $imageName;
        }
    }

    // Create feedback entry
    $feedback = new Feedback([
        'description' => $request->input('description'),
        'date' => now(),
        'customer_id' => $request->input('customer_id'),
        'order_item_id' => $request->input('order_item_id'),
        'images' => implode(',', $imageNames)
    ]);

    $feedback->save();

    return response()->json(['message' => 'Feedback submitted successfully']);
}


    public function show($id)
    {
        $feedback = Feedback::with(['customer', 'orderItem.product'])->findOrFail($id);
        return response()->json($feedback);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'order_item_id' => 'required|exists:order_items,order_item_id',
            'customer_id' => 'required|exists:customers,customer_id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $feedback = Feedback::findOrFail($id);

        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('imgs'), $imageName);
                $imageNames[] = $imageName;
            }
        }

        $feedback->description = $request->input('description');
        $feedback->date = now();
        $feedback->customer_id = $request->input('customer_id');
        $feedback->order_item_id = $request->input('order_item_id');
        if (!empty($imageNames)) {
            $feedback->images = implode(',', $imageNames);
        }

        $feedback->save();

        return response()->json(['message' => 'Feedback updated successfully']);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();
        return response()->json(null, 204);
    }
}
