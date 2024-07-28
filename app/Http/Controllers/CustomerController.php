<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
            $customerId = $request->query('customer_id');
            if ($customerId) {
                $customers = Customer::where('customer_id', $customerId)->get();
            } else {
                $customers = Customer::all();
            }
    
            return response()->json($customers);
        }
    
    

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->password = '********';
        return response()->json($customer);
    }

    public function store(Request $request)
    {
$validatedData = $request->validate([
    'first_name' => 'required|string|max:255',
    'last_name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users,email|unique:customers,email',
    'status' => 'nullable|string|max:255',
    'password' => 'nullable|string|min:8',
    'address' => 'nullable|string|max:255',
    'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
]);

$user = User::create([
    'first_name' => $validatedData['first_name'],
    'last_name' => $validatedData['last_name'],
    'email' => $validatedData['email'],
    'status' => 'active',
    'password' => Hash::make($validatedData['password']),
    'type' => 1,
]);


$customer = Customer::create([
    'user_id' => $user->user_id,
    'address' => $validatedData['address'],
    'first_name' => $validatedData['first_name'],
    'last_name' => $validatedData['last_name'],
    'email' => $validatedData['email'],
]);
        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('imgs'), $imageName);
                $imageNames[] = $imageName;
            }
        }

        if (!empty($imageNames)) {
            $customer->image = implode(',', $imageNames);
            $customer->save();
        }

        return response()->json($customer, 201);
    }

    public function update(Request $request, $customer_id)
    {
        try {
            $customer = Customer::findOrFail($customer_id);

            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->customer_id . ',customer_id',
                'password' => 'nullable|string|min:8',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->filled('password')) {
                $validatedData['password'] = Hash::make($request->password);
            } else {
                unset($validatedData['password']);
            }

            if ($request->has('delete_images') && $request->delete_images == 'true') {
                $existingImages = $customer->image ? explode(',', $customer->image) : [];
                foreach ($existingImages as $imageName) {
                    $imagePath = public_path('imgs') . '/' . $imageName;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $customer->update(['image' => null]);
            }

            $imageNames = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = $image->getClientOriginalName();
                    $image->move(public_path('imgs'), $imageName);
                    $imageNames[] = $imageName;
                }
                $customer->image = implode(',', $imageNames);
            }

            $updateData = array_filter($validatedData);

            if (isset($updateData['password']) && $updateData['password'] !== '****') {
                $updateData['password'] = Hash::make($updateData['password']);
            } else {
                unset($updateData['password']);
            }

            $customer->update($updateData);

            return response()->json($customer, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update customer. ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->image) {
            $images = explode(',', $customer->image);
            foreach ($images as $imageName) {
                $imagePath = public_path('imgs') . '/' . $imageName;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        $customer->delete();

        return response()->json(null, 204);
    }
}
