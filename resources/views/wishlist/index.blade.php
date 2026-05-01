<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[2rem] p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Produk Favorit Saya</h3>

                @if(session('wishlist') && count(session('wishlist')) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(session('wishlist') as $id => $data)
                            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-[2rem] bg-gray-50 shadow-sm">
                                <div class="flex items-center gap-4">
                                    {{-- Pelindung agar tidak error "offset of type string" --}}
                                    @if(is_array($data))
                                        <img src="{{ asset('images/' . ($data['image'] ?? 'default.jpg')) }}" class="w-16 h-16 object-cover rounded-2xl">
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $data['name'] ?? 'Produk' }}</h4>
                                            <p class="text-xs text-[#1D8267] font-bold uppercase tracking-widest">Favorit Saya</p>
                                        </div>
                                    @else
                                        {{-- Jika data session lama/rusak, tampilkan minimalis --}}
                                        <div class="w-16 h-16 bg-gray-200 rounded-2xl flex items-center justify-center text-gray-400">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <h4 class="font-bold text-gray-800">{{ $data }}</h4>
                                    @endif
                                </div>
                                
                                {{-- SOLUSI ERROR: Pastikan mengirim $id ke rute --}}
                                <form action="{{ route('wishlist.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-full transition">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-gray-50 rounded-[2rem] border border-dashed border-gray-200">
                        <p class="text-gray-500">Belum ada produk favorit.</p>
                        <a href="{{ route('home') }}" class="text-[#1D8267] font-bold mt-4 inline-block hover:underline">Kembali Belanja</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>