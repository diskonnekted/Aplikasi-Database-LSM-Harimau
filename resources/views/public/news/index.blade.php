<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Berita Terbaru
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Informasi terkini seputar kegiatan dan perkembangan LSM Harimau.
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($news as $item)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden bg-white hover:shadow-xl transition-shadow duration-300">
                        <div class="flex-shrink-0">
                            @if($item->image_path)
                                <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}">
                            @else
                                <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-4xl"><i class="fas fa-newspaper"></i></span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-red-600">
                                    {{ $item->region ? $item->region->name : 'Nasional' }}
                                </p>
                                <a href="{{ route('news.show', $item->slug) }}" class="block mt-2">
                                    <p class="text-xl font-semibold text-gray-900 hover:text-red-600 transition-colors duration-200">
                                        {{ $item->title }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500 line-clamp-3">
                                        {{ Str::limit(strip_tags($item->content), 150) }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="sr-only">{{ $item->author->name }}</span>
                                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold">
                                        {{ substr($item->author->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $item->author->name }}
                                    </p>
                                    <div class="flex space-x-1 text-sm text-gray-500">
                                        <time datetime="{{ $item->created_at->format('Y-m-d') }}">
                                            {{ $item->created_at->format('d M Y') }}
                                        </time>
                                        <span aria-hidden="true">&middot;</span>
                                        @if($item->source)
                                            <span class="font-semibold text-red-500">{{ $item->source }}</span>
                                        @else
                                            <span>LSM Harimau</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</x-public-layout>
