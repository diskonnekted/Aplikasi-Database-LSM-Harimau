<x-app-layout>
    <x-slot name="header">
        {{-- Header ditangani oleh navigation layout --}}
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Tambah Halaman Baru</h2>
                    </div>

                    <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Judul Halaman')" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1 mb-2" />
                            <x-text-input id="title" class="block w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-3 px-4" type="text" name="title" :value="old('title')" required autofocus placeholder="Masukkan judul halaman..." />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div>
                            <x-input-label for="content" :value="__('Konten')" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-1 mb-2" />
                            <textarea id="content" name="content" rows="12" class="block w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-3 px-4" required placeholder="Tulis konten halaman di sini...">{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <!-- Published -->
                        <div class="block">
                            <label for="is_published" class="inline-flex items-center group cursor-pointer">
                                <input id="is_published" type="checkbox" class="rounded border-gray-300 text-[#a4161a] shadow-sm focus:ring-[#a4161a] transition-colors" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm font-medium text-gray-600 group-hover:text-[#a4161a] transition-colors">{{ __('Publikasikan Halaman') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.pages.index') }}" class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-gray-700 transition-colors">
                                Batal
                            </a>
                            <button type="submit" style="background-color: #a4161a !important;" class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-[#ba181b] transition-all shadow-lg shadow-red-900/20">
                                {{ __('Simpan Halaman') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
