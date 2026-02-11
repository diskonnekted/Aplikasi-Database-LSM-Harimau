<x-app-layout>
    <x-slot name="header">
        {{-- Header ditangani oleh navigation layout --}}
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    @if (session('success'))
                        <div class="mb-8 bg-green-50 border border-green-100 text-green-600 px-6 py-4 rounded-3xl flex items-center gap-4 shadow-sm">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium text-sm">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-8 bg-red-50 border border-red-100 text-red-600 px-6 py-4 rounded-3xl flex items-center gap-4 shadow-sm">
                            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium text-sm">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Modern Filters -->
                    <div class="mb-8 bg-gray-50/50 p-6 rounded-3xl border border-gray-100 shadow-sm">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-4">
                            <!-- Search -->
                            <div class="flex-1 min-w-[240px] space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Cari User</label>
                                <div class="relative group">
                                    <input type="text" name="search" placeholder="Cari Nama atau Email..." value="{{ request('search') }}" 
                                        class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5 pl-4 pr-10">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#a4161a] transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="w-44 space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Role / Hak Akses</label>
                                <select name="role" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5">
                                    <option value="">Semua Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Wilayah -->
                            <div class="w-52 space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Wilayah</label>
                                <select name="region_id" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5">
                                    <option value="">Semua Wilayah</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }} ({{ ucfirst($region->level) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2">
                                <button type="submit" style="background-color: #0b090a !important;" class="h-[42px] px-6 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-[#161a1d] transition-all shadow-lg shadow-gray-200">
                                    Filter
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="h-[42px] px-6 flex items-center bg-white text-gray-500 border border-gray-200 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition-all">
                                    Reset
                                </a>
                                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                                <a href="{{ route('admin.users.create') }}" style="background-color: #a4161a !important;" class="h-[42px] px-6 flex items-center rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-[#ba181b] transition-all shadow-lg shadow-red-900/20">
                                    + Tambah User
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Table Container -->
                    <div class="relative bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto custom-scrollbar">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/80">
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">User</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">Role</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">Wilayah</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($users as $user)
                                        <tr class="hover:bg-gray-50/50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden ring-2 ring-white shadow-sm">
                                                        @if($user->avatar_url)
                                                            <img class="h-full w-full object-cover" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                                                        @else
                                                            <span class="text-xl font-bold text-gray-400">{{ substr($user->name, 0, 1) }}</span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 group-hover:text-[#a4161a] transition-colors">{{ $user->name }}</div>
                                                        <div class="text-[10px] font-medium text-gray-400 mt-1 tracking-tight">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($user->roles as $role)
                                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                                            {{ $role->name == 'super-admin' ? 'bg-red-50 text-red-600 border border-red-100' : 
                                                               ($role->name == 'pimpinan' ? 'bg-purple-50 text-purple-600 border border-purple-100' : 
                                                               'bg-gray-50 text-gray-600 border border-gray-100') }}">
                                                            {{ $role->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($user->region)
                                                    <div class="text-sm font-bold text-gray-800">{{ $user->region->name }}</div>
                                                    <div class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter">{{ ucfirst($user->region->level) }}</div>
                                                @else
                                                    <span class="text-gray-400 text-sm">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="h-8 w-8 rounded-xl bg-gray-50 text-gray-400 hover:bg-[#a4161a] hover:text-white flex items-center justify-center transition-all shadow-sm border border-gray-100 group/edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    @if($user->id !== auth()->id())
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="h-8 w-8 rounded-xl bg-red-50 text-red-400 hover:bg-red-600 hover:text-white flex items-center justify-center transition-all shadow-sm border border-red-100">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                    <span class="text-sm font-medium">Tidak ada user ditemukan</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($users->hasPages())
                            <div class="bg-gray-50/50 border-t border-gray-100 px-6 py-4">
                                {{ $users->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>