@php
    $wishlistIds = $wishlistIds ?? [];
@endphp
<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-6xl mx-auto px-4">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-[#1D8267] transition">Beranda</a>
                <span class="text-gray-300">→</span>
                <span class="text-gray-400">{{ $product->category->nama_kategori ?? '' }}</span>
                <span class="text-gray-300">→</span>
                <span class="text-gray-900 font-bold">{{ $product->nama_produk }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-10">

                {{-- KIRI: Gambar --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex items-center justify-center p-8" style="min-height: 420px;">
                    <img src="{{ asset('images/' . ($product->gambar ?? 'produk1.jpg')) }}"
                        class="max-h-80 w-auto object-contain rounded-2xl drop-shadow-xl">
                </div>

                {{-- KANAN: Info --}}
                <div class="flex flex-col justify-between space-y-5">

                    {{-- Kategori & Nama --}}
                    <div>
                        <span class="inline-block bg-[#1D8267]/10 text-[#1D8267] text-xs font-black px-3 py-1 rounded-full uppercase tracking-widest mb-2">
                            {{ $product->category->nama_kategori ?? '' }}
                        </span>
                        <h1 class="text-4xl font-black text-gray-900 leading-tight">{{ $product->nama_produk }}</h1>
                    </div>

                    {{-- Rating --}}
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400 text-xl">★★★★</div>
                        <div class="text-gray-300 text-xl">★</div>
                        <span class="text-sm font-bold text-gray-500">4.0</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-sm text-gray-400">128 ulasan</span>
                    </div>

                    {{-- Harga --}}
                    <div class="bg-gradient-to-r from-[#1D8267]/10 to-transparent rounded-2xl p-5 border border-[#1D8267]/20">
                        <p class="text-sm text-gray-500 mb-1">Harga</p>
                        <p class="text-5xl font-black text-[#1D8267]">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Stok --}}
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full {{ $product->stok > 5 ? 'bg-green-500' : ($product->stok > 0 ? 'bg-yellow-500' : 'bg-red-500') }}"></div>
                        <span class="text-sm font-bold {{ $product->stok > 5 ? 'text-green-600' : ($product->stok > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $product->stok > 0 ? $product->stok . ' stok tersedia' : 'Stok habis' }}
                        </span>
                    </div>

                    {{-- Penjual --}}
                    <div class="flex items-center gap-3 bg-gray-50 rounded-2xl p-4 border border-gray-100">
                        <div class="w-11 h-11 bg-[#1C2431] rounded-full flex items-center justify-center text-white font-black">
                            {{ substr($product->seller->name ?? 'P', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Dijual oleh</p>
                            <p class="font-black text-gray-900">{{ $product->seller->name ?? 'PasarDigital' }}</p>
                        </div>
                        <div class="ml-auto">
                            <span class="text-xs bg-green-100 text-green-700 font-bold px-2 py-1 rounded-full">✓ Terverifikasi</span>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    @auth
                        @if(Auth::user()->role === 'user')
                            @if($product->stok > 0)
                                <div class="flex gap-3">
                                    <button onclick="addToCart({{ $product->id }})"
                                        class="flex-1 bg-[#1D8267] hover:bg-[#166651] text-white font-black py-4 rounded-2xl transition-all hover:shadow-lg hover:shadow-[#1D8267]/30 flex items-center justify-center gap-2 text-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>
                                    <button onclick="toggleWishlist({{ $product->id }}, this)"
                                        class="p-4 border-2 {{ in_array($product->id, $wishlistIds) ? 'border-red-400 text-red-500 bg-red-50' : 'border-gray-200 text-gray-400' }} rounded-2xl hover:border-red-400 hover:text-red-500 hover:bg-red-50 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7"
                                            fill="{{ in_array($product->id, $wishlistIds) ? 'currentColor' : 'none' }}"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <button disabled class="w-full bg-gray-100 text-gray-400 font-black py-4 rounded-2xl cursor-not-allowed text-lg">
                                    Stok Habis
                                </button>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="w-full bg-[#1D8267] hover:bg-[#166651] text-white font-black py-4 rounded-2xl transition text-center block text-lg">
                            Login untuk Membeli
                        </a>
                    @endauth

                    <a href="{{ route('home') }}"
                        class="w-full border border-gray-200 hover:bg-gray-50 text-gray-600 font-bold py-3 rounded-2xl transition text-center block text-sm">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>

            {{-- BAWAH: Deskripsi --}}
            @if ($product->deskripsi)
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-black text-gray-900 mb-4 flex items-center gap-2">
                        📋 Deskripsi Produk
                    </h3>
                    <p class="text-gray-600 leading-relaxed text-base">{{ $product->deskripsi }}</p>
                </div>
            @endif

        </div>
    </div>

    <script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    async function addToCart(productId) {
        try {
            const res = await fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            });
            const data = await res.json();
            if (data.success) {
                const cartBadge = document.getElementById('cart-badge');
                if (cartBadge) {
                    cartBadge.textContent = data.data.total_items;
                    cartBadge.classList.remove('hidden');
                }
                alert('Produk berhasil ditambahkan ke keranjang!');
            } else {
                alert(data.message);
            }
        } catch (err) {
            console.error(err);
        }
    }

    async function toggleWishlist(productId, btn) {
        try {
            const res = await fetch(`/api/wishlist/${productId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });
            const data = await res.json();
            if (data.success) {
                const svg = btn.querySelector('svg');
                const badge = document.getElementById('wishlist-badge');
                if (data.wishlisted) {
                    svg.setAttribute('fill', 'currentColor');
                    btn.classList.add('border-red-400', 'text-red-500', 'bg-red-50');
                    btn.classList.remove('border-gray-200', 'text-gray-400');
                    if (badge) { badge.textContent = parseInt(badge.textContent) + 1; badge.classList.remove('hidden'); }
                } else {
                    svg.setAttribute('fill', 'none');
                    btn.classList.remove('border-red-400', 'text-red-500', 'bg-red-50');
                    btn.classList.add('border-gray-200', 'text-gray-400');
                    if (badge) { const c = parseInt(badge.textContent) - 1; badge.textContent = c; if (c <= 0) badge.classList.add('hidden'); }
                }
            }
        } catch (err) {
            console.error(err);
        }
    }
    </script>
</x-app-layout>