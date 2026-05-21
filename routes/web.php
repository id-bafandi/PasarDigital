<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;

// =====================
// PUBLIC ROUTES
// =====================
Route::get('/', function () {
    $products = \App\Models\Product::with('category')->get();
    return view('welcome', compact('products'));
})->name('home');

// =====================
// AUTH ROUTES (Breeze)
// =====================
require __DIR__.'/auth.php';

// =====================
// PROFILE
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
    Route::get('/cart', [CartController::class, 'index'])->name('konsumen.cart');
    Route::get('/checkout', fn() => view('konsumen.checkout'))->name('konsumen.checkout');
    Route::get('/payment', fn() => view('konsumen.payment'))->name('konsumen.payment');
});

// =====================
// CART API (AJAX)
// =====================
Route::middleware(['auth', 'role:user'])->prefix('api/cart')->group(function () {
    Route::post('/add', [CartController::class, 'addItem'])->name('cart.add');
    Route::patch('/update/{cartItem}', [CartController::class, 'updateItem'])->name('cart.update');
    Route::delete('/remove/{cartItem}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
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