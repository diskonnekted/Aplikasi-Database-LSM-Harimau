<x-public-layout>
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl leading-9 font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
                    Berita & Kegiatan
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl leading-7 text-gray-500 sm:mt-4">
                    Kabar terbaru dari seluruh wilayah.
                </p>
            </div>

            <div class="mt-12 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
                @foreach($news as $item)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden transition hover:shadow-xl duration-300">
                        <div class="flex-shrink-0">
                            @if($item->image_path)
                                <img class="h-48 w-full object-cover" src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}">
                            @else
                                <div class="h-48 w-full bg-gray-300 flex items-center justify-center text-gray-500">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <p class="text-sm leading-5 font-medium text-red-600">
                                    {{ $item->region ? $item->region->name : 'Nasional' }}
                                </p>
                                <a href="{{ route('news.show', $item->slug) }}" class="block">
                                    <h3 class="mt-2 text-xl leading-7 font-semibold text-gray-900">
                                        {{ $item->title }}
                                    </h3>
                                    <p class="mt-3 text-base leading-6 text-gray-500">
                                        {{ Str::limit(strip_tags($item->content), 100) }}
                                    </p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                                        {{ substr($item->author->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm leading-5 font-medium text-gray-900">
                                        {{ $item->author->name }}
                                    </p>
                                    <div class="flex text-sm leading-5 text-gray-500">
                                        <time datetime="{{ $item->created_at->format('Y-m-d') }}">
                                            {{ $item->created_at->format('d M Y') }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</x-public-layout>
