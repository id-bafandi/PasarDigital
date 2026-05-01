<x-app-layout>
<<<<<<< HEAD
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="text-gray-500">
                    Kamu masuk sebagai <span class="badge font-semibold text-[#1D8267] uppercase">{{ Auth::user()->role }}</span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-green-100 text-[#1D8267] rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-shopping-bag text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Pesanan Saya</h3>
                    <p class="text-sm text-gray-500 mb-4">Lihat status pesanan dan riwayat belanjaanmu.</p>
                    <a href="#" class="text-[#1D8267] font-semibold hover:underline">Buka Pesanan &rarr;</a>
                </div>

                @if(Auth::user()->role === 'penjual' || Auth::user()->role === 'admin')
                <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Manajemen Toko</h3>
                    <p class="text-sm text-gray-500 mb-4">Kelola produk, stok, dan pantau penjualan harian.</p>
                    <a href="#" class="text-blue-600 font-semibold hover:underline">Kelola Produk &rarr;</a>
                </div>
                @endif

                @if(Auth::user()->role === 'admin')
                <div class="p-6 bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition">
                    <div class="w-12 h-12 bg-yellow-400 text-gray-900 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-user-shield text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Panel Kontrol Master</h3>
                    <p class="text-sm text-gray-400 mb-4">Manajemen seluruh user, verifikasi toko, dan laporan sistem.</p>
                    <a href="#" class="text-yellow-400 font-semibold hover:underline">Buka Admin Panel &rarr;</a>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
=======
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
>>>>>>> main
