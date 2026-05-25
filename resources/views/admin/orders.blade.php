<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Kelola Pesanan</h1>
                    <p class="text-gray-500 mt-1">Semua pesanan dari pembeli</p>
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

            {{-- Tabel Pesanan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">No. Pesanan</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Pembeli</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Total</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Metode</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Status</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Tanggal</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">#{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 font-bold text-[#1D8267]">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="uppercase text-xs font-bold text-gray-500">
                                        {{ $order->metode_pembayaran ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if ($order->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif ($order->status === 'paid') bg-blue-100 text-blue-700
                                        @elseif ($order->status === 'shipped') bg-purple-100 text-purple-700
                                        @elseif ($order->status === 'completed') bg-green-100 text-green-700
                                        @elseif ($order->status === 'cancelled') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#1D8267]/20">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit"
                                            class="bg-[#1D8267] hover:bg-[#166651] text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-400">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>