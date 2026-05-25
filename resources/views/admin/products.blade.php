<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Kelola Produk</h1>
                    <p class="text-gray-500 mt-1">Semua produk yang terdaftar</p>
                </div>
                <a href="{{ route('admin.dashboard') }}"
                    class="border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold px-4 py-2 rounded-xl text-sm transition">
                    ← Dashboard
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
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Penjual</th>
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
                                        <span class="font-bold text-gray-900">{{ $product->nama_produk }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $product->category->nama_kategori ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $product->seller->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-bold text-[#1D8267]">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold {{ $product->stok <= 5 ? 'text-red-500' : 'text-gray-700' }}">
                                        {{ $product->stok }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus produk {{ $product->nama_produk }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-red-700 font-bold text-xs transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($products->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>