<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    $products = [
        [
            'name' => "Coastal's Hard Coco",
            'category' => 'Minuman',
            'price' => '15.000',
            'image' => 'produk1.jpg',
            'discount' => '-40%'
        ],
        [
            'name' => "Bots Snack Original",
            'category' => 'Makanan',
            'price' => '20.000',
            'image' => 'produk2.jpg',
            'discount' => '-10%'
        ],
        [
            'name' => "Bots Snack Original",
            'category' => 'Pakaian',
            'price' => '20.000',
            'image' => 'produk3.jpg',
            'discount' => '-10%'
        ],
        [
            'name' => "Coastal's Hard Coco",
            'category' => 'Minuman',
            'price' => '15.000',
            'image' => 'produk1.jpg',
            'discount' => '-40%'
        ],
        [
            'name' => "Bots Snack Original",
            'category' => 'Makanan',
            'price' => '20.000',
            'image' => 'produk2.jpg',
            'discount' => '-10%'
        ],
        [
            'name' => "Bots Snack Original",
            'category' => 'Pakaian',
            'price' => '20.000',
            'image' => 'produk3.jpg',
            'discount' => '-10%'
        ],
    ];

    return view('welcome', compact('products'));
});

require __DIR__.'/auth.php';
