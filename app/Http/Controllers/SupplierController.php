<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Imports\SuppliersImport;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
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

        $supplier = Supplier::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'address' => $validatedData['address'],
            'image' => implode(',', $imageNames),
        ]);

        return response()->json($supplier, 201);
    }
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'address' => 'required|string',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $supplier = Supplier::findOrFail($id);
            if ($request->has('delete_images') && $request->delete_images == 'true') {
                $existingImages = $supplier->image ? explode(',', $supplier->image) : [];
                foreach ($existingImages as $imageName) {
                    $imagePath = public_path('imgs') . '/' . $imageName;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $supplier->update(['image' => null]);
            }
            $imageNames = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = $image->getClientOriginalName();
                    $image->move(public_path('imgs'), $imageName);
                    $imageNames[] = $imageName;
                }
                $supplier->update([
                    'first_name' => $validatedData['first_name'],
                    'last_name' => $validatedData['last_name'],
                    'address' => $validatedData['address'],
                    'image' => implode(',', $imageNames),
                ]);
            } else {
                $supplier->update([
                    'first_name' => $validatedData['first_name'],
                    'last_name' => $validatedData['last_name'],
                    'address' => $validatedData['address'],
                ]);
            }

            return response()->json($supplier, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating supplier: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while updating the supplier.'], 500);
        }
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(null, 204);
    }

    public function import (Request $request)
    {
      $request ->validate([
          'importFile' => ['required', 'file', 'mimes:xlsx,xls']
      ]);

      Excel::import(new SuppliersImport, $request->file('importFile'));

      return redirect()->back()->with('success', 'Admins imported successfully');
    }
}

