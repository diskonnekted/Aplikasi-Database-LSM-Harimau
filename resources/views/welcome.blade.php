@php
    $latestNews = \App\Models\News::where('is_published', true)->latest()->take(3)->get();
@endphp
<x-public-layout>
    <!-- Hero Section -->
    <div class="relative bg-black overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-black sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Bersama Membangun</span>
                            <span class="block text-red-600 xl:inline">Indonesia Maju</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            LSM Harimau (Harapan Rakyat Indonesia Maju) hadir sebagai wadah aspirasi dan pergerakan sosial untuk kemajuan bangsa. Bergabunglah bersama kami untuk perubahan nyata.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('registration') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 md:py-4 md:text-lg md:px-10 transition">
                                    Gabung Sekarang
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('public.profile') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base leading-6 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-4 md:text-lg md:px-10 transition">
                                    Tentang Kami
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="{{ asset('storage/hero.jpg') }}" alt="Sosialisasi LSM Harimau">
        </div>
    </div>

    <!-- Latest News Section -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl leading-9 font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
                    Berita Terbaru
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl leading-7 text-gray-500 sm:mt-4">
                    Update kegiatan dan informasi terkini dari LSM Harimau.
                </p>
            </div>

            <div class="mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
                @foreach($latestNews as $news)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden transition hover:-translate-y-1 hover:shadow-xl duration-300">
                        <div class="flex-shrink-0">
                            @if($news->image_path)
                                <img class="h-48 w-full object-cover" src="{{ Storage::url($news->image_path) }}" alt="{{ $news->title }}">
                            @else
                                <div class="h-48 w-full bg-gray-300 flex items-center justify-center text-gray-500">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-sm leading-5 font-medium text-red-600">
                                    <a href="#" class="hover:underline">
                                        {{ $news->region ? $news->region->name : 'Nasional' }}
                                    </a>
                                </p>
                                <a href="{{ route('news.show', $news->slug) }}" class="block">
                                    <h3 class="mt-2 text-xl leading-7 font-semibold text-gray-900">
                                        {{ $news->title }}
                                    </h3>
                                    <p class="mt-3 text-base leading-6 text-gray-500">
                                        {{ Str::limit(strip_tags($news->content), 100) }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="sr-only">{{ $news->author->name }}</span>
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                                        {{ substr($news->author->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm leading-5 font-medium text-gray-900">
                                        {{ $news->author->name }}
                                    </p>
                                    <div class="flex text-sm leading-5 text-gray-500">
                                        <time datetime="{{ $news->created_at->format('Y-m-d') }}">
                                            {{ $news->created_at->format('d M Y') }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-10 text-center">
                 <a href="{{ route('news.index') }}" class="text-base leading-6 font-semibold text-red-600 hover:text-red-500 transition">
                    Lihat Semua Berita &rarr;
                </a>
            </div>
        </div>
    </div>
</x-public-layout>