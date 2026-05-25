<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-900">Dashboard Admin</h1>
                <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Pembeli</p>
                    <p class="text-3xl font-black text-[#1D8267]">{{ $totalUser }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Penjual</p>
                    <p class="text-3xl font-black text-blue-600">{{ $totalPenjual }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Produk</p>
                    <p class="text-3xl font-black text-purple-600">{{ $totalProduk }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Pesanan</p>
                    <p class="text-3xl font-black text-gray-900">{{ $totalPesanan }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Pesanan Pending</p>
                    <p class="text-3xl font-black text-yellow-500">{{ $pesananPending }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-black text-[#1D8267]">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Menu Navigasi Admin --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <a href="{{ route('admin.users') }}"
                    class="bg-[#1C2431] hover:bg-[#1D8267] text-white rounded-2xl p-5 text-center transition group">
                    <p class="text-2xl mb-2">👥</p>
                    <p class="font-black text-sm">Kelola User</p>
                </a>
                <a href="{{ route('admin.orders') }}"
                    class="bg-[#1C2431] hover:bg-[#1D8267] text-white rounded-2xl p-5 text-center transition group">
                    <p class="text-2xl mb-2">📦</p>
                    <p class="font-black text-sm">Kelola Pesanan</p>
                </a>
                <a href="{{ route('admin.products') }}"
                    class="bg-[#1C2431] hover:bg-[#1D8267] text-white rounded-2xl p-5 text-center transition group">
                    <p class="text-2xl mb-2">🛍️</p>
                    <p class="font-black text-sm">Kelola Produk</p>
                </a>
                <a href="{{ route('admin.payments') }}"
                    class="bg-[#1C2431] hover:bg-[#1D8267] text-white rounded-2xl p-5 text-center transition group">
                    <p class="text-2xl mb-2">💳</p>
                    <p class="font-black text-sm">Konfirmasi Bayar</p>
                </a>
            </div>

            {{-- Pesanan Terbaru --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-black text-gray-900 mb-4">Pesanan Terbaru</h2>
                @if ($pesananTerbaru->isEmpty())
                    <p class="text-gray-400 text-sm">Belum ada pesanan.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($pesananTerbaru as $order)
                            <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">#{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->name }} · {{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-sm text-[#1D8267]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    <span class="text-xs px-2 py-0.5 rounded-full font-bold
                                        @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif ($order->status === 'processing') bg-blue-100 text-blue-700
                                        @elseif ($order->status === 'delivered') bg-green-100 text-green-700
                                        @elseif ($order->status === 'cancelled') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>