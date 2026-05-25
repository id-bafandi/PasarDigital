<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Konfirmasi Pembayaran</h1>
                    <p class="text-gray-500 mt-1">Daftar pembayaran yang perlu dikonfirmasi</p>
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
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Tabel Pembayaran --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">No. Pesanan</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Pembeli</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Total</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Metode</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Bukti</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Status</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    #{{ $payment->order->order_number }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $payment->order->user->name }}
                                </td>
                                <td class="px-6 py-4 font-bold text-[#1D8267]">
                                    Rp {{ number_format($payment->order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="uppercase text-xs font-bold text-gray-500">
                                        {{ $payment->order->metode_pembayaran ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($payment->bukti_pembayaran)
                                        <a href="{{ Storage::url($payment->bukti_pembayaran) }}"
                                            target="_blank"
                                            class="text-[#1D8267] hover:underline font-bold text-xs">
                                            Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-gray-300 text-xs">Belum upload</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if ($payment->status_pembayaran === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif ($payment->status_pembayaran === 'waiting_confirmation') bg-blue-100 text-blue-700
                                        @elseif ($payment->status_pembayaran === 'paid') bg-green-100 text-green-700
                                        @elseif ($payment->status_pembayaran === 'cancelled') bg-red-100 text-red-700
                                        @endif">
                                        {{ str_replace('_', ' ', $payment->status_pembayaran) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($payment->status_pembayaran === 'waiting_confirmation')
                                        <div class="flex gap-2">
                                            <form action="{{ route('admin.payments.confirm', $payment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-[#1D8267] hover:bg-[#166651] text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin tolak pembayaran ini?')">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-400">Belum ada pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($payments->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>