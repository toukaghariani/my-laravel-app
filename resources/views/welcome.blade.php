@extends('layouts.app')

@section('title', 'WolfNet — Stream Movies & Series')
@section('meta_description', 'WolfNet — Your premium streaming platform. Watch unlimited movies and series.')

@section('content')
{{-- ═══════════════════ HERO SECTION ═══════════════════ --}}
@if($featured)
    <section class="relative h-[85vh] min-h-[500px] flex items-end" id="hero">
        {{-- Background --}}
        <div class="absolute inset-0">
            @if($featured->backdrop_url || $featured->thumbnail_url)
                <img src="{{ $featured->backdrop_url ?? $featured->thumbnail_url }}" alt="{{ $featured->title }}"
                     class="w-full h-full object-cover">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-surface-900 via-surface-900/60 to-surface-900/30"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-surface-900/90 via-surface-900/40 to-transparent"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 max-w-screen-2xl mx-auto px-4 md:px-12 pb-16 md:pb-24 w-full">
            <div class="max-w-2xl">
                @if($featured->isPremium())
                    <span class="badge badge-premium mb-3">★ PREMIUM</span>
                @endif
                <h1 class="text-4xl md:text-6xl font-extrabold text-white text-shadow leading-tight mb-4">
                    {{ $featured->title }}
                </h1>
                <div class="flex items-center gap-3 text-sm text-gray-300 mb-4">
                    @if($featured->release_year)
                        <span>{{ $featured->release_year }}</span>
                    @endif
                    <span class="capitalize">{{ $featured->type }}</span>
                    @if($featured->language)
                        <span>{{ $featured->language }}</span>
                    @endif
                    @if($featured->genres && $featured->genres->count())
                        <span>{{ $featured->genres->pluck('name')->join(', ') }}</span>
                    @endif
                    @if($featured->vote_average)
                        <span class="flex items-center gap-1 text-yellow-400 font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            {{ number_format($featured->vote_average, 1) }}
                        </span>
                    @endif
                </div>
                @if($featured->description)
                    <p class="text-gray-300 text-base md:text-lg leading-relaxed line-clamp-3 mb-6">
                        {{ $featured->description }}
                    </p>
                @endif
                <div class="flex items-center gap-3">
                    <a href="{{ route('stream.play', $featured) }}" class="btn-primary text-lg !px-8">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        Play
                    </a>
                    <a href="{{ route('content.show', $featured) }}" class="btn-secondary text-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        More Info
                    </a>
                </div>
            </div>
        </div>
    </section>
@else
    {{-- No content yet: CTA hero --}}
    <section class="relative h-[70vh] min-h-[400px] flex items-center justify-center bg-gradient-to-br from-surface-900 via-surface-800 to-brand/10">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(229,9,20,0.08)_0%,_transparent_70%)]"></div>
        <div class="relative text-center px-4">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6">Unlimited <span class="text-brand">Entertainment</span></h1>
            <p class="text-xl text-gray-400 mb-8 max-w-xl mx-auto">Watch movies and series anytime, anywhere. Start streaming today.</p>
            <div class="flex items-center justify-center gap-4">
                <a href="{{ route('content.index') }}" class="btn-primary text-lg">Browse Catalogue</a>
                <a href="{{ route('subscriptions.plans') }}" class="btn-outline text-lg">View Plans</a>
            </div>
        </div>
    </section>
@endif

{{-- ═══════════════════ CONTENT ROWS ═══════════════════ --}}
<div class="relative z-10 -mt-16 md:-mt-24 space-y-2">

    {{-- Trending --}}
    @if($trending->count())
        <div class="content-row">
            <h2 class="content-row-title">Trending Now</h2>
            <div class="content-row-scroll">
                @foreach($trending as $content)
                    @include('partials.content-card', ['content' => $content])
                @endforeach
            </div>
        </div>
    @endif

    {{-- Movies --}}
    @if($movies->count())
        <div class="content-row">
            <h2 class="content-row-title">Movies</h2>
            <div class="content-row-scroll">
                @foreach($movies as $content)
                    @include('partials.content-card', ['content' => $content])
                @endforeach
            </div>
        </div>
    @endif

    {{-- Series --}}
    @if($series->count())
        <div class="content-row">
            <h2 class="content-row-title">Series</h2>
            <div class="content-row-scroll">
                @foreach($series as $content)
                    @include('partials.content-card', ['content' => $content])
                @endforeach
            </div>
        </div>
    @endif

    {{-- Browse All CTA --}}
    <div class="text-center py-12">
        <a href="{{ route('content.index') }}" class="btn-outline">
            Browse All Titles
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</div>
@endsection
