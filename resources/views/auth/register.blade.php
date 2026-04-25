<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#F8FAFC] py-12 px-4 relative overflow-hidden font-sans">
        
        <div class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-gradient-to-br from-[#1D8267]/20 to-transparent rounded-full blur-[140px] animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-gradient-to-tl from-orange-100/40 to-transparent rounded-full blur-[140px]"></div>

        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 gap-0 bg-white/40 backdrop-blur-3xl rounded-[3.5rem] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.05)] border border-white/60 overflow-hidden relative z-10">
            
            <div class="hidden lg:flex lg:col-span-5 bg-[#1C2431] p-16 flex-col justify-between relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-[#1D8267] rounded-2xl flex items-center justify-center mb-10 shadow-lg shadow-[#1D8267]/20">
                        <span class="text-white font-black text-xl italic">P</span>
                    </div>
                    <h1 class="text-5xl font-black text-white leading-[1.1] tracking-tighter">
                        Pasar <br/> <span class="text-[#1D8267]">Digital.</span>
                    </h1>
                    <p class="text-gray-400 mt-6 font-medium leading-relaxed">
                        Ekosistem perdagangan paling modern untuk kebutuhan digital masa depan kamu.
                    </p>
                </div>

                <div class="relative z-10 bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-3">
                            <div class="w-10 h-10 rounded-full border-2 border-[#1C2431] bg-gray-600"></div>
                            <div class="w-10 h-10 rounded-full border-2 border-[#1C2431] bg-[#1D8267]"></div>
                            <div class="w-10 h-10 rounded-full border-2 border-[#1C2431] bg-orange-400"></div>
                        </div>
                        <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Bergabung dengan 3 Pengguna</p>
                    </div>
                </div>
            </div>

            <div class="col-span-1 lg:col-span-7 p-10 md:p-16 bg-white/80">
                <div class="mb-12">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">Halo Semua! 👋</h2>
                    <p class="text-gray-400 text-sm font-medium mt-1">Lengkapi form di bawah untuk memulai.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-1">Pilih Identitas</label>
                        <div class="grid grid-cols-3 gap-3 bg-gray-50/50 p-1.5 rounded-[2rem] border border-gray-100 shadow-inner">
                            @foreach(['user' => 'Pembeli', 'penjual' => 'Penjual', 'admin' => 'Admin'] as $val => $label)
                            <label class="cursor-pointer group">
                                <input type="radio" name="role" value="{{ $val }}" class="peer hidden" {{ $val == 'user' ? 'checked' : '' }}>
                                <div class="py-3.5 rounded-[1.6rem] text-center transition-all duration-500 peer-checked:bg-[#1C2431] peer-checked:text-white peer-checked:shadow-xl group-hover:bg-gray-100/50 peer-checked:group-hover:bg-[#1C2431]">
                                    <span class="text-[11px] font-black uppercase tracking-wider text-gray-400 peer-checked:text-white">{{ $label }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="group">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-1 block mb-2">Informasi Akun</label>
                            <input type="text" name="name" placeholder="Nama Lengkap" class="w-full bg-gray-50/50 border-gray-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-[#1D8267]/5 focus:border-[#1D8267] transition-all text-sm font-medium placeholder:text-gray-300" required>
                        </div>
                        
                        <input type="email" name="email" placeholder="Alamat Email" class="w-full bg-gray-50/50 border-gray-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-[#1D8267]/5 focus:border-[#1D8267] transition-all text-sm font-medium placeholder:text-gray-300" required>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="password" name="password" placeholder="Kata Sandi" class="w-full bg-gray-50/50 border-gray-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-[#1D8267]/5 focus:border-[#1D8267] transition-all text-sm font-medium placeholder:text-gray-300" required>
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi" class="w-full bg-gray-50/50 border-gray-100 rounded-2xl py-4 px-6 focus:bg-white focus:ring-4 focus:ring-[#1D8267]/5 focus:border-[#1D8267] transition-all text-sm font-medium placeholder:text-gray-300" required>
                        </div>
                    </div>

                    <div class="pt-6 space-y-6">
                        <button class="w-full bg-[#1C2431] text-white py-5 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.3em] transition-all duration-300 hover:bg-[#1D8267] hover:shadow-2xl hover:shadow-[#1D8267]/20 active:scale-95">
                            Inisialisasi Akun 🚀
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-[11px] font-bold text-gray-400 uppercase tracking-widest hover:text-[#1D8267] transition-colors group">
                                Sudah punya akun? <span class="text-[#1D8267] group-hover:underline underline-offset-4">Masuk Sekarang</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="absolute bottom-6 text-[9px] font-black text-gray-300 uppercase tracking-[0.4em]">
            PasarDigital <span class="mx-2 text-[#1D8267]/30">/</span> Kelompok 10 © 2026
        </div>
    </div>
</x-guest-layout>