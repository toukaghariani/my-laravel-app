@extends('layouts.app')

@section('title', 'Watch History — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Watch History</h1>
            <p class="text-gray-500 text-sm">Pick up where you left off</p>
        </div>
        <a href="{{ route('content.index') }}" class="btn-outline btn-sm">Browse More</a>
    </div>

    @if($history->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($history as $entry)
                <div class="content-card w-full">
                    <a href="{{ route('stream.play', $entry->content) }}" class="block">
                        <div class="aspect-[2/3] bg-surface-700 rounded-md overflow-hidden relative">
                            @if($entry->content->thumbnail_url)
                                <img src="{{ $entry->content->thumbnail_url }}" alt="{{ $entry->content->title }}"
                                     class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                                </div>
                            @endif

                            {{-- Progress bar --}}
                            @if($entry->watched_seconds > 0)
                                <div class="absolute bottom-0 left-0 right-0 h-1 bg-surface-600">
                                    <div class="h-full bg-brand rounded-r-full" style="width: {{ min(100, ($entry->watched_seconds / max($entry->content->duration ?? 1, 1)) * 100) }}%"></div>
                                </div>
                            @endif

                            {{-- Play overlay --}}
                            <div class="card-overlay !items-center !justify-center">
                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                                <h3 class="text-white text-sm font-semibold truncate w-full text-center px-2">{{ $entry->content->title }}</h3>
                                <p class="text-gray-400 text-xs mt-1">{{ $entry->watched_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $history->links() }}
        </div>
    @else
        <div class="text-center py-24">
            <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h3 class="text-xl font-semibold text-gray-400 mb-2">No watch history yet</h3>
            <p class="text-gray-600 mb-6">Start watching to build your history.</p>
            <a href="{{ route('content.index') }}" class="btn-primary">Browse Titles</a>
        </div>
    @endif
</div>
@endsection
