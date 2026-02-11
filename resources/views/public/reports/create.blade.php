<x-public-layout>
    <div class="bg-black pt-32 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-white mb-4">Form Pelaporan Masyarakat</h1>
                <p class="text-gray-400 text-lg">Sampaikan aspirasi, keluhan, atau laporan Anda kepada kami.</p>
            </div>

            @if (session('success'))
                <div class="mb-8 p-4 bg-green-900 border border-green-700 text-green-100 rounded-lg flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-gray-900 rounded-2xl shadow-2xl overflow-hidden border border-gray-800 mb-16">
                <form action="{{ route('public.reports.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6"
                    x-data="{
                        provinces: [],
                        cities: [],
                        districts: [],
                        villages: [],
                        province_id: '{{ old('province_id') }}',
                        city_id: '{{ old('city_id') }}',
                        district_id: '{{ old('district_id') }}',
                        village_id: '{{ old('village_id') }}',
                        init() {
                            fetch('{{ route('api.provinces') }}')
                                .then(response => response.json())
                                .then(data => this.provinces = data);
                                
                            if(this.province_id) this.fetchCities(this.province_id);
                            if(this.city_id) this.fetchDistricts(this.city_id);
                            if(this.district_id) this.fetchVillages(this.district_id);
                            
                            this.$watch('province_id', value => {
                                this.city_id = '';
                                this.district_id = '';
                                this.village_id = '';
                                this.cities = [];
                                this.districts = [];
                                this.villages = [];
                                if(value) this.fetchCities(value);
                            });
                            
                            this.$watch('city_id', value => {
                                this.district_id = '';
                                this.village_id = '';
                                this.districts = [];
                                this.villages = [];
                                if(value) this.fetchDistricts(value);
                            });
                            
                            this.$watch('district_id', value => {
                                this.village_id = '';
                                this.villages = [];
                                if(value) this.fetchVillages(value);
                            });
                        },
                        fetchCities(provinceId) {
                            fetch(`{{ url('api/cities') }}/${provinceId}`)
                                .then(response => response.json())
                                .then(data => this.cities = data);
                        },
                        fetchDistricts(cityId) {
                            fetch(`{{ url('api/districts') }}/${cityId}`)
                                .then(response => response.json())
                                .then(data => this.districts = data);
                        },
                        fetchVillages(districtId) {
                            fetch(`{{ url('api/villages') }}/${districtId}`)
                                .then(response => response.json())
                                .then(data => this.villages = data);
                        }
                    }">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Pelapor -->
                        <div>
                            <label for="reporter_name" class="block text-sm font-medium text-gray-300 mb-1">Nama Pelapor</label>
                            <input type="text" id="reporter_name" name="reporter_name" value="{{ old('reporter_name') }}" required
                                class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition">
                            @error('reporter_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- No WhatsApp -->
                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-300 mb-1">No WhatsApp / Telpon</label>
                            <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" required
                                class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition"
                                placeholder="Contoh: 08123456789">
                            @error('whatsapp') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Wilayah -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Province -->
                        <div>
                            <label for="province_id" class="block text-sm font-medium text-gray-300 mb-1">Provinsi</label>
                            <select id="province_id" name="province_id" class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition" x-model="province_id" required>
                                <option value="">Pilih Provinsi</option>
                                <template x-for="province in provinces" :key="province.id">
                                    <option :value="province.id" x-text="province.name"></option>
                                </template>
                            </select>
                            @error('province_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-300 mb-1">Kabupaten/Kota</label>
                            <select id="city_id" name="city_id" class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition" x-model="city_id" :disabled="!province_id" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                                <template x-for="city in cities" :key="city.id">
                                    <option :value="city.id" x-text="city.name"></option>
                                </template>
                            </select>
                            @error('city_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- District -->
                        <div>
                            <label for="district_id" class="block text-sm font-medium text-gray-300 mb-1">Kecamatan</label>
                            <select id="district_id" name="district_id" class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition" x-model="district_id" :disabled="!city_id" required>
                                <option value="">Pilih Kecamatan</option>
                                <template x-for="district in districts" :key="district.id">
                                    <option :value="district.id" x-text="district.name"></option>
                                </template>
                            </select>
                            @error('district_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Village -->
                        <div>
                            <label for="village_id" class="block text-sm font-medium text-gray-300 mb-1">Desa/Kelurahan</label>
                            <select id="village_id" name="village_id" class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition" x-model="village_id" :disabled="!district_id" required>
                                <option value="">Pilih Desa/Kelurahan</option>
                                <template x-for="village in villages" :key="village.id">
                                    <option :value="village.id" x-text="village.name"></option>
                                </template>
                            </select>
                            @error('village_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- RT -->
                        <div>
                            <label for="rt" class="block text-sm font-medium text-gray-300 mb-1">RT</label>
                            <select id="rt" name="rt" class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition" required>
                                <option value="">Pilih RT</option>
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}" {{ old('rt') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('rt') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- RW -->
                        <div>
                            <label for="rw" class="block text-sm font-medium text-gray-300 mb-1">RW</label>
                            <select id="rw" name="rw" class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition" required>
                                <option value="">Pilih RW</option>
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}" {{ old('rw') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('rw') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-300 mb-1">Alamat Lengkap (Jalan/Gang/No. Rumah)</label>
                        <textarea id="address" name="address" rows="2" required
                            class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition">{{ old('address') }}</textarea>
                        @error('address') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-1">Status Pelapor</label>
                        <select id="status" name="status" required
                            class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition">
                            <option value="">-- Pilih Status --</option>
                            <option value="anggota" {{ old('status') == 'anggota' ? 'selected' : '' }}>Anggota LSM Harimau</option>
                            <option value="masyarakat biasa" {{ old('status') == 'masyarakat biasa' ? 'selected' : '' }}>Masyarakat Biasa</option>
                            <option value="asn atau lembaga" {{ old('status') == 'asn atau lembaga' ? 'selected' : '' }}>ASN atau Lembaga</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Judul Laporan -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-300 mb-1">Judul Laporan</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition"
                            placeholder="Ringkasan singkat laporan Anda">
                        @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Isi Laporan -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-300 mb-1">Isi Laporan</label>
                        <textarea id="content" name="content" rows="6" required
                            class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition"
                            placeholder="Jelaskan secara detail laporan atau keluhan Anda..."></textarea>
                        @error('content') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Publikasi Laporan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Apakah Anda ingin laporan dipublikasikan?</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-3 cursor-pointer group relative">
                                <input type="radio" name="is_public" value="1" class="peer sr-only" {{ old('is_public') == '1' ? 'checked' : '' }} required>
                                <div class="w-6 h-6 border-2 border-gray-600 rounded-full peer-checked:bg-red-600 peer-checked:border-red-600 flex items-center justify-center transition-all bg-transparent shadow-sm peer-checked:[&>svg]:opacity-100">
                                    <svg class="w-4 h-4 text-white opacity-0 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-gray-400 group-hover:text-gray-200 peer-checked:text-red-500 peer-checked:font-bold transition font-medium">Ya, Publikasikan</span>
                            </label>
                            
                            <label class="flex items-center gap-3 cursor-pointer group relative">
                                <input type="radio" name="is_public" value="0" class="peer sr-only" {{ old('is_public') == '0' ? 'checked' : '' }} required>
                                <div class="w-6 h-6 border-2 border-gray-600 rounded-full peer-checked:bg-red-600 peer-checked:border-red-600 flex items-center justify-center transition-all bg-transparent shadow-sm peer-checked:[&>svg]:opacity-100">
                                    <svg class="w-4 h-4 text-white opacity-0 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-gray-400 group-hover:text-gray-200 peer-checked:text-red-500 peer-checked:font-bold transition font-medium">Tidak, Rahasiakan</span>
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Jika "Ya", laporan yang telah selesai akan ditampilkan di daftar laporan di bawah form ini (nama pelapor disamarkan).</p>
                        @error('is_public') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Unggah Bukti -->
                    <div>
                        <label for="evidence" class="block text-sm font-medium text-gray-300 mb-1">Unggah Bukti (Opsional)</label>
                        <input type="file" id="evidence" name="evidence"
                            class="w-full bg-black border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-red-600 focus:ring-1 focus:ring-red-600 transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-600 file:text-white hover:file:bg-red-700"
                            accept=".jpg,.jpeg,.png,.pdf">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, PDF (Maks. 5MB)</p>
                        @error('evidence') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Pernyataan Kebenaran -->
                    <div class="flex items-start gap-3 bg-black p-4 rounded-lg border border-gray-800">
                        <div class="flex items-center h-5">
                            <input id="is_truth_statement" name="is_truth_statement" type="checkbox" required
                                class="w-5 h-5 text-red-600 bg-gray-900 border-gray-700 rounded focus:ring-red-600 focus:ring-offset-gray-900">
                        </div>
                        <label for="is_truth_statement" class="text-sm text-gray-400 leading-relaxed">
                            Saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan. Saya bersedia diproses secara hukum apabila laporan ini merupakan fitnah atau berita bohong.
                        </label>
                    </div>
                    @error('is_truth_statement') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror

                    <!-- Tombol Kirim -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg transform transition hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            KIRIM LAPORAN SEKARANG
                        </button>
                    </div>
                </form>
            </div>

            <!-- Daftar Laporan Terkini -->
            <div class="mt-16 border-t border-gray-800 pt-16">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-extrabold text-white mb-4">Daftar Laporan Selesai</h2>
                    <p class="text-gray-400">Transparansi penyelesaian laporan yang telah ditindaklanjuti.</p>
                </div>
                
                @if(isset($latestReports) && $latestReports->count() > 0)
                    <div class="space-y-6">
                        @foreach($latestReports as $report)
                            <div class="bg-gray-900 rounded-2xl shadow-lg border border-gray-800 p-6 hover:border-red-900/50 transition-colors">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-white">{{ $report->title }}</h3>
                                        <div class="flex items-center gap-3 mt-2 text-sm text-gray-400">
                                            <span>{{ $report->created_at->translatedFormat('d F Y') }}</span>
                                            <span class="w-1.5 h-1.5 bg-gray-600 rounded-full"></span>
                                            <span>Oleh: {{ Str::mask($report->reporter_name, '*', 3) }}</span>
                                        </div>
                                    </div>
                                    <span class="inline-flex px-4 py-1.5 rounded-full text-sm font-semibold bg-green-900/50 text-green-400 border border-green-800">
                                        {{ $report->status_label }}
                                    </span>
                                </div>
                                
                                <div class="bg-black/50 rounded-xl p-4 border border-gray-800">
                                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Penyelesaian</h4>
                                    <p class="text-gray-300 text-sm leading-relaxed">
                                        {{ $report->resolution_notes ?? 'Laporan ini telah ditindaklanjuti dan diselesaikan oleh tim kami.' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-900/50 rounded-2xl border border-gray-800 border-dashed">
                        <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-gray-500">Belum ada laporan yang ditampilkan saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-public-layout>
