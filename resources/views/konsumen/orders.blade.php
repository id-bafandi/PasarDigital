<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-4xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900">Riwayat Pesanan</h1>
                <p class="text-gray-500 mt-1">Semua pesanan yang pernah kamu buat</p>
            </div>

            @if ($orders->isEmpty())
                <div class="bg-white rounded-2xl p-10 shadow-sm border border-gray-100 text-center">
                    <p class="text-4xl mb-3">🛍️</p>
                    <p class="font-bold text-gray-700">Belum ada pesanan</p>
                    <p class="text-sm text-gray-400 mt-1">Yuk mulai belanja!</p>
                    <a href="{{ route('home') }}"
                        class="mt-5 inline-block bg-[#1D8267] hover:bg-[#166651] text-white font-bold px-6 py-3 rounded-2xl transition text-sm">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="font-black text-gray-900">#{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold capitalize
                                    @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif ($order->status === 'processing') bg-blue-100 text-blue-700
                                    @elseif ($order->status === 'shipped') bg-purple-100 text-purple-700
                                    @elseif ($order->status === 'delivered') bg-green-100 text-green-700
                                    @elseif ($order->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </div>

                            {{-- Item produk --}}
                            <div class="space-y-2 mb-4">
                                @foreach ($order->items as $item)
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>{{ $item->product->nama_produk ?? 'Produk' }} <span class="text-gray-400">x{{ $item->jumlah }}</span></span>
                                        <span class="font-bold">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                                <div>
                                    <p class="text-xs text-gray-500">Metode Pembayaran</p>
                                    <p class="text-sm font-bold uppercase">{{ $order->metode_pembayaran ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Total</p>
                                    <p class="font-black text-[#1D8267]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>