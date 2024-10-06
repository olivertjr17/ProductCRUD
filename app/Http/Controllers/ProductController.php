<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('images');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->input('category') != '') {
            $query->where('category', $request->input('category'));
        }

        $products = $query->paginate(10);

        $categories = Product::select('category')->distinct()->pluck('category');

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::debug($request);
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_and_time' => 'required|date',
        ]);

        $product = Product::create($request->except('images'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create(['product_id' => $product->id, 'path' => $path]);
            }
        }

        return response()->json(['message' => 'Product created successfully!', 'product' => $product]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        \Log::debug($request->all());
        \Log::debug($request->files->all()); 

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_and_time' => 'sometimes|date',
        ]);

        $product = Product::findOrFail($id);

        $product->update($request->except('images'));

        if ($request->hasFile('images')) {
            ProductImage::where('product_id', $product->id)->delete();
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create(['product_id' => $product->id, 'path' => $path]);
            }
        }

        return response()->json(['message' => 'Product updated successfully!', 'product' => $product]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully!']);
    }

    public function checkAuthentication()
    {
        if (Auth::check()) {
            return response()->json(['message' => 'User is authenticated']);
        } else {
            return response()->json(['message' => 'User is not authenticated'], 401);
        }
    }
}
