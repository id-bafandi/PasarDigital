<nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex-shrink-0 flex items-center gap-2">
                <div class="w-8 h-8 bg-[#1D8267] rounded-lg flex items-center justify-center text-white font-black italic">P</div>
                <span class="text-lg font-black text-gray-900 tracking-tighter">Pasar<span class="text-[#1D8267]">Digital</span></span>
            </div>

            <div class="hidden md:flex flex-1 max-w-md mx-8">
                <div class="relative w-full">
                    <input type="text" placeholder="Cari produk segar di sini..." 
                           class="w-full bg-gray-50 border-none rounded-2xl py-2.5 px-11 text-sm focus:ring-2 focus:ring-[#1D8267]/20 transition-all placeholder:text-gray-400">
                    <div class="absolute left-4 top-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6">
                @auth
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3 bg-gray-50 p-1.5 pr-4 rounded-full border border-gray-100 shadow-sm transition-all hover:shadow-md">
                            <div class="w-9 h-9 bg-[#1C2431] rounded-full flex items-center justify-center text-white text-xs font-black ring-2 ring-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-gray-900 leading-none mb-0.5">{{ Auth::user()->name }}</span>
                                <span class="text-[8px] font-bold text-[#1D8267] uppercase tracking-[0.1em]">{{ Auth::user()->role }}</span>
                            </div>
                            
                            <div class="h-6 w-px bg-gray-200 mx-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Keluar dari Akun">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-4 text-[11px] font-black uppercase tracking-[0.15em]">
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-[#1D8267] transition-all">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-[#1C2431] text-white px-6 py-2.5 rounded-xl hover:bg-[#1D8267] transition-all shadow-lg shadow-[#1C2431]/10">
                            Daftar
                        </a>
                    </div>
                @endauth

                <div class="relative group cursor-pointer">
                    <svg class="w-6 h-6 text-gray-900 group-hover:text-[#1D8267] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white">3</span>
                </div>
            </div>

        </div>
    </div>
</nav>