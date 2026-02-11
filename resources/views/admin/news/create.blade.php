<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Berita')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Region -->
                        <div class="mb-4">
                            <x-input-label for="region_id" :value="__('Wilayah')" />
                            <select id="region_id" name="region_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }} ({{ ucfirst($region->level) }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('region_id')" class="mt-2" />
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <x-input-label for="content" :value="__('Isi Berita')" />
                            <textarea id="content" name="content" rows="10" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <!-- Image -->
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Gambar Utama')" />
                            <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="image/*">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <!-- Source -->
                        <div class="mb-4">
                            <x-input-label for="source" :value="__('Sumber Berita (Opsional)')" />
                            <x-text-input id="source" class="block mt-1 w-full" type="text" name="source" :value="old('source')" placeholder="Contoh: Detik.com, Kompas" />
                            <x-input-error :messages="$errors->get('source')" class="mt-2" />
                        </div>

                        <!-- Video URL -->
                        <div class="mb-4">
                            <x-input-label for="video_url" :value="__('Video URL (Youtube/Vimeo/etc)')" />
                            <x-text-input id="video_url" class="block mt-1 w-full" type="url" name="video_url" :value="old('video_url')" placeholder="https://youtube.com/watch?v=..." />
                            <x-input-error :messages="$errors->get('video_url')" class="mt-2" />
                        </div>

                        <!-- Social Links -->
                        <div class="mb-4 p-4 border rounded-lg bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Link Media Sosial</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="social_links_youtube" :value="__('Youtube Channel URL')" />
                                    <x-text-input id="social_links_youtube" class="block mt-1 w-full" type="url" name="social_links[youtube]" :value="old('social_links.youtube')" placeholder="https://youtube.com/@..." />
                                </div>
                                <div>
                                    <x-input-label for="social_links_tiktok" :value="__('TikTok URL')" />
                                    <x-text-input id="social_links_tiktok" class="block mt-1 w-full" type="url" name="social_links[tiktok]" :value="old('social_links.tiktok')" placeholder="https://tiktok.com/@..." />
                                </div>
                                <div>
                                    <x-input-label for="social_links_instagram" :value="__('Instagram URL')" />
                                    <x-text-input id="social_links_instagram" class="block mt-1 w-full" type="url" name="social_links[instagram]" :value="old('social_links.instagram')" placeholder="https://instagram.com/..." />
                                </div>
                                <div>
                                    <x-input-label for="social_links_facebook" :value="__('Facebook URL')" />
                                    <x-text-input id="social_links_facebook" class="block mt-1 w-full" type="url" name="social_links[facebook]" :value="old('social_links.facebook')" placeholder="https://facebook.com/..." />
                                </div>
                                <div>
                                    <x-input-label for="social_links_twitter" :value="__('Twitter/X URL')" />
                                    <x-text-input id="social_links_twitter" class="block mt-1 w-full" type="url" name="social_links[twitter]" :value="old('social_links.twitter')" placeholder="https://twitter.com/..." />
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="block mt-4 mb-6">
                            <label for="is_published" class="inline-flex items-center">
                                <input id="is_published" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600">{{ __('Publikasikan Segera') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.news.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Berita') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
