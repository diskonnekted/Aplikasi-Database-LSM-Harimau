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
                        <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-wrap items-end gap-4">
                            <!-- Search -->
                            <div class="flex-1 min-w-[240px] space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Cari Berita</label>
                                <div class="relative group">
                                    <input type="text" name="search" placeholder="Cari Judul atau Konten..." value="{{ request('search') }}" 
                                        class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5 pl-4 pr-10">
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-[#a4161a] transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Wilayah -->
                            <div class="w-52 space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Wilayah</label>
                                <select name="region_id" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5">
                                    <option value="">Semua Wilayah</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="w-44 space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1">Status</label>
                                <select name="is_published" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-2.5">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('is_published') == '1' ? 'selected' : '' }}>✅ Published</option>
                                    <option value="0" {{ request('is_published') == '0' ? 'selected' : '' }}>📝 Draft</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2">
                                <button type="submit" style="background-color: #0b090a !important;" class="h-[42px] px-6 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-[#161a1d] transition-all shadow-lg shadow-gray-200">
                                    Filter
                                </button>
                                <a href="{{ route('admin.news.index') }}" class="h-[42px] px-6 flex items-center bg-white text-gray-500 border border-gray-200 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition-all">
                                    Reset
                                </a>
                                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                                <a href="{{ route('admin.news.create') }}" style="background-color: #a4161a !important;" class="h-[42px] px-6 flex items-center rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-[#ba181b] transition-all shadow-lg shadow-red-900/20">
                                    + Tambah Berita
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
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">Berita</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">Wilayah</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100 text-center">Status</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100">Tanggal</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-100 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($news as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    @if($item->image_path)
                                                        <img class="h-12 w-20 rounded-xl object-cover shadow-sm" src="{{ Storage::url($item->image_path) }}" alt="">
                                                    @else
                                                        <div class="h-12 w-20 rounded-xl bg-gray-100 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900 group-hover:text-[#a4161a] transition-colors line-clamp-1">{{ $item->title }}</div>
                                                        <div class="text-[10px] font-medium text-gray-400 mt-1 uppercase tracking-tight">{{ Str::limit(strip_tags($item->content), 60) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-bold text-gray-800">{{ $item->region->name }}</div>
                                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter">{{ ucfirst($item->region->level) }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                @if($item->is_published)
                                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-green-50 text-green-600 border border-green-100">Published</span>
                                                @else
                                                    <span class="inline-flex px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-gray-50 text-gray-500 border border-gray-100">Draft</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-500">
                                                {{ $item->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-end gap-1">
                                                    <a href="{{ route('admin.news.edit', $item) }}" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-xl transition-all" title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                    </a>
                                                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus berita ini?');">
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
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center gap-2">
                                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                                                    <p class="text-sm font-bold text-gray-400">Belum ada berita yang diterbitkan.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-8 px-2">
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>