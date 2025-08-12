<?php
// app/Http/Controllers/PublicProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class PublicProductController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Shop/Index', [
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image_url' => $product->image_url,
                ];
            }),
        ]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Shop/Show', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image_url' => $product->image_url,
            ],
        ]);
    }
}
