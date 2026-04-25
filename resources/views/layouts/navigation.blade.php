<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="container mx-auto px-4 h-20 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <span class="text-2xl font-black tracking-tighter">Pasar<span class="text-[#1D8267]">Digital</span></span>
        </a>

        <div class="hidden md:flex flex-1 max-w-lg mx-10">
            <div class="relative w-full">
                <input type="text" placeholder="Cari produk segar di sini..." class="w-full bg-gray-50 border-none rounded-2xl px-6 py-3 focus:ring-2 focus:ring-[#1D8267] transition-all">
                <button class="absolute right-4 top-3 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </button>
            </div>
        </div>

        <div class="flex items-center gap-6">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-700 hover:text-[#1D8267]">Dashboard</a>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-800 hover:text-[#1D8267]">Masuk</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('register') }}" class="text-sm font-bold text-gray-800 hover:text-[#1D8267]">Daftar</a>
                    </div>
                @endauth
            @endif
            
            <div class="relative group cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-gray-800 group-hover:text-[#1D8267]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">3</span>
            </div>
        </div>
    </div>
</nav>