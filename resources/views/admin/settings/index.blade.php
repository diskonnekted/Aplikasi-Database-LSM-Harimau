<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Situs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @foreach($settings as $setting)
                            <div class="mb-6 border-b border-gray-200 pb-6 last:border-0">
                                <x-input-label :for="$setting->key" :value="$setting->label ?? ucfirst(str_replace('_', ' ', $setting->key))" />
                                
                                @if($setting->type === 'text')
                                    <x-text-input :id="$setting->key" class="block mt-1 w-full" type="text" :name="$setting->key" :value="old($setting->key, $setting->value)" />
                                @elseif($setting->type === 'textarea')
                                    <textarea :id="$setting->key" :name="$setting->key" class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm" rows="3">{{ old($setting->key, $setting->value) }}</textarea>
                                @elseif($setting->type === 'image')
                                    <div class="mt-2 flex items-center space-x-6">
                                        @if($setting->value)
                                            <div class="shrink-0">
                                                <img class="h-16 w-16 object-cover rounded-md" src="{{ asset('storage/' . $setting->value) }}" alt="Current {{ $setting->key }}">
                                            </div>
                                        @endif
                                        <label class="block">
                                            <span class="sr-only">Choose file</span>
                                            <input type="file" :name="$setting->key" class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-red-50 file:text-red-700
                                              hover:file:bg-red-100
                                            "/>
                                        </label>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Upload gambar baru untuk mengganti.</p>
                                @endif
                            </div>
                        @endforeach

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4 bg-red-600 hover:bg-red-700">
                                {{ __('Simpan Pengaturan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
