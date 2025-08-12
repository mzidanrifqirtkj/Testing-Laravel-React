<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return Inertia::render('Products/Index', [
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image' => $product->image,
                    'image_url' => $product->image_url,
                ];
            }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return Inertia::render('Products/Show', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image,
                'image_url' => $product->image_url,
            ],
        ]);
    }

    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image,
                'image_url' => $product->image_url,
            ],
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
    // public function index()
    // {
    //     $products = Product::all();
    //     return Inertia::render('Products/index', compact('products'));
    // }

    // public function create()
    // {
    //     return Inertia::render('Products/create', []);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'price' => 'required|numeric|min:0',
    //         'description' => 'nullable|string',
    //     ]);

    //     Product::create($request->all());

    //     return redirect()->route('products.index')->with('type', 'success')->with('message', 'Product created successfully.');
    // }

    // public function edit(Product $product)
    // {
    //     // Assuming you want to pass the product data to the edit view
    //     // You can also validate or manipulate the product data here if needed
    //     // For example, you might want to check if the product exists or not
    //     if (!$product) {
    //         return redirect()->route('products.index')->with('type', 'error')->with('message', 'Product not found.');
    //     }
    //     return Inertia::render('Products/edit', ['product' => $product]);
    // }

    // public function destroy(Product $product)
    // {
    //     // Check if the product exists before attempting to delete it
    //     if (!$product) {
    //         return redirect()->route('products.index')->with('type', 'error')->with('message', 'Product not found.');
    //     }

    //     $product->delete();

    //     return redirect()->route('products.index')->with('type', 'success')->with('message', "{$product->name} deleted successfully.");
    // }
}
