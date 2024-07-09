<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;
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

        if ($user->type === 0) {
            session(['admin_id' => $user->admin_id]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            $customer_id = null;
            if ($user->type === 1) {
                $customer = Customer::where('user_id', $user->user_id)->first();
                $customer_id = $customer ? $customer->customer_id : null;

                session(['customer_id' => $customer_id]);
                Log::info('Customer ID set in session:', ['customer_id' => $customer_id]);

            }

            return response()->json([
                'token' => $token,
                'user_id' => $user->user_id,
                'customer_id' => $customer_id

            ], 200);


        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

    }
}
