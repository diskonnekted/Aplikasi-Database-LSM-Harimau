<x-app-layout>
    <x-slot name="header">
        {{-- Header ditangani oleh navigation layout --}}
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-black text-gray-900">Tambah User Baru</h2>
                            <p class="text-sm text-gray-500 mt-1">Buat akun pengguna baru untuk sistem.</p>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="h-10 w-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-gray-100 flex items-center justify-center transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Nama Lengkap</label>
                            <input id="name" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-3 px-4" type="text" name="name" :value="old('name')" required autofocus placeholder="Masukkan nama lengkap user..." />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Email Address</label>
                            <input id="email" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-3 px-4" type="email" name="email" :value="old('email')" required placeholder="email@contoh.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Role / Hak Akses</label>
                                <select id="role" name="role" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-3 px-4" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

                            <!-- Region -->
                            <div>
                                <label for="region_id" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Wilayah (Opsional)</label>
                                <select id="region_id" name="region_id" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-3 px-4">
                                    <option value="">-- Pilih Wilayah --</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }} ({{ ucfirst($region->level) }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('region_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Password</label>
                                <input id="password" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-3 px-4"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Konfirmasi Password</label>
                                <input id="password_confirmation" class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-[#a4161a] focus:ring focus:ring-[#a4161a]/10 transition-all text-sm py-3 px-4"
                                                type="password"
                                                name="password_confirmation" required placeholder="Ulangi password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-50 flex items-center justify-end gap-3">
                            <a href="{{ route('admin.users.index') }}" class="h-[42px] px-6 flex items-center bg-white text-gray-500 border border-gray-200 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-50 transition-all">
                                Batal
                            </a>
                            <button type="submit" style="background-color: #a4161a !important;" class="h-[42px] px-6 flex items-center rounded-2xl text-[10px] font-black uppercase tracking-widest text-white hover:bg-[#ba181b] transition-all shadow-lg shadow-red-900/20">
                                Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>