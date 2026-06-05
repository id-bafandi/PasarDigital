<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-6xl mx-auto px-4">

            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900">Keranjang Belanja</h1>
                <p class="text-gray-500 mt-1">{{ $cart->items->sum('quantity') }} produk dipilih</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Daftar Produk --}}
                <div class="lg:col-span-2 space-y-4">
                    @if($cart->items->isEmpty())
                        <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                            <p class="text-4xl mb-4">🛒</p>
                            <p class="font-bold text-gray-700">Keranjang kamu kosong</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-block text-[#1D8267] font-bold">Mulai Belanja</a>
                        </div>
                    @else
                        @foreach($cart->items as $item)
                        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex gap-4 items-center" id="item-{{ $item->id }}">
                            <img src="{{ asset('images/' . ($item->product->gambar ?? 'produk1.jpg')) }}" class="w-24 h-24 rounded-xl object-cover">
                            <div class="flex-1">
                                <span class="text-xs font-bold text-[#1D8267] uppercase">{{ $item->product->category->nama_kategori ?? '' }}</span>
                                <h3 class="font-bold text-gray-900 mt-1">{{ $item->product->nama_produk }}</h3>
                                <p class="text-[#1D8267] font-black text-lg mt-1">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button onclick="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})"
                                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 font-bold text-lg flex items-center justify-center">-</button>
                                <span class="font-bold text-gray-900 w-6 text-center" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                <button onclick="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})"
                                    class="w-8 h-8 rounded-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold text-lg flex items-center justify-center">+</button>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-gray-900" id="subtotal-{{ $item->id }}">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                <button onclick="removeItem({{ $item->id }})" class="text-red-400 hover:text-red-600 text-sm mt-2">Hapus</button>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                {{-- Ringkasan Belanja --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-fit">
                    <h2 class="text-xl font-black text-gray-900 mb-6">Ringkasan Belanja</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-bold" id="total-price">Rp {{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span class="font-bold text-[#1D8267]">Gratis</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="font-black text-gray-900">Total</span>
                            <span class="font-black text-xl text-[#1D8267]" id="total">Rp {{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
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

    <script>
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function updateQty(itemId, newQty) {
            if (newQty < 1) {
                removeItem(itemId);
                return;
            }
            try {
                const res = await fetch(`/api/cart/update/${itemId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ quantity: newQty })
                });
                const data = await res.json();
                if (data.success) location.reload();
                else alert(data.message);
            } catch (err) {
                console.error(err);
            }
        }

        async function removeItem(itemId) {
            try {
                const res = await fetch(`/api/cart/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    }
                });
                const data = await res.json();
                if (data.success) location.reload();
                else alert(data.message);
            } catch (err) {
                console.error(err);
            }
        }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartBadge = document.getElementById('cart-badge');
        if (cartBadge) {
            cartBadge.classList.add('hidden');
        }
    });
    </script>
</x-app-layout>