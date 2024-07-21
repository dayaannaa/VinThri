<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            $customer_id = null;
            $admin_id = null;

            if ($user->type === 1) {
                // If the user type is customer
                $customer = Customer::where('user_id', $user->user_id)->first();
                $customer_id = $customer ? $customer->customer_id : null;
                session(['customer_id' => $customer_id]);
                Log::info('Customer ID set in session:', ['customer_id' => $customer_id]);
            } elseif ($user->type === 0) {
                // If the user type is admin
                $admin = Admin::where('user_id', $user->user_id)->first();
                $admin_id = $admin ? $admin->admin_id : null;
                session(['admin_id' => $admin_id]);
            }

            return response()->json([
                'token' => $token,
                'user_id' => $user->user_id,
                'customer_id' => $customer_id,
                'admin_id' => $admin_id // Include admin_id in the response
            ], 200);
        }

        // Authentication failed
        return response()->json(['error' => 'Invalid credentials'], 401);
    }


    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('image') as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('imgs'), $imageName);
                $imageNames[] = $imageName;
            }
        } 

        $defaultImage = 'profile1.jpg';

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 1, 
            'status' => 'active',
            'image' => $request->hasFile('image') ? implode(',', $imageNames) : $defaultImage,
        ]);

        if ($user->type === 1) {
            $customer = Customer::create([
                'user_id' => $user->user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'image' => $request->hasFile('image') ? implode(',', $imageNames) : $defaultImage,
                'address' => $request->address,
                'email' => $request->email,
            ]);
        }

        return response()->json(['message' => 'User registered successfully'], 201);
    }
}
