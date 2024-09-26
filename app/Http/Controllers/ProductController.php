<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display the list of products with a join on the categories table
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $products = Product::with('category')
            ->where('name', 'like', '%' . $search . '%')
            ->paginate(10);

        return view('products.index', compact('products', 'search'));
    }

    // Store a new product to the database
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('images/products', 'public') : null;

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => true, 'product' => $product]);
    }

    // Edit an existing product and handle image re-upload if needed
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $product->image; // Keep existing image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            // Store new image
            $imagePath = $request->file('image')->store('images/products', 'public');
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => true, 'product' => $product]);
    }

    // Delete a product
    public function destroy(Product $product)
    {
        // Delete the product image if exists
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete();

        return response()->json(['success' => true]);
    }
}
