<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Imports\AdminsImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::all());
    }

    public function show($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->password = '********';
        return response()->json($admin);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email|unique:admins,email',
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
            'type' => 0,
        ]);

        $admin = Admin::create([
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
            $admin->image = implode(',', $imageNames);
            $admin->save();
        }

        return response()->json($admin, 201);
    }

    public function update(Request $request, $admin_id)
    {
        try {
            $admin = Admin::findOrFail($admin_id);

            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->admin_id . ',admin_id',
                'password' => 'nullable|string|min:8',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->filled('password')) {
                $validatedData['password'] = Hash::make($request->password);
            } else {
                unset($validatedData['password']);
            }

            if ($request->has('delete_images') && $request->delete_images == 'true') {
                $existingImages = $admin->image ? explode(',', $admin->image) : [];
                foreach ($existingImages as $imageName) {
                    $imagePath = public_path('imgs') . '/' . $imageName;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $admin->update(['image' => null]);
            }

            $imageNames = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = $image->getClientOriginalName();
                    $image->move(public_path('imgs'), $imageName);
                    $imageNames[] = $imageName;
                }
                $admin->image = implode(',', $imageNames);
            }

            $updateData = array_filter($validatedData);

            if (isset($updateData['password']) && $updateData['password'] !== '****') {
                $updateData['password'] = Hash::make($updateData['password']);
            } else {
                unset($updateData['password']);
            }

            $admin->update($updateData);

            return response()->json($admin, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update admin. ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        // Find the Admin record by ID
        $admin = Admin::findOrFail($id);

        // Delete associated images
        if ($admin->image) {
            $images = explode(',', $admin->image);
            foreach ($images as $imageName) {
                $imagePath = public_path('imgs') . '/' . $imageName;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        // Delete the Admin record
        $admin->delete();

        // Find and delete the associated User record
        $user = User::findOrFail($admin->user_id);
        $user->delete();

        return response()->json(null, 204);
    }

    public function import (Request $request)
    {
      $request ->validate([
          'importFile' => ['required', 'file', 'mimes:xlsx,xls']
      ]);

      Excel::import(new AdminsImport, $request->file('importFile'));

      return redirect()->back()->with('success', 'Admins imported successfully');
    }
}
