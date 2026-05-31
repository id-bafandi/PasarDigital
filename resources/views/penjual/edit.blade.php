<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-2xl mx-auto px-4">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Edit Produk</h1>
                    <p class="text-gray-500 mt-1">Update detail produk</p>
                </div>
                <a href="{{ route('penjual.products') }}"
                    class="border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold px-4 py-2 rounded-xl text-sm transition">
                    ← Kembali
                </a>
            </div>

            <form action="{{ route('penjual.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-5">

                    {{-- Nama Produk --}}
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20 @error('nama_produk') border-red-400 @enderror">
                        @error('nama_produk')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Harga & Stok --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-bold text-gray-700 mb-1 block">Harga <span class="text-red-500">*</span></label>
                            <input type="number" name="harga" value="{{ old('harga', $product->harga) }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                        </div>
                        <div>
                            <label class="text-sm font-bold text-gray-700 mb-1 block">Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok', $product->stok) }}"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                        </div>
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Gambar Produk</label>
                        @if ($product->gambar)
                            <img src="{{ asset('images/' . $product->gambar) }}"
                                class="w-20 h-20 rounded-xl object-cover mb-2">
                        @endif
                        <input type="file" name="gambar" accept="image/*"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar</p>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#1D8267] hover:bg-[#166651] text-white font-bold py-3.5 rounded-2xl transition">
                        Update Produk
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>