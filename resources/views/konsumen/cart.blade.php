<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-6xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900">Keranjang Belanja</h1>
                <p class="text-gray-500 mt-1">3 produk dipilih</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Daftar Produk --}}
                <div class="lg:col-span-2 space-y-4">

                    {{-- Item 1 --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex gap-4 items-center">
                        <img src="{{ asset('images/produk1.jpg') }}" class="w-24 h-24 rounded-xl object-cover">
                        <div class="flex-1">
                            <span class="text-xs font-bold text-[#1D8267] uppercase">Minuman</span>
                            <h3 class="font-bold text-gray-900 mt-1">Coastal's Hard Coco</h3>
                            <p class="text-[#1D8267] font-black text-lg mt-1">Rp 15.000</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 font-bold text-lg flex items-center justify-center">-</button>
                            <span class="font-bold text-gray-900 w-6 text-center">1</span>
                            <button class="w-8 h-8 rounded-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold text-lg flex items-center justify-center">+</button>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-gray-900">Rp 15.000</p>
                            <button class="text-red-400 hover:text-red-600 text-sm mt-2">Hapus</button>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex gap-4 items-center">
                        <img src="{{ asset('images/produk2.jpg') }}" class="w-24 h-24 rounded-xl object-cover">
                        <div class="flex-1">
                            <span class="text-xs font-bold text-[#1D8267] uppercase">Makanan</span>
                            <h3 class="font-bold text-gray-900 mt-1">Bots Snack Original</h3>
                            <p class="text-[#1D8267] font-black text-lg mt-1">Rp 20.000</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 font-bold text-lg flex items-center justify-center">-</button>
                            <span class="font-bold text-gray-900 w-6 text-center">2</span>
                            <button class="w-8 h-8 rounded-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold text-lg flex items-center justify-center">+</button>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-gray-900">Rp 40.000</p>
                            <button class="text-red-400 hover:text-red-600 text-sm mt-2">Hapus</button>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex gap-4 items-center">
                        <img src="{{ asset('images/produk3.jpg') }}" class="w-24 h-24 rounded-xl object-cover">
                        <div class="flex-1">
                            <span class="text-xs font-bold text-[#1D8267] uppercase">Pakaian</span>
                            <h3 class="font-bold text-gray-900 mt-1">Bots Snack Original</h3>
                            <p class="text-[#1D8267] font-black text-lg mt-1">Rp 20.000</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 font-bold text-lg flex items-center justify-center">-</button>
                            <span class="font-bold text-gray-900 w-6 text-center">1</span>
                            <button class="w-8 h-8 rounded-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold text-lg flex items-center justify-center">+</button>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-gray-900">Rp 20.000</p>
                            <button class="text-red-400 hover:text-red-600 text-sm mt-2">Hapus</button>
                        </div>
                    </div>
                </div>

                {{-- Ringkasan Belanja --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-fit">
                    <h2 class="text-xl font-black text-gray-900 mb-6">Ringkasan Belanja</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal (4 produk)</span>
                            <span class="font-bold">Rp 75.000</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span class="font-bold text-[#1D8267]">Gratis</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Diskon</span>
                            <span class="font-bold text-red-500">- Rp 5.000</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="font-black text-gray-900">Total</span>
                            <span class="font-black text-xl text-[#1D8267]">Rp 70.000</span>
                        </div>
                    </div>

                    <a href="{{ route('konsumen.checkout') }}" 
                       class="mt-6 w-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold py-4 rounded-2xl transition text-center block">
                        Lanjut ke Checkout
                    </a>
                    <a href="{{ route('home') }}" 
                       class="mt-3 w-full border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-4 rounded-2xl transition text-center block">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>