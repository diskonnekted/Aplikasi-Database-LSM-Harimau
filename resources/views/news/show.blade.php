<x-public-layout>
    <div class="bg-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="prose lg:prose-xl mx-auto">
                <div class="mb-8">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-red-100 text-red-800">
                        {{ $news->region ? $news->region->name : 'Nasional' }}
                    </span>
                    <h1 class="mt-4 text-3xl leading-9 font-extrabold text-gray-900 sm:text-4xl sm:leading-10">
                        {{ $news->title }}
                    </h1>
                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                        <span>{{ $news->author->name }}</span>
                        <span class="mx-1">&middot;</span>
                        <time datetime="{{ $news->created_at->format('Y-m-d') }}">
                            {{ $news->created_at->format('d F Y') }}
                        </time>
                    </div>
                </div>

                @if($news->image_path)
                    <div class="mb-8">
                        <img class="w-full rounded-lg shadow-lg object-cover" src="{{ Storage::url($news->image_path) }}" alt="{{ $news->title }}">
                    </div>
                @endif

                <div class="mt-6 text-gray-700 leading-relaxed">
                    {!! nl2br(e($news->content)) !!}
                </div>
                
                <div class="mt-12 border-t pt-8">
                    <a href="{{ route('news.index') }}" class="text-red-600 hover:text-red-500 font-medium">
                        &larr; Kembali ke Berita
                    </a>
                </div>
            </article>
        </div>
    </div>
</x-public-layout>
