<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F8FAFC] py-12 px-4 relative overflow-hidden font-sans">
        
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-gradient-to-tr from-[#1D8267]/15 to-transparent rounded-full blur-[140px] animate-pulse"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-gradient-to-bl from-orange-100/30 to-transparent rounded-full blur-[140px]"></div>

        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 bg-white/40 backdrop-blur-3xl rounded-[3.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] border border-white/60 overflow-hidden relative z-10">
            
            <div class="hidden lg:flex lg:col-span-5 bg-[#1C2431] p-16 flex-col justify-between relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-[#1D8267] rounded-2xl flex items-center justify-center mb-10 shadow-lg shadow-[#1D8267]/20">
                        <span class="text-white font-black text-xl italic">P</span>
                    </div>
                    <h1 class="text-5xl font-black text-white leading-[1.1] tracking-tighter">
                        Selamat <br/> <span class="text-[#1D8267]">Datang.</span>
                    </h1>
                    <p class="text-gray-400 mt-6 font-medium leading-relaxed">
                        Masuk kembali ke akun Anda dan lanjutkan petualangan digital Anda.
                    </p>
                </div>

                <div class="relative z-10 bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl p-6">
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em] mb-2 text-center">Keamanan Terjamin</p>
                    <div class="flex justify-center gap-4 text-gray-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/></svg>
                        <span class="text-[9px] font-bold uppercase tracking-widest self-center">End-to-End Encryption</span>
                    </div>
                </div>
            </div>

            <div class="col-span-1 lg:col-span-7 p-10 md:p-16 bg-white/80">
                <div class="mb-12">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight italic">Masuk Akun</h2>
                    <p class="text-gray-400 text-sm font-medium mt-1">Masukkan kredensial Anda untuk melanjutkan.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-5">
                        <div class="group">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1 block mb-2">Identitas Digital</label>
                            <input id="email" type="email" name="email" :value="old('email')" placeholder="Alamat Email" class="w-full bg-gray-50/50 border-gray-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-[#1D8267]/5 focus:border-[#1D8267] transition-all text-sm font-medium placeholder:text-gray-300" required autofocus autocomplete="username">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        
                        <div class="group">
                            <div class="flex justify-between items-center mb-2 px-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-[9px] font-bold text-[#1D8267] uppercase tracking-wider hover:underline">Lupa Sandi?</a>
                                @endif
                            </div>
                            <input id="password" type="password" name="password" placeholder="••••••••" class="w-full bg-gray-50/50 border-gray-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-[#1D8267]/5 focus:border-[#1D8267] transition-all text-sm font-medium placeholder:text-gray-300" required autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center ml-1">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-gray-200 text-[#1D8267] focus:ring-[#1D8267]/20 shadow-sm transition-all">
                            <span class="ml-2 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Ingat Perangkat Ini</span>
                        </div>
                    </div>

                    <div class="pt-6 space-y-6">
                        <button class="w-full bg-[#1C2431] text-white py-5 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.3em] transition-all duration-300 hover:bg-[#1D8267] hover:shadow-2xl hover:shadow-[#1D8267]/20 active:scale-95">
                            Otorisasi Akses 🔑
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('register') }}" class="text-[11px] font-bold text-gray-400 uppercase tracking-widest hover:text-[#1D8267] transition-colors group">
                                Baru di sini? <span class="text-[#1D8267] group-hover:underline underline-offset-4">Daftar Akun</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="absolute bottom-6 text-[9px] font-black text-gray-300 uppercase tracking-[0.4em]">
            PasarDigital <span class="mx-2 text-[#1D8267]/30">/</span> Secure Auth v.2.6
        </div>
    </div>
</x-guest-layout>