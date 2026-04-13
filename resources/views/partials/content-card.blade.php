{{-- Content card partial — expects $content (App\Models\Content) --}}
<div class="content-card flex-shrink-0 {{ $width ?? 'w-[150px] md:w-[185px]' }}">
    <a href="{{ route('content.show', $content) }}" class="block">
        <div class="aspect-[2/3] bg-surface-700 rounded-md overflow-hidden relative">
            @if($content->thumbnail_url)
                <img src="{{ $content->thumbnail_url }}"
                     alt="{{ $content->title }}"
                     class="w-full h-full object-cover"
                     loading="lazy">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-gray-600 gap-2">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                    </svg>
                    <span class="text-xs text-center px-2 truncate w-full">{{ $content->title }}</span>
                </div>
            @endif

            {{-- Premium badge --}}
            @if($content->isPremium())
                <div class="absolute top-2 right-2">
                    <span class="badge badge-premium text-[10px]">★ PREMIUM</span>
                </div>
            @endif

            {{-- Hover Overlay --}}
            <div class="card-overlay">
                <h3 class="text-white text-sm font-semibold truncate">{{ $content->title }}</h3>
                <div class="flex items-center gap-2 mt-1 flex-wrap">
                    @if($content->release_year)
                        <span class="text-gray-400 text-xs">{{ $content->release_year }}</span>
                    @endif
                    <span class="text-gray-500 text-xs capitalize">{{ $content->type }}</span>
                    @if($content->genres && $content->genres->count())
                        <span class="text-gray-500 text-xs">• {{ $content->genres->first()->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>
