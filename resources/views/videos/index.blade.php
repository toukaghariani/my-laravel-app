@extends('layouts.app')

@section('title', 'Browse — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Browse</h1>
        <p class="text-gray-500">Discover movies and series</p>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('content.index') }}" class="mb-8" id="browse-filters">
        <div class="flex flex-wrap items-center gap-3">
            {{-- Search --}}
            <div class="relative flex-1 min-w-[200px] max-w-md">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search titles..."
                       class="input-dark !pl-10 !py-2.5 text-sm" id="browse-search">
            </div>

            {{-- Type Filter --}}
            <select name="type" class="select-dark !w-auto !py-2.5 text-sm" onchange="this.form.submit()" id="browse-type">
                <option value="">All Types</option>
                <option value="movie" {{ request('type') === 'movie' ? 'selected' : '' }}>Movies</option>
                <option value="series" {{ request('type') === 'series' ? 'selected' : '' }}>Series</option>
            </select>

            {{-- Genre Filter --}}
            <select name="genre" class="select-dark !w-auto !py-2.5 text-sm" onchange="this.form.submit()" id="browse-genre">
                <option value="">All Genres</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Search
            </button>

            @if(request()->hasAny(['search', 'type', 'genre']))
                <a href="{{ route('content.index') }}" class="text-sm text-gray-500 hover:text-white transition-colors">Clear filters</a>
            @endif
        </div>
    </form>

    {{-- Genre Pills --}}
    @if($genres->count())
        <div class="flex flex-wrap gap-2 mb-8">
            <a href="{{ route('content.index') }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 {{ !request('genre') ? 'bg-white text-black' : 'bg-surface-600 text-gray-300 hover:bg-surface-500 hover:text-white' }}">
                All
            </a>
            @foreach($genres as $genre)
                <a href="{{ route('content.index', array_merge(request()->except('genre', 'page'), ['genre' => $genre->id])) }}"
                   class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 {{ request('genre') == $genre->id ? 'bg-white text-black' : 'bg-surface-600 text-gray-300 hover:bg-surface-500 hover:text-white' }}">
                    {{ $genre->name }}
                </a>
            @endforeach
        </div>
    @endif

    {{-- Results --}}
    @if($contents->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4" id="browse-grid">
            @foreach($contents as $content)
                @include('partials.content-card', ['content' => $content, 'width' => 'w-full'])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $contents->links() }}
        </div>
    @else
        <div class="text-center py-24">
            <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
            <h3 class="text-xl font-semibold text-gray-400 mb-2">No titles found</h3>
            <p class="text-gray-600">Try adjusting your search or filters.</p>
        </div>
    @endif
</div>
@endsection
