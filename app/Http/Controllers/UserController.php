<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admins.userDT');
    }

    public function getUsers(Request $request)
    {
        $data = User::select('user_id', 'first_name', 'last_name', 'email', 'status', 'type')->get();
        return response()->json(['data' => $data]);
    }

    public function changeStatus(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['success' => 'Status changed successfully.']);
    }

    public function changeType(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $type = $request->type;

        if ($user->type == $type) {
            return response()->json(['success' => false, 'message' => 'User is already of the selected type.']);
        }

        if ($type == 0) {
            $this->transferToAdmin($user);
        } elseif ($type == 1) {
            $this->transferToCustomer($user);
        }

        $user->type = $type;
        $user->save();

        return response()->json(['success' => true, 'message' => 'User type changed successfully.']);
    }

    public function getUserDetails(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        return response()->json(['user' => $user]);
    }

    private function transferToAdmin(User $user)
    {
        $customer = Customer::withTrashed()->where('user_id', $user->user_id)->first();
        $address = $customer ? $customer->address : '';
        $image = $customer ? $customer->image : '';

        if ($customer) {
            $customer->delete();
        }

        $admin = Admin::withTrashed()->where('user_id', $user->user_id)->first();
        if (!$admin) {
            Admin::create([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'address' => $address,
                'email' => $user->email,
                'user_id' => $user->user_id,
                'image' => $image
            ]);
        } else {
            $admin->restore();
            $admin->address = $address;
            $admin->image = $image;
            $admin->save();
        }
    }

    private function transferToCustomer(User $user)
    {
        $admin = Admin::withTrashed()->where('user_id', $user->user_id)->first();
        $address = $admin ? $admin->address : '';
        $image = $admin ? $admin->image : '';

        if ($admin) {
            $admin->delete();
        }

        $customer = Customer::withTrashed()->where('user_id', $user->user_id)->first();
        if (!$customer) {
            Customer::create([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'address' => $address,
                'email' => $user->email,
                'user_id' => $user->user_id,
                'image' => $image
            ]);
        } else {
            $customer->restore();
            $customer->address = $address;
            $customer->image = $image;
            $customer->save();
        }
    }
}
