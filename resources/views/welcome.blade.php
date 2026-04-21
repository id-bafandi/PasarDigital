@extends('layouts.app')

@section('content')

    <section class="bg-[#E7F3EF] py-16">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="inline-block bg-[#F8DCCB] text-[#BF6B44] px-4 py-1 rounded-full text-sm font-medium">Beberpa Spesial Promo</span>
                <h1 class="text-5xl md:text-6xl font-extrabold text-[#1D8267] leading-tight">
                    BIG SALE<br>
                    Diskon Hingga <span class="font-bold">50%</span>
                </h1
                <p class="text-lg text-gray-700 max-w-lg">Berbagai produk pilihan berkualitas dengan harga istimewa, khusus untuk Anda.</p>
                <a href="#" class="btn-green text-lg px-8 py-3">Belanja Sekarang</a>
            </div>
            
            <div class="flex items-center justify-center md:justify-end gap-6 relative">
                <div class="bg-white p-4 rounded-3xl shadow-lg w-72 transform rotate-2">
                    <img src="{{ asset('images/produk1.jpg') }}" alt="minuman" class="rounded-xl w-full">
                    <div class="mt-3 text-center">
                        <p class="font-semibold text-lg text-gray-800">Pak Ketut</p>
                        <p class="text-sm text-pasardigital-green">camilan</p>
                    </div>
                </div>
                <div class="absolute -bottom-8 -left-8 bg-white p-3 rounded-2xl shadow-xl w-48 -rotate-3">
                    <img src="{{ asset('images/produk2.jpg') }}" alt="Krupuk in a Bowl" class="rounded-xl w-full">
                </div>
                <div class="bg-white p-3 rounded-2xl shadow-xl w-32 ml-4">
                    <img src="{{ asset('images/produk3.jpg') }}" alt="pakaian" class="rounded-xl w-full">
                </div>
            </div>
        </div>
    </section>

    <section class="py-8 bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div class="flex items-center gap-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
                <div class="text-3xl text-pasardigital-green"><i class="fas fa-box-open"></i></div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-lg">Gratis Ongkir</h3>
                    <p class="text-sm text-gray-600">Pengiriman gratis untuk wilayah tertentu.</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
                <div class="text-3xl text-pasardigital-green"><i class="fas fa-percent"></i></div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-lg">Diskon Member</h3>
                    <p class="text-sm text-gray-600">Promo eksklusif setiap bulan untuk member.</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-gray-50 p-6 rounded-xl border border-gray-100">
                <div class="text-3xl text-pasardigital-green"><i class="fas fa-headset"></i></div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-lg">Layanan 24/7</h3>
                    <p class="text-sm text-gray-600">Tim kami siap membantu Anda kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-10">Produk Unggulan Kami</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @php
                    $product1 = [
                        'image' => 'images/produk1.jpg',
                        'category' => 'Kerupuk',
                        'name' => 'minuman',
                        'rating' => 4,
                        'review_count' => 105,
                        'price' => 25000,
                        'sale_price' => 15000,
                    ];
                @endphp
                <x-product-card :product="$product1" />

                @php
                    $product2 = [
                        'image' => 'images/produk2.jpg',
                        'category' => 'Camilan',
                        'name' => 'makanan',
                        'rating' => 5,
                        'review_count' => 88,
                        'price' => 30000,
                        'sale_price' => 20000,
                    ];
                @endphp
                <x-product-card :product="$product2" />

                @php
                    $product3 = [
                        'image' => 'images/produk3.jpg',
                        'category' => 'pakaian',
                        'name' => 'pakaian',
                        'rating' => 4,
                        'review_count' => 15,
                        'price' => 18000,
                        'sale_price' => 18000, // No sale for this one
                    ];
                @endphp
                <x-product-card :product="$product3" />

            </div>
        </div>
    </section>

@endsection