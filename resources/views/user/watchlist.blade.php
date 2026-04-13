@extends('layouts.app')

@section('title', 'My List — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">My List</h1>
            <p class="text-gray-500 text-sm">Your saved titles</p>
        </div>
        <a href="{{ route('content.index') }}" class="btn-outline btn-sm">Browse More</a>
    </div>

    @if($items->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($items as $item)
                <div class="content-card w-full group/card">
                    <a href="{{ route('content.show', $item->content) }}" class="block">
                        <div class="aspect-[2/3] bg-surface-700 rounded-md overflow-hidden relative">
                            @if($item->content->thumbnail_url)
                                <img src="{{ $item->content->thumbnail_url }}" alt="{{ $item->content->title }}"
                                     class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                                </div>
                            @endif

                            @if($item->content->isPremium())
                                <div class="absolute top-2 right-2">
                                    <span class="badge badge-premium text-[10px]">★</span>
                                </div>
                            @endif

                            <div class="card-overlay">
                                <h3 class="text-white text-sm font-semibold truncate">{{ $item->content->title }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    @if($item->content->release_year)
                                        <span class="text-gray-400 text-xs">{{ $item->content->release_year }}</span>
                                    @endif
                                    <span class="text-gray-500 text-xs capitalize">{{ $item->content->type }}</span>
                                </div>
                                <p class="text-gray-500 text-xs mt-1">Added {{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>

                    {{-- Remove button --}}
                    <form method="POST" action="{{ route('watchlist.remove', $item->content) }}"
                          class="absolute top-2 left-2 opacity-0 group-hover/card:opacity-100 transition-opacity z-20">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-7 h-7 rounded-full bg-black/60 backdrop-blur-sm flex items-center justify-center text-gray-400 hover:text-red-400 hover:bg-black/80 transition-all"
                                title="Remove from list">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $items->links() }}
        </div>
    @else
        <div class="text-center py-24">
            <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            <h3 class="text-xl font-semibold text-gray-400 mb-2">Your list is empty</h3>
            <p class="text-gray-600 mb-6">Add movies and series to watch later.</p>
            <a href="{{ route('content.index') }}" class="btn-primary">Browse Titles</a>
        </div>
    @endif
</div>
@endsection
