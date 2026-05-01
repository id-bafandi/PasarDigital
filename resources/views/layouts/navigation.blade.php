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
        </div>
    </div>
</nav>