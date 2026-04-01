@extends('layouts.app')

@section('title', 'Series — WolfNet')

@section('content')

{{-- ============================================================
     SERIES PAGE — WolfNet
     Backend TODO:
       - Route: GET /series → SeriesController@index
       - Pass $series (collection), $genres (array)
       - Each series: id, title, year, genre, rating, poster_url,
         seasons, episodes
     ============================================================ --}}

<div class="wn-series-page">

    {{-- ── HERO ── --}}
    <div class="wn-series-hero">
        <div class="wn-series-hero-bg"></div>
        <div class="container wn-series-hero-inner">
            <h1 class="wn-series-hero-title">
                📺 Popular <span class="wn-red-text">Series</span>
            </h1>
            <p class="wn-series-hero-sub">
                Binge-watch the best series — dramas, thrillers, comedies and more.
            </p>
        </div>
    </div>

    {{-- ── FILTERS ── --}}
    <div class="container wn-series-filters-wrap">
        <div class="wn-series-filters">

            {{-- Genre chips --}}
            <div class="wn-genre-chips">
                <button class="wn-genre-chip active" onclick="filterGenre('all', this)">All</button>
                <button class="wn-genre-chip" onclick="filterGenre('drama', this)">Drama</button>
                <button class="wn-genre-chip" onclick="filterGenre('crime', this)">Crime</button>
                <button class="wn-genre-chip" onclick="filterGenre('comedy', this)">Comedy</button>
                <button class="wn-genre-chip" onclick="filterGenre('thriller', this)">Thriller</button>
                <button class="wn-genre-chip" onclick="filterGenre('scifi', this)">Sci-Fi</button>
                <button class="wn-genre-chip" onclick="filterGenre('action', this)">Action</button>
            </div>

            {{-- Sort --}}
            <div class="wn-fav-select-wrap">
                <select class="wn-fav-select" onchange="sortSeries(this.value)">
                    <option value="popular">Most Popular</option>
                    <option value="rating">Highest Rated</option>
                    <option value="year">Newest First</option>
                    <option value="title">Title A–Z</option>
                </select>
                <span class="wn-select-arrow">⌄</span>
            </div>

        </div>
    </div>

    {{-- ── SERIES GRID ── --}}
    <div class="container wn-series-container">

        {{-- Results count --}}
        <p class="wn-series-count">
            Showing <span id="seriesCount">12</span> series
        </p>

        <div class="wn-series-grid" id="seriesGrid">

            {{-- TODO: replace with @foreach($series as $s) --}}
            @php
            $demoSeries = [
                ['id'=>1,'title'=>'Breaking Bad','year'=>2008,'genre'=>'crime','rating'=>9.5,'seasons'=>5,'episodes'=>62,'color'=>'#22c55e'],
                ['id'=>2,'title'=>'Game of Thrones','year'=>2011,'genre'=>'drama','rating'=>9.2,'seasons'=>8,'episodes'=>73,'color'=>'#3b82f6'],
                ['id'=>3,'title'=>'The Office','year'=>2005,'genre'=>'comedy','rating'=>8.9,'seasons'=>9,'episodes'=>201,'color'=>'#f59e0b'],
                ['id'=>4,'title'=>'Stranger Things','year'=>2016,'genre'=>'scifi','rating'=>8.7,'seasons'=>4,'episodes'=>34,'color'=>'#8b5cf6'],
                ['id'=>5,'title'=>'Dark','year'=>2017,'genre'=>'thriller','rating'=>8.8,'seasons'=>3,'episodes'=>26,'color'=>'#e50914'],
                ['id'=>6,'title'=>'Money Heist','year'=>2017,'genre'=>'crime','rating'=>8.3,'seasons'=>5,'episodes'=>41,'color'=>'#ef4444'],
                ['id'=>7,'title'=>'Sherlock','year'=>2010,'genre'=>'drama','rating'=>9.1,'seasons'=>4,'episodes'=>13,'color'=>'#0ea5e9'],
                ['id'=>8,'title'=>'Black Mirror','year'=>2011,'genre'=>'scifi','rating'=>8.8,'seasons'=>6,'episodes'=>27,'color'=>'#6366f1'],
                ['id'=>9,'title'=>'Peaky Blinders','year'=>2013,'genre'=>'crime','rating'=>8.8,'seasons'=>6,'episodes'=>36,'color'=>'#b45309'],
                ['id'=>10,'title'=>'The Crown','year'=>2016,'genre'=>'drama','rating'=>8.6,'seasons'=>6,'episodes'=>60,'color'=>'#7c3aed'],
                ['id'=>11,'title'=>'Squid Game','year'=>2021,'genre'=>'thriller','rating'=>8.0,'seasons'=>2,'episodes'=>18,'color'=>'#ec4899'],
                ['id'=>12,'title'=>'Friends','year'=>1994,'genre'=>'comedy','rating'=>8.9,'seasons'=>10,'episodes'=>236,'color'=>'#f59e0b'],
            ];
            @endphp

            @foreach($demoSeries as $s)
            <div class="wn-series-card"
                 data-genre="{{ $s['genre'] }}"
                 data-title="{{ $s['title'] }}"
                 data-rating="{{ $s['rating'] }}"
                 data-year="{{ $s['year'] }}">
                <div class="wn-series-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/{{ ltrim($s['color'], '#') }}?text={{ urlencode($s['title']) }}"
                         alt="{{ $s['title'] }}"
                         class="wn-series-poster"
                         loading="lazy">

                    {{-- Overlay --}}
                    <div class="wn-series-overlay">
    <a href="{{ url('/watch/' . $s['id']) }}" class="wn-series-play-btn">
        <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M8 5v14l11-7z"/></svg>
    </a>
    <a href="{{ url('/movie/' . $s['id']) }}" class="wn-series-add-btn"
       title="Details" style="text-decoration:none;color:white;">
        <i class="bi bi-info-circle"></i>
    </a>
    <button class="wn-series-add-btn" onclick="addToWatchlist({{ $s['id'] }}, this)" title="Add to Watchlist">
        <i class="bi bi-bookmark-plus"></i>
    </button>
</div>

                    {{-- Rating badge --}}
                    <div class="wn-series-rating-badge">⭐ {{ $s['rating'] }}</div>

                    {{-- Seasons badge --}}
                    <div class="wn-series-seasons-badge">{{ $s['seasons'] }}S · {{ $s['episodes'] }}EP</div>
                </div>

                <div class="wn-series-info">
                    <h3 class="wn-series-title-text">{{ $s['title'] }}</h3>
                    <div class="wn-series-meta">
                        <span>{{ $s['year'] }}</span>
                        <span class="wn-meta-dot">·</span>
                        <span class="wn-series-genre-tag">{{ ucfirst($s['genre']) }}</span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>{{-- /grid --}}

        {{-- No results --}}
        <div class="wn-series-empty" id="seriesEmpty" style="display:none;">
            <div style="font-size:3rem;margin-bottom:16px;">😕</div>
            <h3 style="color:var(--wn-white);margin:0 0 8px;">No series found</h3>
            <p style="color:#b0b0b0;">Try a different genre filter.</p>
        </div>

    </div>{{-- /container --}}
</div>{{-- /page --}}


@push('styles')
<style>
.wn-series-page { min-height:100vh; background:var(--wn-dark); padding-bottom:80px; }

/* Hero */
.wn-series-hero { position:relative; padding:110px 0 50px; text-align:center; overflow:hidden; }
.wn-series-hero-bg { position:absolute; inset:0; background:radial-gradient(ellipse at 50% 0%, rgba(229,9,20,0.15) 0%, transparent 65%), linear-gradient(180deg,#0a0a0a 0%,var(--wn-dark) 100%); }
.wn-series-hero-inner { position:relative; z-index:1; }
.wn-series-hero-title { font-size:clamp(2rem,4vw,3.2rem); font-weight:800; color:var(--wn-white); letter-spacing:-0.03em; margin:0 0 14px; }
.wn-red-text { color:var(--wn-red); }
.wn-series-hero-sub { color:#b0b0b0; font-size:1rem; margin:0; max-width:480px; margin:0 auto; }

/* Filters */
.wn-series-filters-wrap { padding:28px 0 8px; }
.wn-series-filters { display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
.wn-genre-chips { display:flex; gap:8px; flex-wrap:wrap; }
.wn-genre-chip { background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-muted); padding:6px 16px; border-radius:20px; font-size:0.82rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
.wn-genre-chip:hover { border-color:var(--wn-red); color:var(--wn-text); }
.wn-genre-chip.active { background:var(--wn-red); border-color:var(--wn-red); color:white; }
.wn-fav-select-wrap { position:relative; }
.wn-fav-select { appearance:none; background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); padding:8px 36px 8px 14px; border-radius:6px; font-size:0.85rem; cursor:pointer; }
.wn-fav-select:focus { border-color:var(--wn-red); outline:none; }
.wn-select-arrow { position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--wn-muted); pointer-events:none; }

/* Container */
.wn-series-container { padding-top:20px; }
.wn-series-count { color:var(--wn-muted); font-size:0.85rem; margin-bottom:24px; }
.wn-series-count span { color:var(--wn-white); font-weight:700; }

/* Grid */
.wn-series-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:22px; }

/* Card */
.wn-series-card { border-radius:10px; overflow:hidden; background:var(--wn-card); border:1px solid var(--wn-border); transition:transform 0.25s,box-shadow 0.25s,border-color 0.25s; animation:wn-fadein 0.4s ease both; cursor:pointer; }
.wn-series-card:hover { transform:translateY(-7px); box-shadow:0 20px 45px rgba(0,0,0,0.6); border-color:var(--wn-red); }
.wn-series-card:nth-child(1){animation-delay:.03s}.wn-series-card:nth-child(2){animation-delay:.06s}.wn-series-card:nth-child(3){animation-delay:.09s}.wn-series-card:nth-child(4){animation-delay:.12s}.wn-series-card:nth-child(5){animation-delay:.15s}.wn-series-card:nth-child(6){animation-delay:.18s}.wn-series-card:nth-child(7){animation-delay:.21s}.wn-series-card:nth-child(8){animation-delay:.24s}.wn-series-card:nth-child(9){animation-delay:.27s}.wn-series-card:nth-child(10){animation-delay:.30s}.wn-series-card:nth-child(11){animation-delay:.33s}.wn-series-card:nth-child(12){animation-delay:.36s}

/* Poster */
.wn-series-poster-wrap { position:relative; aspect-ratio:2/3; overflow:hidden; }
.wn-series-poster { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s; }
.wn-series-card:hover .wn-series-poster { transform:scale(1.06); }

/* Overlay */
.wn-series-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.6); display:flex; align-items:center; justify-content:center; gap:14px; opacity:0; transition:opacity 0.25s; }
.wn-series-card:hover .wn-series-overlay { opacity:1; }
.wn-series-play-btn { background:var(--wn-red); color:white; border-radius:50%; width:52px; height:52px; display:flex; align-items:center; justify-content:center; text-decoration:none; transition:transform 0.2s,background 0.2s; }
.wn-series-play-btn:hover { transform:scale(1.12); background:var(--wn-red-dark); color:white; }
.wn-series-add-btn { background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; border-radius:50%; width:38px; height:38px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background 0.2s; font-size:0.95rem; }
.wn-series-add-btn:hover { background:rgba(255,255,255,0.25); }
.wn-series-add-btn.added { background:var(--wn-red); border-color:var(--wn-red); }

/* Badges */
.wn-series-rating-badge { position:absolute; bottom:8px; left:8px; background:rgba(0,0,0,0.85); color:#f5c518; font-size:0.72rem; font-weight:700; padding:3px 8px; border-radius:4px; }
.wn-series-seasons-badge { position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.75); color:#b0b0b0; font-size:0.65rem; font-weight:700; padding:3px 8px; border-radius:4px; }

/* Info */
.wn-series-info { padding:12px 14px; }
.wn-series-title-text { font-size:0.88rem; font-weight:700; color:var(--wn-white); margin:0 0 5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.wn-series-meta { font-size:0.76rem; color:var(--wn-muted); }
.wn-meta-dot { margin:0 5px; }
.wn-series-genre-tag { color:#b0b0b0; }

/* Empty */
.wn-series-empty { text-align:center; padding:60px 20px; }

/* Hidden card */
.wn-series-card.hidden { display:none; }

@keyframes wn-fadein { from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)} }

@media(max-width:768px) { .wn-series-filters{flex-direction:column;align-items:flex-start} .wn-series-grid{grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:14px} }
@media(max-width:480px) { .wn-series-grid{grid-template-columns:repeat(2,1fr)} }
</style>
@endpush


@push('scripts')
<script>
/* ── Filter by genre ── */
function filterGenre(genre, btn) {
    document.querySelectorAll('.wn-genre-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');

    let visible = 0;
    document.querySelectorAll('.wn-series-card').forEach(function(card) {
        if (genre === 'all' || card.dataset.genre === genre) {
            card.classList.remove('hidden');
            visible++;
        } else {
            card.classList.add('hidden');
        }
    });

    document.getElementById('seriesCount').textContent = visible;
    document.getElementById('seriesEmpty').style.display = visible === 0 ? 'block' : 'none';
}

/* ── Sort series ── */
function sortSeries(criterion) {
    const grid = document.getElementById('seriesGrid');
    const cards = Array.from(grid.querySelectorAll('.wn-series-card'));
    cards.sort(function(a, b) {
        if (criterion === 'title')  return a.dataset.title.localeCompare(b.dataset.title);
        if (criterion === 'rating') return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        if (criterion === 'year')   return parseInt(b.dataset.year) - parseInt(a.dataset.year);
        return 0;
    });
    cards.forEach(card => grid.appendChild(card));
}

/* ── Add to watchlist ── */
function addToWatchlist(id, btn) {
    btn.classList.toggle('added');
    if (btn.classList.contains('added')) {
        btn.innerHTML = '<i class="bi bi-bookmark-check-fill"></i>';
        btn.title = 'Added to Watchlist';
    } else {
        btn.innerHTML = '<i class="bi bi-bookmark-plus"></i>';
        btn.title = 'Add to Watchlist';
    }
    // TODO: Backend → POST /watchlist/add with series_id = id
}
</script>
@endpush

@endsection