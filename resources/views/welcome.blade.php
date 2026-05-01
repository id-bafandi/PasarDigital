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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($products as $item)
                <div class="group bg-white rounded-[2rem] p-5 border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500">
                    <div class="relative overflow-hidden rounded-3xl mb-6">
                        <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                            <span class="bg-red-500 text-white text-[10px] font-black px-3 py-1.5 rounded-full shadow-lg">{{ $item['discount'] }}</span>
                        </div>
                        <button class="absolute top-4 right-4 z-10 p-3 bg-white/90 backdrop-blur rounded-full shadow-md text-gray-400 hover:text-red-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </button>
                        <img src="{{ asset('images/' . $item['image']) }}" class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div>
                        <span class="text-xs font-bold text-[#1D8267] uppercase tracking-widest">{{ $item['category'] }}</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-1 mb-2">{{ $item['name'] }}</h3>
                        <div class="flex items-center gap-1 mb-4">
                            <div class="flex text-yellow-400">★★  ★★</div>
                            <div class="text-gray-300">★</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-2xl font-black text-gray-900">Rp {{ $item['price'] }}</p>
                            </div>
                            <button class="bg-[#1D8267] text-white p-4 rounded-2xl hover:bg-black transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection