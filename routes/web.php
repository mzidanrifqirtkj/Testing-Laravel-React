<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PublicProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

// Route::get('/', function () {
//     return Inertia::render('welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/dashboard', function () {
    return Inertia::render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public product routes
Route::get('/shop', [PublicProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [PublicProductController::class, 'show'])->name('shop.show');

Route::middleware('auth')->group(function () {
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
});

// Admin only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('products', ProductController::class);
});



// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('dashboard', function () {
//         return Inertia::render('dashboard');
//     })->name('dashboard');
//     Route::get('/products', [ProductController::class, 'index'])->name('products.index');
//     Route::post('/products', [ProductController::class, 'store'])->name('products.store');
//     Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
//     Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
//     Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

//     Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
//     Route::get('/customers/create', [CustomersController::class, 'create'])->name('customers.create');


// });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
