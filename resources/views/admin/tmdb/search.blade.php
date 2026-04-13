@extends('layouts.app')

@section('title', 'Import from TMDB — Admin — WolfNet')

@section('content')
<div class="pt-24 pb-12 px-4 md:px-12 max-w-screen-2xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Import from TMDB</h1>
            <p class="text-gray-500 text-sm">Search The Movie Database and add titles to your catalogue</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.content.index') }}" class="btn-outline btn-sm">← Videos</a>
            <form method="POST" action="{{ route('admin.tmdb.import-trending') }}">
                @csrf
                <button type="submit" class="btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    Import Trending
                </button>
            </form>
        </div>
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.tmdb.search') }}" class="mb-8" id="tmdb-search-form">
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[250px] max-w-xl">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ $query }}"
                       placeholder="Search movies & shows on TMDB..."
                       class="input-dark !pl-10 !py-3 text-sm" autofocus id="tmdb-search-input">
            </div>

            <select name="type" class="select-dark !w-auto !py-3 text-sm" id="tmdb-type-filter">
                <option value="multi" {{ $type === 'multi' ? 'selected' : '' }}>All</option>
                <option value="movie" {{ $type === 'movie' ? 'selected' : '' }}>Movies</option>
                <option value="tv" {{ $type === 'tv' ? 'selected' : '' }}>TV Shows</option>
            </select>

            <button type="submit" class="btn-primary !py-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Search TMDB
            </button>
        </div>
    </form>

    {{-- Results --}}
    @if($query)
        @if(count($results) > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4" id="tmdb-results">
                @foreach($results as $item)
                    <div class="relative group">
                        <div class="aspect-[2/3] bg-surface-700 rounded-lg overflow-hidden ring-1 ring-white/5">
                            @if($item['_poster'])
                                <img src="{{ $item['_poster'] }}" alt="{{ $item['_title'] }}"
                                     class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                                </div>
                            @endif

                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3">
                                <h3 class="text-white text-sm font-semibold truncate">{{ $item['_title'] }}</h3>
                                <div class="flex items-center gap-2 mt-1 text-xs text-gray-400">
                                    @if($item['_year'])
                                        <span>{{ $item['_year'] }}</span>
                                    @endif
                                    <span class="capitalize px-1.5 py-0.5 rounded bg-white/10">{{ $item['_type'] === 'tv' ? 'Series' : 'Movie' }}</span>
                                    @if(isset($item['vote_average']) && $item['vote_average'] > 0)
                                        <span class="flex items-center gap-0.5">
                                            <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            {{ number_format($item['vote_average'], 1) }}
                                        </span>
                                    @endif
                                </div>

                                @if(!empty($item['overview']))
                                    <p class="text-gray-400 text-[10px] leading-tight mt-1 line-clamp-3">{{ $item['overview'] }}</p>
                                @endif

                                @if($item['_already_imported'])
                                    <div class="mt-2 text-center">
                                        <span class="inline-flex items-center gap-1 text-xs text-green-400">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                            Already imported
                                        </span>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('admin.tmdb.import') }}" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="tmdb_id" value="{{ $item['id'] }}">
                                        <input type="hidden" name="type" value="{{ $item['_type'] === 'tv' ? 'tv' : 'movie' }}">
                                        <div class="flex gap-1">
                                            <button type="submit" name="is_premium" value="0"
                                                    class="flex-1 py-1.5 rounded bg-brand hover:bg-brand-hover text-white text-xs font-medium transition-colors">
                                                + Free
                                            </button>
                                            <button type="submit" name="is_premium" value="1"
                                                    class="flex-1 py-1.5 rounded bg-yellow-600 hover:bg-yellow-500 text-white text-xs font-medium transition-colors">
                                                ★ Premium
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{-- Type badge --}}
                        <div class="absolute top-2 left-2">
                            <span class="text-[10px] font-bold uppercase px-1.5 py-0.5 rounded {{ $item['_type'] === 'tv' ? 'bg-blue-500/80' : 'bg-brand/80' }} text-white backdrop-blur-sm">
                                {{ $item['_type'] === 'tv' ? 'TV' : 'Movie' }}
                            </span>
                        </div>

                        {{-- Already imported indicator --}}
                        @if($item['_already_imported'])
                            <div class="absolute top-2 right-2">
                                <span class="w-5 h-5 rounded-full bg-green-500/80 backdrop-blur-sm flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($totalPages > 1)
                <div class="flex items-center justify-center gap-2 mt-8">
                    @if($page > 1)
                        <a href="{{ route('admin.tmdb.search', ['q' => $query, 'type' => $type, 'page' => $page - 1]) }}"
                           class="btn-outline btn-sm">← Previous</a>
                    @endif
                    <span class="text-gray-500 text-sm px-3">Page {{ $page }} of {{ min($totalPages, 500) }}</span>
                    @if($page < $totalPages)
                        <a href="{{ route('admin.tmdb.search', ['q' => $query, 'type' => $type, 'page' => $page + 1]) }}"
                           class="btn-outline btn-sm">Next →</a>
                    @endif
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <h3 class="text-xl font-semibold text-gray-400 mb-2">No results found</h3>
                <p class="text-gray-600">Try a different search term.</p>
            </div>
        @endif
    @else
        {{-- Empty state --}}
        <div class="text-center py-20">
            <div class="w-20 h-20 rounded-full bg-surface-700 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-white mb-3">Search TMDB</h2>
            <p class="text-gray-500 max-w-md mx-auto mb-8">Search for any movie or TV show on The Movie Database and import it directly into your catalogue with one click.</p>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <form method="POST" action="{{ route('admin.tmdb.import-trending') }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Import Trending Now
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
