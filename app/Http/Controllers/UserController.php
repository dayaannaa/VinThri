<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $user->type = $request->type;
        $user->save();

        return response()->json(['success' => 'Type changed successfully.']);
    }
}
