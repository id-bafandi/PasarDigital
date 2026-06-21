<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-2xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900">Konfirmasi Pembayaran</h1>
                <div class="flex items-center gap-2 mt-3 text-sm">
                    <span class="bg-gray-200 text-gray-500 px-3 py-1 rounded-full font-bold">1. Keranjang</span>
                    <span class="text-gray-300">→</span>
                    <span class="bg-gray-200 text-gray-500 px-3 py-1 rounded-full font-bold">2. Checkout</span>
                    <span class="text-gray-300">→</span>
                    <span class="bg-[#1D8267] text-white px-3 py-1 rounded-full font-bold">3. Pembayaran</span>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Detail Pembayaran --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-black text-gray-900 mb-4">Detail Pembayaran</h2>

                @if ($order->metode_pembayaran === 'qris')
                    <div class="bg-[#1D8267]/5 border border-[#1D8267]/20 rounded-xl p-4 mb-4 text-center">
                        <p class="text-sm text-gray-600 mb-2">Scan QR Code berikut:</p>
                        <img src="{{ route('konsumen.payment.qris', $order->id) }}" class="w-40 h-40 rounded-xl mx-auto object-contain">
                        <p class="text-sm font-bold text-[#1D8267] mt-2">PasarDigital</p>
                    </div>
                @else
                    <div class="bg-[#1D8267]/5 border border-[#1D8267]/20 rounded-xl p-4 mb-4">
                        <p class="text-sm text-gray-600 mb-1">Bayar langsung saat produk tiba</p>
                        <p class="font-black text-xl text-gray-900">COD - Bayar di Tempat</p>
                        <p class="text-sm font-bold text-[#1D8267]">Siapkan uang pas saat pengiriman</p>
                    </div>
                @endif

                <div class="flex justify-between items-center bg-gray-50 rounded-xl p-4">
                    <div>
                        <p class="text-sm text-gray-500">Total yang harus dibayar</p>
                        <p class="text-2xl font-black text-[#1D8267]">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-bold text-yellow-500 capitalize">{{ $order->status }}</p>
                    </div>
                </div>
            </div>

            {{-- Upload Bukti (QRIS) / Konfirmasi (COD) --}}
            @if ($order->metode_pembayaran === 'qris')
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h2 class="text-lg font-black text-gray-900 mb-4">Upload Bukti Transfer</h2>
                    <form action="{{ route('konsumen.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-[#1D8267] transition cursor-pointer"
                            onclick="document.getElementById('bukti-file').click()">
                            <div class="text-4xl mb-3">📎</div>
                            <p class="font-bold text-gray-700" id="upload-label">Klik untuk upload foto bukti transfer</p>
                            <p class="text-sm text-gray-400 mt-1">Format: JPG, PNG (Max 2MB)</p>
                            <input type="file" id="bukti-file" name="proof" accept="image/*" class="hidden"
                                onchange="document.getElementById('upload-label').textContent = this.files[0].name">
                        </div>
                        @error('proof')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                            class="mt-4 w-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold py-4 rounded-2xl transition">
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                    @if ($order->status === 'pending')
                        <h2 class="text-lg font-black text-gray-900 mb-2">Konfirmasi Pesanan</h2>
                        <p class="text-sm text-gray-500 mb-4">Pesananmu sedang diproses. Pembayaran dilakukan saat barang tiba.</p>
                        <form action="{{ route('konsumen.payment.confirm', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold py-4 rounded-2xl transition">
                                Konfirmasi Pesanan COD
                            </button>
                        </form>
                    @else
                        <div class="text-center py-4">
                            <p class="text-4xl mb-3">✅</p>
                            <h2 class="text-lg font-black text-gray-900">Pesanan Dikonfirmasi!</h2>
                            <p class="text-sm text-gray-500 mt-1">Pesananmu sedang dalam proses pengiriman.</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Ringkasan Pesanan --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-black text-gray-900 mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-3 mb-4">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-700 font-medium">{{ $item->product->nama_produk ?? 'Produk' }}</span>
                                <span class="text-gray-400">x{{ $item->jumlah }}</span>
                            </div>
                            <span class="font-bold">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="space-y-2 text-sm border-t border-gray-100 pt-4">
                    <div class="flex justify-between text-gray-600">
                        <span>No. Pesanan</span>
                        <span class="font-bold">#{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tanggal</span>
                        <span class="font-bold">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Metode Pembayaran</span>
                        <span class="font-bold uppercase">{{ $order->metode_pembayaran }}</span>
                    </div>
                    <div class="flex justify-between font-black text-gray-900 pt-2 border-t border-gray-100">
                        <span>Total</span>
                        <span class="text-[#1D8267]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('konsumen.orders') }}"
                class="w-full border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-4 rounded-2xl transition text-center block">
                Lihat Status Pesanan
            </a>

        </div>
    </div>
</x-app-layout>