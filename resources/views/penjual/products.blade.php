<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Produk Saya</h1>
                    <p class="text-gray-500 mt-1">Kelola semua produk kamu</p>
                </div>
                <a href="{{ route('penjual.products.create') }}"
                    class="bg-[#1D8267] hover:bg-[#166651] text-white font-bold px-5 py-2.5 rounded-xl text-sm transition">
                    + Tambah Produk
                </a>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel Produk --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Produk</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Kategori</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Harga</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Stok</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($products as $product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/' . ($product->gambar ?? 'produk1.jpg')) }}"
                                            class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $product->nama_produk }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($product->deskripsi, 40) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $product->category->nama_kategori ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-[#1D8267]">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold {{ $product->stok <= 5 ? 'text-red-500' : 'text-gray-700' }}">
                                        {{ $product->stok }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-3">
                                        <a href="{{ route('penjual.products.edit', $product->id) }}"
                                            class="text-blue-500 hover:text-blue-700 font-bold text-xs transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('penjual.products.delete', $product->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 font-bold text-xs transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    Belum ada produk. 
                                    <a href="{{ route('penjual.products.create') }}" class="text-[#1D8267] font-bold">Tambah sekarang!</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($products->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>