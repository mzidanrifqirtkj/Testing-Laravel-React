<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Products/index', compact('products'));
    }

    public function create()
    {
        return Inertia::render('Products/create', []);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('type', 'success')->with('message', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        // Assuming you want to pass the product data to the edit view
        // You can also validate or manipulate the product data here if needed
        // For example, you might want to check if the product exists or not
        if (!$product) {
            return redirect()->route('products.index')->with('type', 'error')->with('message', 'Product not found.');
        }
        return Inertia::render('Products/edit', ['product' => $product]);
    }

    public function destroy(Product $product)
    {
        // Check if the product exists before attempting to delete it
        if (!$product) {
            return redirect()->route('products.index')->with('type', 'error')->with('message', 'Product not found.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('type', 'success')->with('message', "{$product->name} deleted successfully.");
    }
}
