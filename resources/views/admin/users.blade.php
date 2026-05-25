<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Kelola User</h1>
                    <p class="text-gray-500 mt-1">Daftar semua pengguna terdaftar</p>
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

            {{-- Tabel User --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Nama</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Email</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Role</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Bergabung</th>
                            <th class="text-left px-6 py-4 font-black text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-[#1C2431] rounded-full flex items-center justify-center text-white text-xs font-black">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-gray-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if ($user->role === 'admin') bg-red-100 text-red-700
                                        @elseif ($user->role === 'penjual') bg-blue-100 text-blue-700
                                        @else bg-green-100 text-green-700
                                        @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @if ($user->role !== 'admin')
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus user {{ $user->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 font-bold text-xs transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>