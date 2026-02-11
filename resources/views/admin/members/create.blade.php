<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Anggota Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data" 
                        x-data="{ 
                            createUser: {{ old('create_user') ? 'true' : 'false' }},
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
                            
                            <!-- Toggle User Account -->
                            <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="create_user" value="1" class="sr-only peer" x-model="createUser">
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-900">Buat Akun User untuk Login?</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1 ml-14">Jika diaktifkan, anggota dapat login ke sistem menggunakan email dan password di bawah ini.</p>
                            </div>

                            <!-- Akun User -->
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 p-4 border border-gray-200 rounded-lg bg-blue-50/50" x-show="createUser" x-transition>
                                <div class="md:col-span-2">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2 border-b pb-2">Informasi Akun Login</h3>
                                </div>

                                <!-- Username -->
                                <div>
                                    <x-input-label for="name" :value="__('Username')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" ::required="createUser" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" ::required="createUser" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" ::required="createUser" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" ::required="createUser" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Data Anggota -->
                            <div class="md:col-span-2 mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Data Pribadi Anggota</h3>
                            </div>

                            <!-- NIK -->
                            <div>
                                <x-input-label for="nik" :value="__('NIK (Nomor Induk Kependudukan)')" />
                                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required maxlength="16" />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            <!-- Full Name -->
                            <div>
                                <x-input-label for="full_name" :value="__('Nama Lengkap')" />
                                <x-text-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <!-- Gender -->
                            <div>
                                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone_number" :value="__('Nomor Telepon/WA')" />
                                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <!-- Birth Place -->
                            <div>
                                <x-input-label for="birth_place" :value="__('Tempat Lahir')" />
                                <x-text-input id="birth_place" class="block mt-1 w-full" type="text" name="birth_place" :value="old('birth_place')" required />
                                <x-input-error :messages="$errors->get('birth_place')" class="mt-2" />
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                                <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required />
                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <!-- Job/Position -->
                            <div>
                                <x-input-label for="position" :value="__('Jabatan')" />
                                <x-text-input id="position" class="block mt-1 w-full" type="text" name="position" :value="old('position')" required />
                                <x-input-error :messages="$errors->get('position')" class="mt-2" />
                            </div>

                            <!-- Region -->
                            <div>
                                <x-input-label for="region_id" :value="__('Wilayah Kepengurusan')" />
                                <select id="region_id" name="region_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Wilayah</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }} ({{ ucfirst($region->level) }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('region_id')" class="mt-2" />
                            </div>

                            <!-- Alamat Domisili -->
                            <div class="md:col-span-2 mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Alamat Domisili</h3>
                            </div>

                            <!-- Province -->
                            <div>
                                <x-input-label for="province_id" :value="__('Provinsi')" />
                                <select id="province_id" name="province_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="province_id">
                                    <option value="">Pilih Provinsi</option>
                                    <template x-for="province in provinces" :key="province.id">
                                        <option :value="province.id" x-text="province.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('province_id')" class="mt-2" />
                            </div>

                            <!-- City -->
                            <div>
                                <x-input-label for="city_id" :value="__('Kabupaten/Kota')" />
                                <select id="city_id" name="city_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="city_id" :disabled="!province_id">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.id" x-text="city.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                            </div>

                            <!-- District -->
                            <div>
                                <x-input-label for="district_id" :value="__('Kecamatan')" />
                                <select id="district_id" name="district_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="district_id" :disabled="!city_id">
                                    <option value="">Pilih Kecamatan</option>
                                    <template x-for="district in districts" :key="district.id">
                                        <option :value="district.id" x-text="district.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('district_id')" class="mt-2" />
                            </div>

                            <!-- Village -->
                            <div>
                                <x-input-label for="village_id" :value="__('Desa/Kelurahan')" />
                                <select id="village_id" name="village_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="village_id" :disabled="!district_id">
                                    <option value="">Pilih Desa/Kelurahan</option>
                                    <template x-for="village in villages" :key="village.id">
                                        <option :value="village.id" x-text="village.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('village_id')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Jalan / RT / RW / Nomor Rumah')" />
                                <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <!-- Image -->
                            <div class="md:col-span-1">
                                <x-input-label for="image" :value="__('Foto Profil')" />
                                <input id="image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="image" accept="image/*">
                                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <!-- KTP Image -->
                            <div class="md:col-span-1">
                                <x-input-label for="ktp_image" :value="__('Foto KTP')" />
                                <input id="ktp_image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="ktp_image" accept="image/*">
                                <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                                <x-input-error :messages="$errors->get('ktp_image')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.members.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Anggota') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
