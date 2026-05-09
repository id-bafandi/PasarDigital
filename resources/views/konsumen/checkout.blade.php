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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Form Checkout --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Alamat Pengiriman --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-lg font-black text-gray-900 mb-5">Alamat Pengiriman</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-bold text-gray-700 mb-1 block">Nama Penerima</label>
                                <input type="text" placeholder="Nama lengkap" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-700 mb-1 block">No. Telepon</label>
                                <input type="text" placeholder="08xxxxxxxxxx" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-sm font-bold text-gray-700 mb-1 block">Alamat Lengkap</label>
                                <textarea placeholder="Jalan, RT/RW, Kelurahan..." rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20"></textarea>
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-700 mb-1 block">Kota</label>
                                <input type="text" placeholder="Kota/Kabupaten" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                            </div>
                            <div>
                                <label class="text-sm font-bold text-gray-700 mb-1 block">Kode Pos</label>
                                <input type="text" placeholder="Kode pos" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                            </div>
                        </div>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-lg font-black text-gray-900 mb-5">Metode Pembayaran</h2>
                        <div class="space-y-3">
                            <label class="flex items-center gap-4 p-4 border-2 border-[#1D8267] rounded-xl cursor-pointer bg-[#1D8267]/5">
                                <input type="radio" name="payment" checked class="accent-[#1D8267]">
                                <div>
                                    <p class="font-bold text-gray-900">Transfer Bank (BCA)</p>
                                    <p class="text-xs text-gray-500">No. Rek: 1234567890 a.n PasarDigital</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#1D8267]">
                                <input type="radio" name="payment" class="accent-[#1D8267]">
                                <div>
                                    <p class="font-bold text-gray-900">Transfer Bank (Mandiri)</p>
                                    <p class="text-xs text-gray-500">No. Rek: 0987654321 a.n PasarDigital</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-[#1D8267]">
                                <input type="radio" name="payment" class="accent-[#1D8267]">
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
                        <div class="space-y-3">
                            <div class="flex gap-3 items-center">
                                <img src="{{ asset('images/produk1.jpg') }}" class="w-12 h-12 rounded-lg object-cover">
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-900">Coastal's Hard Coco</p>
                                    <p class="text-xs text-gray-500">x1</p>
                                </div>
                                <p class="text-sm font-bold">Rp 15.000</p>
                            </div>
                            <div class="flex gap-3 items-center">
                                <img src="{{ asset('images/produk2.jpg') }}" class="w-12 h-12 rounded-lg object-cover">
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-900">Bots Snack Original</p>
                                    <p class="text-xs text-gray-500">x2</p>
                                </div>
                                <p class="text-sm font-bold">Rp 40.000</p>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 mt-4 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-bold">Rp 75.000</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkir</span>
                                <span class="font-bold text-[#1D8267]">Gratis</span>
                            </div>
                            <div class="flex justify-between font-black text-gray-900 text-base pt-2 border-t border-gray-100">
                                <span>Total</span>
                                <span class="text-[#1D8267]">Rp 70.000</span>
                            </div>
                        </div>
                        <a href="{{ route('konsumen.payment') }}"
                           class="mt-5 w-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold py-4 rounded-2xl transition text-center block">
                            Konfirmasi Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>