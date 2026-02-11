<x-app-layout>
    <x-slot name="header">
        {{-- Header ditangani oleh navigation layout --}}
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <!-- Modern Filters -->
                    <div class="mb-8 bg-gray-50/50 p-6 rounded-3xl border border-gray-100 shadow-sm">
                        <form method="GET" action="{{ route('admin.members.index') }}" class="flex flex-wrap items-end gap-4">
                            <!-- Search -->
                            <div class="flex-1 min-w-[240px] space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Pencarian Cepat</label>
                                <div class="relative group">
                                    <input type="text" name="search" placeholder="Cari Nama, NIK, atau KTA..." value="{{ request('search') }}" 
                                        class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5 pl-4 pr-10">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#a4161a] transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Jabatan -->
                            <div class="w-44 space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Jabatan</label>
                                <select name="position_type" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5">
                                    <option value="">Semua Jabatan</option>
                                    <option value="member" {{ request('position_type') == 'member' ? 'selected' : '' }}>Anggota Biasa</option>
                                    <option value="pengurus" {{ request('position_type') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                </select>
                            </div>

                            <!-- Wilayah -->
                            <div class="w-52 space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Wilayah Kerja</label>
                                <select name="region_id" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5">
                                    <option value="">Semua Wilayah</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }} ({{ ucfirst($region->level) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="w-44 space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Status Keanggotaan</label>
                                <select name="status" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Aktif</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2">
                                <button type="submit" style="background-color: #0b090a !important;" class="h-[42px] px-6 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-[#161a1d] transition-all shadow-lg shadow-gray-200">
                                    Filter
                                </button>
                                <a href="{{ route('admin.members.index') }}" class="h-[42px] px-6 flex items-center bg-white text-gray-500 border border-gray-200 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition-all">
                                    Reset
                                </a>
                                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                                <a href="{{ route('admin.members.create') }}" style="background-color: #a4161a !important;" class="h-[42px] px-6 flex items-center rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-[#ba181b] transition-all shadow-lg shadow-red-900/20">
                                    + Tambah
                                </a>
                                <a href="{{ route('admin.members.export') }}" style="background-color: #16a34a !important;" class="h-[42px] px-6 flex items-center rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-green-700 transition-all shadow-lg shadow-green-900/20">
                                    Export
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
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">Anggota</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">Jabatan</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">Wilayah Kerja</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">No. WhatsApp</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100 text-center">Status</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">No. KTA</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($members as $member)
                                        <tr class="hover:bg-gray-50/50 transition-colors group">
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="relative flex-shrink-0">
                                                        @if($member->image_path)
                                                            <img class="h-10 w-10 rounded-full object-cover shadow-sm ring-2 ring-white" src="{{ Storage::url($member->image_path) }}" alt="">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center font-black text-gray-400 shadow-inner">
                                                                {{ substr($member->full_name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full border-2 border-white {{ $member->status == 'approved' ? 'bg-green-500' : ($member->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}"></div>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 group-hover:text-[#a4161a] transition-colors">{{ $member->full_name }}</div>
                                                        <div class="text-[10px] font-medium text-gray-400 mt-0.5 tracking-tight">NIK: {{ $member->nik }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wider">
                                                    {{ $member->position ?? 'Anggota' }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="text-sm font-bold text-gray-800">{{ $member->region->name }}</div>
                                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter">{{ ucfirst($member->region->level) }}</div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-2">
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone_number) }}" target="_blank" class="text-sm font-bold text-gray-700 hover:text-green-600 transition-colors flex items-center gap-1.5">
                                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                        {{ $member->phone_number }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                @if($member->status == 'approved')
                                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-green-50 text-green-600 border border-green-100">Aktif</span>
                                                @elseif($member->status == 'pending')
                                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-yellow-50 text-yellow-600 border border-yellow-100">Pending</span>
                                                @else
                                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-red-50 text-red-600 border border-red-100">Ditolak</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4">
                                                <code class="text-[11px] font-black text-gray-500 bg-gray-50 px-2 py-1 rounded-md border border-gray-100">
                                                    {{ $member->kta_number ?? 'BELUM ADA' }}
                                                </code>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center justify-end gap-1 transition-all">
                                                    @if($member->status == 'approved')
                                                        <a href="{{ route('admin.members.kta', $member) }}" target="_blank" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition-all" title="Cetak KTA">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('admin.members.show', $member) }}" class="p-2 text-green-500 hover:bg-green-50 rounded-xl transition-all" title="Detil">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                    </a>

                                                    <a href="{{ route('admin.members.edit', $member) }}" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-xl transition-all" title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    </a>

                                                    @if($member->status == 'pending')
                                                        <form action="{{ route('admin.members.status', $member) }}" method="POST" class="inline">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-xl transition-all" title="Setujui">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Hapus anggota ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Hapus">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-12 text-center">
                                                <div class="flex flex-col items-center gap-2">
                                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                                    <p class="text-sm font-bold text-gray-400">Tidak ada data anggota ditemukan.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-8 px-2">
                        {{ $members->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
