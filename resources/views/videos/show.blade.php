@extends('layouts.app')

@section('title', $content->title . ' — WolfNet')
@section('meta_description', Str::limit($content->description, 155))

@section('content')
{{-- ═══════════════════ HERO / PLAYER ═══════════════════ --}}
<section class="relative" id="video-hero">
    {{-- Player Mode --}}
    @if(isset($history))
        <div class="w-full bg-black pt-16">
            <div class="max-w-screen-xl mx-auto">
                <div class="relative w-full" style="padding-top:56.25%;">
                    @if($content->streaming_url)
                        <video id="player"
                               class="absolute inset-0 w-full h-full"
                               controls autoplay
                               src="{{ $content->streaming_url }}"
                               data-content-id="{{ $content->id }}"
                               data-progress-url="{{ route('stream.progress', $content) }}">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-surface-800">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-gray-500">No video source available</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        {{-- Detail Hero (backdrop) --}}
        <div class="relative h-[60vh] min-h-[400px]">
            <div class="absolute inset-0">
                @if($content->backdrop_url || $content->thumbnail_url)
                    <img src="{{ $content->backdrop_url ?? $content->thumbnail_url }}" alt="{{ $content->title }}"
                         class="w-full h-full object-cover">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-surface-900 via-surface-900/70 to-surface-900/40"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-surface-900/80 to-transparent"></div>
            </div>
        </div>
    @endif
</section>

{{-- ═══════════════════ CONTENT INFO ═══════════════════ --}}
<div class="max-w-screen-xl mx-auto px-4 md:px-8 {{ isset($history) ? 'pt-8' : '-mt-40 relative z-10' }}">
    <div class="flex flex-col md:flex-row gap-8">
        {{-- Poster --}}
        <div class="flex-shrink-0 w-48 md:w-56 hidden md:block">
            <div class="aspect-[2/3] rounded-lg overflow-hidden bg-surface-700 shadow-2xl ring-1 ring-white/10">
                @if($content->thumbnail_url)
                    <img src="{{ $content->thumbnail_url }}" alt="{{ $content->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-600">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- Details --}}
        <div class="flex-1 min-w-0">
            {{-- Badges --}}
            <div class="flex items-center gap-2 mb-3 flex-wrap">
                @if($content->isPremium())
                    <span class="badge badge-premium">★ PREMIUM</span>
                @else
                    <span class="badge badge-free">FREE</span>
                @endif
                <span class="badge badge-genre capitalize">{{ $content->type }}</span>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 text-shadow">{{ $content->title }}</h1>

            {{-- Meta row --}}
            <div class="flex items-center gap-4 text-sm text-gray-400 mb-5 flex-wrap">
                @if($content->vote_average)
                    <span class="flex items-center gap-1 text-yellow-400 font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        {{ number_format($content->vote_average, 1) }}
                    </span>
                @endif
                @if($content->release_year)
                    <span>{{ $content->release_year }}</span>
                @endif
                @if($content->runtime)
                    <span>{{ floor($content->runtime / 60) }}h {{ $content->runtime % 60 }}m</span>
                @endif
                @if($content->language)
                    <span class="capitalize">{{ $content->language }}</span>
                @endif
                @if($content->genres && $content->genres->count())
                    <span>{{ $content->genres->pluck('name')->join(', ') }}</span>
                @endif
            </div>

            {{-- Action buttons --}}
            <div class="flex items-center gap-3 mb-6 flex-wrap">
                @if(!isset($history))
                    <a href="{{ route('stream.play', $content) }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        Play Now
                    </a>
                @endif

                @auth
                    {{-- Watchlist Toggle --}}
                    @php
                        $inWatchlist = Auth::user()->watchlist()->where('content_id', $content->id)->exists();
                    @endphp
                    @if($inWatchlist)
                        <form method="POST" action="{{ route('watchlist.remove', $content) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-secondary">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                In My List
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('watchlist.add', $content) }}">
                            @csrf
                            <button type="submit" class="btn-secondary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Add to List
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            {{-- Description --}}
            @if($content->description)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Synopsis</h3>
                    <p class="text-gray-300 leading-relaxed max-w-3xl">{{ $content->description }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════ RELATED CONTENT ═══════════════════ --}}
    @if(isset($related) && $related->count())
        <div class="mt-12 mb-8">
            <h2 class="text-xl font-bold text-white mb-5">More Like This</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($related as $item)
                    @include('partials.content-card', ['content' => $item, 'width' => 'w-full'])
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- ═══════════════════ PROGRESS TRACKING ═══════════════════ --}}
@if(isset($history) && $content->streaming_url)
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('player');
    if (!video) return;

    const progressUrl = video.dataset.progressUrl;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let lastSaved = 0;

    // Resume from saved position
    @if($history && $history->watched_seconds > 0)
        video.currentTime = {{ $history->watched_seconds }};
    @endif

    // Save progress every 15 seconds
    setInterval(() => {
        if (video.paused || video.ended) return;
        const current = Math.floor(video.currentTime);
        if (current === lastSaved) return;
        lastSaved = current;

        fetch(progressUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ watched_seconds: current })
        }).catch(() => {});
    }, 15000);
});
</script>
@endpush
@endif
@endsection
