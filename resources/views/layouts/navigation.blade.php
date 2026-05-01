<<<<<<< HEAD
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 no-underline">
                        <span class="font-bold text-2xl text-gray-800 tracking-tight">
                            Pasar<span class="text-[#1D8267]">Digital</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Beranda') }}
                    </x-nav-link>

                    @auth
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-red-600 font-bold">
                                {{ __('Panel Admin') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                
                @auth
                    @if(Auth::user()->role === 'penjual')
                        <a href="{{ route('produk.tambah') }}" class="bg-[#1D8267] hover:bg-[#166651] text-white px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 mr-2 no-underline">
                            <i class="fas fa-plus"></i> Jual Produk
                        </a>
                    @elseif(Auth::user()->role === 'user')
                        <a href="{{ route('wishlist.index') }}" class="relative text-gray-500 hover:text-red-500 p-2 transition no-underline">
                            <i class="fas fa-heart text-lg"></i>
                            
                            @if(session('wishlist_notif') && session('wishlist_notif') > 0)
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">
                                    {{ session('wishlist_notif') }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-[#1D8267] relative p-2 transition mr-2 no-underline" title="Keranjang Belanja">
                            <i class="fas fa-shopping-cart text-lg"></i>
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-[10px] rounded-full px-1.5 font-bold shadow-sm">0</span>
                        </a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 gap-2">
                                <div class="text-right hidden md:block">
                                    <div class="font-bold text-gray-900 leading-none">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] uppercase tracking-widest text-[#1D8267] font-semibold">{{ Auth::user()->role }}</div>
                                </div>
                                <div class="bg-gray-200 h-9 w-9 rounded-full flex items-center justify-center text-gray-500 border border-gray-100">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('dashboard')">
                                    {{ __('Dashboard Admin') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-[#1D8267] no-underline">Masuk</a>
                        <a href="{{ route('register') }}" class="text-sm font-bold bg-[#1D8267] text-white px-5 py-2.5 rounded-xl shadow-sm hover:bg-[#166651] transition no-underline">Daftar</a>
                    </div>
                @endguest

            </div>
=======
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

>>>>>>> main
        </div>
    </div>
</nav>