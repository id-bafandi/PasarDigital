<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// =====================
// PUBLIC ROUTES
// =====================
Route::get('/', function () {
    $products = [
        [
            'name'     => "Coastal's Hard Coco",
            'category' => 'Minuman',
            'price'    => '15.000',
            'image'    => 'produk1.jpg',
            'discount' => '-40%'
        ],
        [
            'name'     => "Bots Snack Original",
            'category' => 'Makanan',
            'price'    => '20.000',
            'image'    => 'produk2.jpg',
            'discount' => '-10%'
        ],
        [
            'name'     => "Bots Snack Original",
            'category' => 'Pakaian',
            'price'    => '20.000',
            'image'    => 'produk3.jpg',
            'discount' => '-10%'
        ],
    ];

    return view('welcome', compact('products'));
})->name('home');

// =====================
// AUTH ROUTES (Breeze)
// =====================
require __DIR__.'/auth.php';

// =====================
// PROFILE (semua user login)
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =====================
// USER (konsumen)
// =====================
Route::middleware(['auth', 'role:user'])->prefix('konsumen')->group(function () {
    Route::get('/dashboard', fn() => view('konsumen.dashboard'))->name('konsumen.dashboard');
    Route::get('/orders', fn() => view('konsumen.orders'))->name('konsumen.orders');
    Route::get('/cart', fn() => view('konsumen.cart'))->name('konsumen.cart');
    Route::get('/checkout', fn() => view('konsumen.checkout'))->name('konsumen.checkout');
    Route::get('/payment', fn() => view('konsumen.payment'))->name('konsumen.payment');
});

// =====================
// PENJUAL
// =====================
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->group(function () {
    Route::get('/dashboard', fn() => view('penjual.dashboard'))->name('penjual.dashboard');
    Route::get('/products', fn() => view('penjual.products'))->name('penjual.products');
});

// =====================
// ADMIN
// =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/users', fn() => view('admin.users'))->name('admin.users');
});

// =====================
// PENJUAL & ADMIN
// =====================
Route::middleware(['auth', 'role:penjual,admin'])->group(function () {
    Route::get('/reports', fn() => view('reports'))->name('reports');
});