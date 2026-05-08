<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold">Selamat datang, {{ auth()->user()->name }}!</h3>
                <p class="text-gray-600 mt-2">Role: <span class="font-bold text-blue-600 uppercase">{{ auth()->user()->role }}</span></p>

                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-blue-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-black text-blue-600">0</p>
                        <p class="text-sm text-gray-500 mt-1">Total Pesanan</p>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-4 text-center">
                        <p class="text-2xl font-black text-purple-600">0</p>
                        <p class="text-sm text-gray-500 mt-1">Pesanan Selesai</p>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('home') }}" 
                       class="bg-[#1D8267] text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-[#1C2431] transition">
                        Belanja Sekarang
                    </a>
                    <a href="{{ route('konsumen.orders') }}" 
                       class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition">
                        Riwayat Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>