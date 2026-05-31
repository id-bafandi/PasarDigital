<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900">Dashboard Penjual</h1>
                <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Produk</p>
                    <p class="text-3xl font-black text-[#1D8267]">{{ $totalProduk }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Terjual</p>
                    <p class="text-3xl font-black text-blue-600">{{ $totalTerjual }}</p>
                </div>
            </div>

            {{-- Menu --}}
            <div class="grid grid-cols-2 gap-4 mb-8">
                <a href="{{ route('penjual.products') }}"
                    class="bg-[#1C2431] hover:bg-[#1D8267] text-white rounded-2xl p-5 text-center transition">
                    <p class="text-2xl mb-2">🛍️</p>
                    <p class="font-black text-sm">Kelola Produk</p>
                </a>
                <a href="{{ route('penjual.products.create') }}"
                    class="bg-[#1D8267] hover:bg-[#166651] text-white rounded-2xl p-5 text-center transition">
                    <p class="text-2xl mb-2">➕</p>
                    <p class="font-black text-sm">Tambah Produk</p>
                </a>
            </div>

            {{-- Produk Terbaru --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-black text-gray-900 mb-4">Produk Terbaru</h2>
                @if ($produkTerbaru->isEmpty())
                    <p class="text-gray-400 text-sm">Belum ada produk. Mulai tambahkan!</p>
                @else
                    <div class="space-y-3">
                        @foreach ($produkTerbaru as $product)
                            <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('images/' . ($product->gambar ?? 'produk1.jpg')) }}"
                                        class="w-10 h-10 rounded-xl object-cover">
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">{{ $product->nama_produk }}</p>
                                        <p class="text-xs text-gray-500">{{ $product->category->nama_kategori ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-sm text-[#1D8267]">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Stok: {{ $product->stok }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>