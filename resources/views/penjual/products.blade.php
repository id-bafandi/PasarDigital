<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Produk Saya</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Daftar Produk</h3>
                    <a href="#" class="bg-[#1D8267] text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-[#1C2431] transition">
                        + Tambah Produk
                    </a>
                </div>
                <p class="text-gray-500 text-sm">Belum ada produk. Mulai tambahkan produk kamu!</p>
            </div>
        </div>
    </div>
</x-app-layout>