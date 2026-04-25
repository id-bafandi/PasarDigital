<x-app-layout>
    <section class="bg-[#E7F3EF] py-16">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <span class="inline-block bg-orange-100 text-orange-600 px-4 py-1.5 rounded-full text-sm font-bold tracking-wide uppercase">Spesial Promo Hari Ini</span>
                <h1 class="text-6xl font-black text-[#1D8267] leading-[1.1]">
                    BIG SALE<br>
                    <span class="text-black">Diskon Hingga</span> <span class="text-orange-500">50%</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-lg leading-relaxed">Nikmati berbagai pilihan produk segar dan berkualitas dengan harga yang lebih terjangkau hanya di PasarDigital.</p>
                <div class="flex gap-4">
                    <a href="#" class="bg-[#1D8267] text-white px-10 py-4 rounded-2xl font-bold hover:bg-black transition-all shadow-xl hover:-translate-y-1">Belanja Sekarang</a>
                    <a href="#" class="bg-white text-gray-800 px-10 py-4 rounded-2xl font-bold border border-gray-200 hover:bg-gray-50 transition-all">Lihat Promo</a>
                </div>
            </div>

            <div class="relative flex justify-center items-center">
                <div class="absolute inset-0 bg-green-200 blur-[100px] opacity-30 rounded-full"></div>
                <div class="relative grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-[2.5rem] shadow-2xl transform -rotate-6 hover:rotate-0 transition-transform duration-500 w-full">
                        <img src="{{ asset('images/produk1.jpg') }}" class="rounded-[2rem] w-full h-64 object-cover">
                        <div class="mt-4 text-center">
                            <h3 class="font-bold text-gray-800 text-sm">Coastal's Fresh</h3>
                            <p class="text-[10px] text-green-600 font-medium italic">Minuman Segar</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-[2.5rem] shadow-2xl transform rotate-6 hover:rotate-0 transition-transform duration-500 w-full mt-12">
                        <img src="{{ asset('images/produk2.jpg') }}" class="rounded-[2rem] w-full h-64 object-cover">
                        <div class="mt-4 text-center">
                            <h3 class="font-bold text-gray-800 text-sm">Bots Snack</h3>
                            <p class="text-[10px] text-green-600 font-medium italic">Camilan Gurih</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-[2.5rem] shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform duration-500 w-full hidden md:block">
                        <img src="{{ asset('images/produk3.jpg') }}" class="rounded-[2rem] w-full h-64 object-cover">
                        <div class="mt-4 text-center">
                            <h3 class="font-bold text-gray-800 text-sm">Produk Baru</h3>
                            <p class="text-[10px] text-green-600 font-medium italic">Kategori Pilihan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 mb-2">Produk Unggulan Kami</h2>
                    <p class="text-gray-500">Koleksi terbaik yang paling banyak dicari minggu ini</p>
                </div>
                <a href="#" class="text-[#1D8267] font-bold border-b-2 border-[#1D8267] pb-1 hover:text-black hover:border-black transition-colors">Lihat Semua Produk</a>
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
</x-app-layout>