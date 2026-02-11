<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if($news->image_path)
                    <div class="w-full h-96 overflow-hidden relative group">
                        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ asset('storage/' . $news->image_path) }}" alt="{{ $news->title }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-white">
                             <div class="flex items-center space-x-2 mb-2">
                                <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">
                                    {{ $news->region ? $news->region->name : 'Nasional' }}
                                </span>
                                @if($news->source)
                                    <span class="bg-gray-800 text-white text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">
                                        Sumber: {{ $news->source }}
                                    </span>
                                @endif
                            </div>
                            <h1 class="text-4xl font-extrabold leading-tight text-shadow-lg">{{ $news->title }}</h1>
                        </div>
                    </div>
                @else
                    <div class="p-8 border-b border-gray-200">
                        <div class="flex items-center space-x-2 mb-4">
                            <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">
                                {{ $news->region ? $news->region->name : 'Nasional' }}
                            </span>
                             @if($news->source)
                                <span class="bg-gray-800 text-white text-xs font-bold px-2 py-1 rounded uppercase tracking-wide">
                                    Sumber: {{ $news->source }}
                                </span>
                            @endif
                        </div>
                        <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">{{ $news->title }}</h1>
                    </div>
                @endif

                <div class="p-8">
                    <div class="flex items-center justify-between mb-8 pb-8 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-xl">
                                    {{ substr($news->author->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    Penulis: {{ $news->author->name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $news->created_at->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex space-x-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <i class="fab fa-facebook fa-lg"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $news->title }}" target="_blank" class="text-gray-400 hover:text-blue-400 transition-colors">
                                <i class="fab fa-twitter fa-lg"></i>
                            </a>
                            <a href="https://wa.me/?text={{ $news->title }}%20{{ url()->current() }}" target="_blank" class="text-gray-400 hover:text-green-500 transition-colors">
                                <i class="fab fa-whatsapp fa-lg"></i>
                            </a>
                        </div>
                    </div>

                    <div class="prose prose-lg prose-red max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    @if($news->video_url)
                        <div class="mt-8 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Video Terkait</h3>
                            <div class="aspect-w-16 aspect-h-9">
                                @php
                                    $videoUrl = $news->video_url;
                                    if (str_contains($videoUrl, 'youtube.com/watch?v=')) {
                                        $videoId = explode('v=', $videoUrl)[1];
                                        $videoId = explode('&', $videoId)[0];
                                        $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                                    } elseif (str_contains($videoUrl, 'youtu.be/')) {
                                        $videoId = explode('youtu.be/', $videoUrl)[1];
                                        $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                                    }
                                @endphp
                                <iframe src="{{ $videoUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-96 rounded-lg shadow-lg"></iframe>
                            </div>
                        </div>
                    @endif

                    @if(!empty($news->social_links))
                        <div class="mt-8 pt-8 border-t border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tautan Media Sosial</h3>
                            <div class="flex flex-wrap gap-4">
                                @if(isset($news->social_links['youtube']))
                                    <a href="{{ $news->social_links['youtube'] }}" target="_blank" class="flex items-center space-x-2 px-4 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors">
                                        <i class="fab fa-youtube"></i>
                                        <span>YouTube</span>
                                    </a>
                                @endif
                                @if(isset($news->social_links['tiktok']))
                                    <a href="{{ $news->social_links['tiktok'] }}" target="_blank" class="flex items-center space-x-2 px-4 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors">
                                        <i class="fab fa-tiktok"></i>
                                        <span>TikTok</span>
                                    </a>
                                @endif
                                @if(isset($news->social_links['instagram']))
                                    <a href="{{ $news->social_links['instagram'] }}" target="_blank" class="flex items-center space-x-2 px-4 py-2 bg-pink-600 text-white rounded-full hover:bg-pink-700 transition-colors">
                                        <i class="fab fa-instagram"></i>
                                        <span>Instagram</span>
                                    </a>
                                @endif
                                @if(isset($news->social_links['facebook']))
                                    <a href="{{ $news->social_links['facebook'] }}" target="_blank" class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                                        <i class="fab fa-facebook-f"></i>
                                        <span>Facebook</span>
                                    </a>
                                @endif
                                @if(isset($news->social_links['twitter']))
                                    <a href="{{ $news->social_links['twitter'] }}" target="_blank" class="flex items-center space-x-2 px-4 py-2 bg-blue-400 text-white rounded-full hover:bg-blue-500 transition-colors">
                                        <i class="fab fa-twitter"></i>
                                        <span>Twitter</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <a href="{{ route('news.index') }}" class="inline-flex items-center font-medium text-red-600 hover:text-red-500 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Berita
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</x-public-layout>
