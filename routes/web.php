<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\WishlistController;

// =====================
// PUBLIC ROUTES
// =====================
Route::get('/', function () {
    $products = \App\Models\Product::with('category')
        ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
        ->get();
    $categories = \App\Models\Category::all();
    
    $wishlistIds = auth()->check() 
        ? \App\Models\Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
        : [];

    return view('welcome', compact('products', 'categories', 'wishlistIds'));
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
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('konsumen.wishlist');
    Route::get('/dashboard', fn() => view('konsumen.dashboard'))->name('konsumen.dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('konsumen.orders');
    Route::get('/cart', [CartController::class, 'index'])->name('konsumen.cart');

    // ← Checkout: GET tampilkan form, POST proses order
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('konsumen.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('konsumen.checkout.store');

    // ← Payment: terima order id dari redirect checkout
    Route::get('/payment/{order}', fn(\App\Models\Order $order) => view('konsumen.payment', compact('order')))->name('konsumen.payment');

    Route::post('/payment/{order}/upload', [PaymentController::class, 'uploadProof'])->name('konsumen.payment.upload');
    Route::post('/payment/{order}/confirm-cod', [PaymentController::class, 'confirmCod'])->name('konsumen.payment.confirm');
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

Route::middleware(['auth', 'role:user'])->prefix('api/wishlist')->group(function () {
    Route::post('/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// =====================
// PENJUAL
// =====================
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->group(function () {
    Route::get('/dashboard', [PenjualController::class, 'dashboard'])->name('penjual.dashboard');
    Route::get('/products', [PenjualController::class, 'products'])->name('penjual.products');
    Route::get('/products/create', [PenjualController::class, 'create'])->name('penjual.products.create');
    Route::post('/products', [PenjualController::class, 'store'])->name('penjual.products.store');
    Route::get('/products/{product}/edit', [PenjualController::class, 'edit'])->name('penjual.products.edit');
    Route::put('/products/{product}', [PenjualController::class, 'update'])->name('penjual.products.update');
    Route::delete('/products/{product}', [PenjualController::class, 'delete'])->name('penjual.products.delete');
});

// =====================
// ADMIN
// =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('admin.payments.confirm');
    Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('admin.payments.reject');
});

// =====================
// PENJUAL & ADMIN
// =====================
Route::middleware(['auth', 'role:penjual,admin'])->group(function () {
    Route::get('/reports', fn() => view('reports'))->name('reports');
});

Route::get('/produk/{product}', function(\App\Models\Product $product) {
    $wishlistIds = auth()->check()
        ? \App\Models\Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray()
        : [];
    return view('produk.detail', compact('product', 'wishlistIds'));
})->name('produk.detail');