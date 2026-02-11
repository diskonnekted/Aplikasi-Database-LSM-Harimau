<x-public-layout>
    <div class="bg-gray-100 py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-extrabold text-gray-900">Registrasi Anggota Baru</h2>
                        <p class="mt-2 text-sm text-gray-600">LSM Harapan Rakyat Indonesia Maju (HARIMAU)</p>
                    </div>

                    <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
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
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700">Nama Lengkap (Sesuai KTP)</label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                @error('full_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- NIK -->
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK (KTP)</label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                @error('nik') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon/WA</label>
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                @error('phone_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            </div>

                            <!-- Birth Place -->
                            <div>
                                <label for="birth_place" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            </div>

                            <!-- Religion -->
                            <div>
                                <label for="religion" class="block text-sm font-medium text-gray-700">Agama</label>
                                <select name="religion" id="religion" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>

                            <!-- Wilayah (Detailed) -->
                            <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Province -->
                                <div>
                                    <label for="province_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
                                    <select id="province_id" name="province_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" x-model="province_id" required>
                                        <option value="">Pilih Provinsi</option>
                                        <template x-for="province in provinces" :key="province.id">
                                            <option :value="province.id" x-text="province.name"></option>
                                        </template>
                                    </select>
                                    @error('province_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- City -->
                                <div>
                                    <label for="city_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                                    <select id="city_id" name="city_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" x-model="city_id" :disabled="!province_id" required>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        <template x-for="city in cities" :key="city.id">
                                            <option :value="city.id" x-text="city.name"></option>
                                        </template>
                                    </select>
                                    @error('city_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- District -->
                                <div>
                                    <label for="district_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                    <select id="district_id" name="district_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" x-model="district_id" :disabled="!city_id" required>
                                        <option value="">Pilih Kecamatan</option>
                                        <template x-for="district in districts" :key="district.id">
                                            <option :value="district.id" x-text="district.name"></option>
                                        </template>
                                    </select>
                                    @error('district_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <!-- Village -->
                                <div>
                                    <label for="village_id" class="block text-sm font-medium text-gray-700">Desa/Kelurahan</label>
                                    <select id="village_id" name="village_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" x-model="village_id" :disabled="!district_id" required>
                                        <option value="">Pilih Desa/Kelurahan</option>
                                        <template x-for="village in villages" :key="village.id">
                                            <option :value="village.id" x-text="village.name"></option>
                                        </template>
                                    </select>
                                    @error('village_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea name="address" id="address" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ old('address') }}</textarea>
                        </div>

                        <!-- Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Foto Profil (Background Merah/Biru)</label>
                            <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                            @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-sm text-gray-900">
                                Saya menyetujui <a href="{{ route('public.rules') }}" target="_blank" class="text-red-600 hover:text-red-500">tata tertib dan aturan</a> lembaga.
                            </label>
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                Daftar Sebagai Anggota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
