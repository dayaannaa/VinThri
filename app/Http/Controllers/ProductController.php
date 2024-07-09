<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSupply;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier', 'inventory', 'productsupplies.supplier'])->get();

        return response()->json($products);
    }
    public function display()
    {
        $products = Product::select('product_id', 'name', 'images', 'price', 'description')->get();
        return response()->json($products);
    }


    public function addtocart($product_id)
    {
        $product = Product::findOrFail($product_id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'supplier_price' => 'required|numeric|min:0',
            'date_supplied' => 'required|date',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,category_id',
            'supplier_id' => 'required|exists:suppliers,supplier_id',
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

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description', '');
        $product->category_id = $request->input('category_id');
        $product->images = implode(',', $imageNames);
        $product->save();

        $productSupply = new ProductSupply();
        $productSupply->product_id = $product->product_id;
        $productSupply->supplier_id = $request->input('supplier_id');
        $productSupply->price = $request->input('supplier_price');
        $productSupply->date_supplied = $request->input('date_supplied');
        $productSupply->save();

        $inventory = new Inventory();
        $inventory->product_id = $product->product_id;
        $inventory->stock = $request->input('stock');
        $inventory->save();

        return response()->json($product, 201);
    }

    public function show($id)
    {
        try {
            $product = Product::with(['category', 'supplier', 'inventory', 'productsupplies'])->findOrFail($id);
            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'name' => 'required',
                'price' => 'required|numeric|min:0',
                'supplier_price' => 'required|numeric|min:0',
                'date_supplied' => 'required|date',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,category_id',
                'supplier_id' => 'required|exists:suppliers,supplier_id',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($request->has('delete_images') && $request->delete_images == 'true') {
                $existingImages = $product->images ? explode(',', $product->images) : [];
                foreach ($existingImages as $imageName) {
                    $imagePath = public_path('imgs') . '/' . $imageName;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $product->update(['images' => null]);
            }

            $imageNames = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = $image->getClientOriginalName();
                    $image->move(public_path('imgs'), $imageName);
                    $imageNames[] = $imageName;
                }
            }

            $product->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'description' => $request->input('description', ''),
                'category_id' => $request->input('category_id'),
                'images' => $request->hasFile('images') ? implode(',', $imageNames) : $product->images
            ]);

            $productSupply = ProductSupply::updateOrCreate(
                ['product_id' => $product->product_id, 'supplier_id' => $request->input('supplier_id')],
                ['price' => $request->input('supplier_price'), 'date_supplied' => $request->input('date_supplied')]
            );

            $inventory = Inventory::updateOrCreate(
                ['product_id' => $product->product_id],
                ['stock' => $request->input('stock')]
            );

            return response()->json($product, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            ProductSupply::where('product_id', $product->product_id)->delete();
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getProductSupplies($productId)
    {
        try {
            $supplies = ProductSupply::where('product_id', $productId)->get();
            return response()->json($supplies);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product supplies not found.'], 404);
        }
    }
}
