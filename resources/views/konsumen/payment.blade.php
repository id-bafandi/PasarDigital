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

            {{-- Info Pembayaran --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-black text-gray-900 mb-4">Detail Pembayaran</h2>
                <div class="bg-[#1D8267]/5 border border-[#1D8267]/20 rounded-xl p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-1">Transfer ke rekening:</p>
                    <p class="font-black text-2xl text-gray-900 tracking-wider">1234 5678 90</p>
                    <p class="text-sm font-bold text-[#1D8267]">BCA - a.n PasarDigital</p>
                </div>
                <div class="flex justify-between items-center bg-gray-50 rounded-xl p-4">
                    <div>
                        <p class="text-sm text-gray-500">Total yang harus dibayar</p>
                        <p class="text-2xl font-black text-[#1D8267]">Rp 70.000</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Batas waktu</p>
                        <p class="font-bold text-red-500">23:45:00</p>
                    </div>
                </div>
            </div>

            {{-- Upload Bukti --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-black text-gray-900 mb-4">Upload Bukti Transfer</h2>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-[#1D8267] transition cursor-pointer">
                    <div class="text-4xl mb-3">📎</div>
                    <p class="font-bold text-gray-700">Klik untuk upload foto bukti transfer</p>
                    <p class="text-sm text-gray-400 mt-1">Format: JPG, PNG, PDF (Max 2MB)</p>
                    <input type="file" class="hidden">
                </div>
            </div>

            {{-- Ringkasan Pesanan --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-black text-gray-900 mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>No. Pesanan</span>
                        <span class="font-bold">#ORD-2026050001</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tanggal</span>
                        <span class="font-bold">8 Mei 2026</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Metode Pembayaran</span>
                        <span class="font-bold">Transfer BCA</span>
                    </div>
                    <div class="flex justify-between text-gray-600 pt-2 border-t border-gray-100">
                        <span class="font-black text-gray-900">Total</span>
                        <span class="font-black text-[#1D8267]">Rp 70.000</span>
                    </div>
                </div>
            </div>

            <button class="w-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold py-4 rounded-2xl transition">
                Konfirmasi Pembayaran
            </button>
            <a href="{{ route('konsumen.orders') }}" class="mt-3 w-full border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-4 rounded-2xl transition text-center block">
                Lihat Status Pesanan
            </a>
        </div>
    </div>
</x-app-layout>