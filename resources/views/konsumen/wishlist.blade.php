<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-6xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900">Favorit Saya</h1>
                <p class="text-gray-500 mt-1">Produk yang kamu simpan</p>
            </div>

            @if ($wishlists->isEmpty())
                <div class="bg-white rounded-2xl p-10 shadow-sm border border-gray-100 text-center">
                    <p class="text-4xl mb-3">❤️</p>
                    <p class="font-bold text-gray-700">Belum ada produk favorit</p>
                    <p class="text-sm text-gray-400 mt-1">Klik ikon hati di produk untuk menyimpannya</p>
                    <a href="{{ route('home') }}"
                        class="mt-5 inline-block bg-[#1D8267] hover:bg-[#166651] text-white font-bold px-6 py-3 rounded-2xl transition text-sm">
                        Jelajahi Produk
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($wishlists as $wishlist)
                        <div class="group bg-white rounded-[2rem] p-5 border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500">
                            <div class="relative overflow-hidden rounded-3xl mb-4">
                                <button onclick="toggleWishlist({{ $wishlist->product->id }}, this)"
                                    class="absolute top-4 right-4 z-10 p-3 bg-white/90 backdrop-blur rounded-full shadow-md transition-all wishlisted">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <img src="{{ asset('images/' . ($wishlist->product->gambar ?? 'produk1.jpg')) }}"
                                    class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-700">
                            </div>
                            <div>
                                <span class="text-xs font-bold text-[#1D8267] uppercase tracking-widest">
                                    {{ $wishlist->product->category->nama_kategori ?? '' }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-800 mt-1 mb-3">{{ $wishlist->product->nama_produk }}</h3>
                                <div class="flex items-center justify-between">
                                    <p class="text-xl font-black text-gray-900">
                                        Rp {{ number_format($wishlist->product->harga, 0, ',', '.') }}
                                    </p>
                                    <button onclick="addToCart({{ $wishlist->product->id }})"
                                        class="bg-[#1D8267] text-white p-3 rounded-2xl hover:bg-black transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

    <script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
            if (data.success && !data.wishlisted) {
                // Hapus card dari tampilan
                btn.closest('.group').remove();
            }
        } catch (err) {
            console.error(err);
        }
    }

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
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.textContent = data.data.total_items;
                    badge.classList.remove('hidden');
                }
                alert('Produk berhasil ditambahkan ke keranjang!');
            } else {
                alert(data.message);
            }
        } catch (err) {
            console.error(err);
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
    const badge = document.getElementById('wishlist-badge');
    if (badge) {
        badge.classList.add('hidden');
    }
});
    </script>
</x-app-layout>