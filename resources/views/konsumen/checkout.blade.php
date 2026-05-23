<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-6xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900">Checkout</h1>
                <div class="flex items-center gap-2 mt-3 text-sm">
                    <span class="bg-[#1D8267] text-white px-3 py-1 rounded-full font-bold">1. Keranjang</span>
                    <span class="text-gray-300">→</span>
                    <span class="bg-[#1D8267] text-white px-3 py-1 rounded-full font-bold">2. Checkout</span>
                    <span class="text-gray-300">→</span>
                    <span class="bg-gray-200 text-gray-500 px-3 py-1 rounded-full font-bold">3. Pembayaran</span>
                </div>
            </div>

            {{-- Alert Error --}}
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- ✅ FORM DITAMBAHKAN DI SINI --}}
            <form action="{{ route('konsumen.checkout.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Form Checkout --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Alamat Pengiriman --}}
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-black text-gray-900 mb-5">Alamat Pengiriman</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-bold text-gray-700 mb-1 block">
                                        Nama Penerima <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama_penerima"
                                        value="{{ old('nama_penerima', $user->name ?? '') }}"
                                        placeholder="Nama lengkap"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20 @error('nama_penerima') border-red-400 @enderror">
                                    @error('nama_penerima')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm font-bold text-gray-700 mb-1 block">
                                        No. Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="no_telepon"
                                        value="{{ old('no_telepon') }}"
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20 @error('no_telepon') border-red-400 @enderror">
                                    @error('no_telepon')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-sm font-bold text-gray-700 mb-1 block">
                                        Alamat Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="alamat_pengiriman" rows="3"
                                        placeholder="Jalan, RT/RW, Kelurahan..."
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20 @error('alamat_pengiriman') border-red-400 @enderror">{{ old('alamat_pengiriman') }}</textarea>
                                    @error('alamat_pengiriman')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="text-sm font-bold text-gray-700 mb-1 block">Kota</label>
                                    <input type="text" name="kota"
                                        value="{{ old('kota') }}"
                                        placeholder="Kota/Kabupaten"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                                </div>
                                <div>
                                    <label class="text-sm font-bold text-gray-700 mb-1 block">Kode Pos</label>
                                    <input type="text" name="kode_pos"
                                        value="{{ old('kode_pos') }}"
                                        placeholder="Kode pos"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-sm font-bold text-gray-700 mb-1 block">Catatan (opsional)</label>
                                    <input type="text" name="catatan"
                                        value="{{ old('catatan') }}"
                                        placeholder="Misal: titip satpam, pintu biru, dll"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                                </div>
                            </div>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-black text-gray-900 mb-5">Metode Pembayaran</h2>
                            <div class="space-y-3">
                                <label class="flex items-center gap-4 p-4 border-2 border-[#1D8267] rounded-xl cursor-pointer bg-[#1D8267]/5">
                                    <input type="radio" name="metode_pembayaran" value="qris" checked class="accent-[#1D8267]">
                                    <div>
                                        <p class="font-bold text-gray-900">QRIS</p>
                                        <p class="text-xs text-gray-500">Bayar dengan scan QR code via aplikasi apapun</p>
                                    </div>
                                </label>
                                <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#1D8267]">
                                    <input type="radio" name="metode_pembayaran" value="cod" class="accent-[#1D8267]">
                                    <div>
                                        <p class="font-bold text-gray-900">COD (Bayar di Tempat)</p>
                                        <p class="text-xs text-gray-500">Tersedia untuk wilayah tertentu</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Ringkasan Order --}}
                    <div class="space-y-4">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <h2 class="text-lg font-black text-gray-900 mb-4">Ringkasan Order</h2>

                            {{-- ✅ Produk dari cart (dynamic) --}}
                            <div class="space-y-3">
                                @foreach ($cart->items as $item)
                                    <div class="flex gap-3 items-center">
                                        <img src="{{ asset('images/' . ($item->product->gambar ?? 'produk1.jpg')) }}"
                                            class="w-12 h-12 rounded-lg object-cover">
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-gray-900">{{ $item->product->nama_produk }}</p>
                                            <p class="text-xs text-gray-500">x{{ $item->quantity }}</p>
                                        </div>
                                        <p class="text-sm font-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>

                            {{-- ✅ Total dari cart (dynamic) --}}
                            <div class="border-t border-gray-100 mt-4 pt-4 space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Ongkir</span>
                                    <span class="font-bold text-[#1D8267]">Gratis</span>
                                </div>
                                <div class="flex justify-between font-black text-gray-900 text-base pt-2 border-t border-gray-100">
                                    <span>Total</span>
                                    <span class="text-[#1D8267]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            {{-- ✅ Tombol submit di dalam form --}}
                            <button type="submit"
                                class="mt-5 w-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold py-4 rounded-2xl transition text-center block">
                                Konfirmasi Pesanan
                            </button>

                            <a href="{{ route('konsumen.cart') }}"
                                class="mt-3 w-full border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-2xl transition text-center block text-sm">
                                ← Kembali ke Keranjang
                            </a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
<script>
    document.querySelectorAll('input[name="metode_pembayaran"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[name="metode_pembayaran"]').forEach(r => {
                r.closest('label').classList.remove('border-2', 'border-[#1D8267]', 'bg-[#1D8267]/5');
                r.closest('label').classList.add('border', 'border-gray-200');
            });
            this.closest('label').classList.remove('border', 'border-gray-200');
            this.closest('label').classList.add('border-2', 'border-[#1D8267]', 'bg-[#1D8267]/5');
        });
    });
</script>
</x-app-layout>
