@extends('layouts.app')

@section('title', 'Search — WolfNet')

@section('content')

{{-- ============================================================
     SEARCH PAGE — WolfNet
     USER2: Je veux rechercher film/série
     Backend TODO:
       - Route: GET /search?q=... → SearchController@index
       - Pass $query (string) and $results (collection)
       - Each result: id, title, year, genre, rating, poster_url, type (movie/series)
     ============================================================ --}}

<div class="wn-search-page">
    <div class="container">

        {{-- ── SEARCH HEADER ── --}}
        <div class="wn-search-header">
            <h1 class="wn-search-title">
                {{-- TODO: @if($query) Search results for <span class="wn-red-text">"{{ $query }}"</span> @else --}}
                <span id="searchHeading">Search</span>
            </h1>
            <p class="wn-search-meta" id="searchMeta">
                Enter a title to find movies and series
            </p>
        </div>

        {{-- ── BIG SEARCH BAR ── --}}
        <div class="wn-big-search-wrap">
            <form action="{{ url('/search') }}" method="GET" id="searchForm">
                <div class="wn-big-search-box">
                    <i class="bi bi-search wn-big-search-icon"></i>
                    <input
                        type="text"
                        name="q"
                        id="searchInput"
                        class="wn-big-search-input"
                        placeholder="Search movies, series, directors..."
                        value="{{ request('q') }}"
                        autocomplete="off"
                        autofocus>
                    <button type="submit" class="wn-big-search-btn">Search</button>
                </div>
            </form>

            {{-- Quick filter chips --}}
            <div class="wn-filter-chips">
                <button class="wn-chip active" onclick="setFilter('all', this)">All</button>
                <button class="wn-chip" onclick="setFilter('movie', this)">Movies</button>
                <button class="wn-chip" onclick="setFilter('series', this)">Series</button>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════
             EMPTY STATE — shown before any search
        ══════════════════════════════════════════════════ --}}
        <div class="wn-search-empty" id="emptyState">
            <div class="wn-empty-search-icon">🔍</div>
            <h3 class="wn-empty-title">What are you looking for?</h3>
            <p class="wn-empty-text">Search for your favourite movies, series, or directors above.</p>

            {{-- Trending searches --}}
            <div class="wn-trending-searches">
                <p class="wn-trending-label">🔥 Trending Searches</p>
                <div class="wn-trending-tags">
                    <a href="{{ url('/search?q=Inception') }}" class="wn-trending-tag">Inception</a>
                    <a href="{{ url('/search?q=Breaking+Bad') }}" class="wn-trending-tag">Breaking Bad</a>
                    <a href="{{ url('/search?q=Nolan') }}" class="wn-trending-tag">Nolan</a>
                    <a href="{{ url('/search?q=Action') }}" class="wn-trending-tag">Action</a>
                    <a href="{{ url('/search?q=2024') }}" class="wn-trending-tag">2024</a>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════
             NO RESULTS STATE
        ══════════════════════════════════════════════════ --}}
        <div class="wn-no-results" id="noResults" style="display:none;">
            <div class="wn-empty-search-icon">😕</div>
            <h3 class="wn-empty-title">No results found</h3>
            <p class="wn-empty-text">Try a different title or check the spelling.</p>
            <a href="{{ url('/search') }}" class="wn-btn-primary wn-empty-cta">Clear Search</a>
        </div>

        {{-- ══════════════════════════════════════════════════
             RESULTS GRID
             TODO: Backend dev → replace demo cards with:
             @if($results->isEmpty())
                 show noResults div
             @else
                 @foreach($results as $item) ... @endforeach
             @endif
        ══════════════════════════════════════════════════ --}}
        <div class="wn-results-grid" id="resultsGrid" style="display:none;">

            {{-- Results count bar --}}
            <div class="wn-results-bar">
                <span class="wn-results-count">
                    <span id="resultsCount">0</span> results found
                </span>
                <div class="wn-sort-wrap">
                    <select class="wn-fav-select" onchange="sortResults(this.value)">
                        <option value="relevance">Most Relevant</option>
                        <option value="rating">Highest Rated</option>
                        <option value="year">Newest First</option>
                        <option value="title">Title A–Z</option>
                    </select>
                    <span class="wn-select-arrow">⌄</span>
                </div>
            </div>

            {{-- Cards grid --}}
            <div class="row g-3" id="cardsContainer">

                {{-- DEMO CARDS — remove when backend sends real $results --}}
                @php
                $demoMovies = [
                    ['id'=>1,'title'=>'Inception','year'=>2010,'genre'=>'Sci-Fi','rating'=>8.8,'type'=>'movie'],
                    ['id'=>2,'title'=>'The Dark Knight','year'=>2008,'genre'=>'Action','rating'=>9.0,'type'=>'movie'],
                    ['id'=>3,'title'=>'Interstellar','year'=>2014,'genre'=>'Drama','rating'=>8.6,'type'=>'movie'],
                    ['id'=>4,'title'=>'Breaking Bad','year'=>2008,'genre'=>'Crime','rating'=>9.5,'type'=>'series'],
                    ['id'=>5,'title'=>'Pulp Fiction','year'=>1994,'genre'=>'Crime','rating'=>8.9,'type'=>'movie'],
                    ['id'=>6,'title'=>'The Office','year'=>2005,'genre'=>'Comedy','rating'=>8.9,'type'=>'series'],
                ];
                @endphp

                @foreach($demoMovies as $item)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 wn-result-item"
                     data-type="{{ $item['type'] }}"
                     data-title="{{ $item['title'] }}"
                     data-rating="{{ $item['rating'] }}"
                     data-year="{{ $item['year'] }}">
                    <a href="{{ url('/movie/' . $item['id']) }}" class="wn-result-link">
                        <div class="wn-card">
                            <div class="wn-result-type-badge wn-badge-{{ $item['type'] }}">
                                {{ $item['type'] === 'movie' ? '🎬 Movie' : '📺 Series' }}
                            </div>
                            <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text={{ urlencode($item['title']) }}"
                                 alt="{{ $item['title'] }}"
                                 loading="lazy">
                            <div class="wn-card-body">
                                <p class="wn-card-title">{{ $item['title'] }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="wn-card-meta">{{ $item['year'] }}</span>
                                    <span class="wn-rating">
                                        <i class="bi bi-star-fill"></i> {{ $item['rating'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>{{-- /row --}}
        </div>{{-- /results grid --}}

    </div>{{-- /container --}}
</div>{{-- /search page --}}


@push('styles')
<style>
/* ── Page ── */
.wn-search-page {
    min-height: 100vh;
    background: var(--wn-dark);
    padding: 110px 0 80px;
}

/* ── Header ── */
.wn-search-header {
    text-align: center;
    margin-bottom: 36px;
    animation: wn-fadein 0.4s ease;
}
.wn-search-title {
    font-size: clamp(1.8rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--wn-white);
    letter-spacing: -0.03em;
    margin: 0 0 8px;
}
.wn-red-text { color: var(--wn-red); }
.wn-search-meta { color: var(--wn-muted); font-size: 0.95rem; margin: 0; }

/* ── Big search bar ── */
.wn-big-search-wrap {
    max-width: 680px;
    margin: 0 auto 48px;
    animation: wn-fadein 0.4s ease 0.05s both;
}
.wn-big-search-box {
    display: flex;
    align-items: center;
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    border-radius: 12px;
    padding: 6px 6px 6px 20px;
    gap: 12px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.wn-big-search-box:focus-within {
    border-color: var(--wn-red);
    box-shadow: 0 0 0 3px rgba(229,9,20,0.12);
}
.wn-big-search-icon { color: var(--wn-muted); font-size: 1.1rem; flex-shrink: 0; }
.wn-big-search-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: var(--wn-white);
    font-size: 1rem;
    padding: 8px 0;
}
.wn-big-search-input::placeholder { color: var(--wn-muted); }
.wn-big-search-btn {
    background: var(--wn-red);
    color: var(--wn-white);
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background 0.2s;
    flex-shrink: 0;
}
.wn-big-search-btn:hover { background: var(--wn-red-dark); }

/* ── Filter chips ── */
.wn-filter-chips {
    display: flex;
    gap: 8px;
    margin-top: 14px;
    justify-content: center;
}
.wn-chip {
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    color: var(--wn-muted);
    padding: 5px 16px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.wn-chip:hover { border-color: var(--wn-red); color: var(--wn-text); }
.wn-chip.active { background: var(--wn-red); border-color: var(--wn-red); color: var(--wn-white); }

/* ── Empty / No results state ── */
.wn-search-empty,
.wn-no-results {
    text-align: center;
    padding: 60px 20px;
    animation: wn-fadein 0.4s ease;
}
.wn-empty-search-icon { font-size: 3.5rem; margin-bottom: 20px; }
.wn-empty-title { color: var(--wn-white); font-size: 1.4rem; font-weight: 700; margin: 0 0 10px; }
.wn-empty-text { color: #b0b0b0; font-size: 0.95rem; margin: 0 0 28px; }
.wn-empty-cta {
    display: inline-block;
    padding: 11px 28px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.92rem;
    transition: opacity 0.2s;
}
.wn-empty-cta:hover { opacity: 0.85; }

/* ── Trending searches ── */
.wn-trending-searches { margin-top: 32px; }
.wn-trending-label {
    color: var(--wn-muted);
    font-size: 0.82rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 12px;
}
.wn-trending-tags { display: flex; flex-wrap: wrap; gap: 8px; justify-content: center; }
.wn-trending-tag {
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    color: var(--wn-text);
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s;
}
.wn-trending-tag:hover { border-color: var(--wn-red); color: var(--wn-red); }

/* ── Results bar ── */
.wn-results-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.wn-results-count { color: var(--wn-muted); font-size: 0.88rem; }
.wn-results-count span { color: var(--wn-white); font-weight: 700; }
.wn-sort-wrap { position: relative; }
.wn-fav-select {
    appearance: none;
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    color: var(--wn-text);
    padding: 7px 32px 7px 14px;
    border-radius: 6px;
    font-size: 0.82rem;
    cursor: pointer;
}
.wn-fav-select:focus { outline: none; border-color: var(--wn-red); }
.wn-select-arrow {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--wn-muted);
    pointer-events: none;
}

/* ── Result type badge ── */
.wn-result-link { text-decoration: none; display: block; }
.wn-card { position: relative; }
.wn-result-type-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
    z-index: 2;
    backdrop-filter: blur(4px);
}
.wn-badge-movie { background: rgba(229,9,20,0.85); color: #fff; }
.wn-badge-series { background: rgba(59,130,246,0.85); color: #fff; }

/* ── Keyframes ── */
@keyframes wn-fadein {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Responsive ── */
@media (max-width: 576px) {
    .wn-big-search-btn { padding: 10px 14px; font-size: 0.82rem; }
}
</style>
@endpush


@push('scripts')
<script>
/* ── On page load: show results if query exists ── */
document.addEventListener('DOMContentLoaded', function () {
    const query = "{{ request('q') }}";
    if (query && query.trim() !== '') {
        showResults(query);
    }
});

/* ── Show results section ── */
function showResults(query) {
    document.getElementById('emptyState').style.display = 'none';
    document.getElementById('noResults').style.display = 'none';
    document.getElementById('resultsGrid').style.display = 'block';

    // Update heading
    document.getElementById('searchHeading').innerHTML =
        'Results for <span style="color:var(--wn-red);">"' + query + '"</span>';
    document.getElementById('searchMeta').style.display = 'none';

    // Count visible cards
    const cards = document.querySelectorAll('.wn-result-item');
    document.getElementById('resultsCount').textContent = cards.length;
}

/* ── Filter by type (All / Movies / Series) ── */
function setFilter(type, btn) {
    // Update active chip
    document.querySelectorAll('.wn-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');

    // Show/hide cards
    document.querySelectorAll('.wn-result-item').forEach(function(card) {
        if (type === 'all' || card.dataset.type === type) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });

    // Update count
    const visible = document.querySelectorAll('.wn-result-item:not([style*="display: none"])').length;
    document.getElementById('resultsCount').textContent = visible;
}

/* ── Sort results ── */
function sortResults(criterion) {
    const container = document.getElementById('cardsContainer');
    const cards = Array.from(container.querySelectorAll('.wn-result-item'));

    cards.sort(function(a, b) {
        if (criterion === 'title')   return a.dataset.title.localeCompare(b.dataset.title);
        if (criterion === 'rating')  return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        if (criterion === 'year')    return parseInt(b.dataset.year) - parseInt(a.dataset.year);
        return 0; // relevance — keep original order
    });

    cards.forEach(card => container.appendChild(card));
}
</script>
@endpush

@endsection