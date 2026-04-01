@extends('layouts.app')

@section('title', 'Movies — WolfNet')

@section('content')

{{-- ============================================================
     MOVIES PAGE — WolfNet
     Backend TODO:
       - Route: GET /movies → MovieController@index
       - Pass $movies (collection), $genres (array)
       - Each movie: id, title, year, genre, rating, poster_url, duration
     ============================================================ --}}

<div class="wn-movies-page">

    {{-- ── HERO ── --}}
    <div class="wn-movies-hero">
        <div class="wn-movies-hero-bg"></div>
        <div class="container wn-movies-hero-inner">
            <h1 class="wn-movies-hero-title">
                🎬 All <span class="wn-red-text">Movies</span>
            </h1>
            <p class="wn-movies-hero-sub">
                Discover the best movies — blockbusters, classics, and hidden gems.
            </p>
        </div>
    </div>

    {{-- ── FILTERS ── --}}
    <div class="container wn-movies-filters-wrap">
        <div class="wn-movies-filters">

            {{-- Genre chips --}}
            <div class="wn-genre-chips">
                <button class="wn-genre-chip active" onclick="filterGenre('all', this)">All</button>
                <button class="wn-genre-chip" onclick="filterGenre('action', this)">Action</button>
                <button class="wn-genre-chip" onclick="filterGenre('drama', this)">Drama</button>
                <button class="wn-genre-chip" onclick="filterGenre('scifi', this)">Sci-Fi</button>
                <button class="wn-genre-chip" onclick="filterGenre('crime', this)">Crime</button>
                <button class="wn-genre-chip" onclick="filterGenre('comedy', this)">Comedy</button>
                <button class="wn-genre-chip" onclick="filterGenre('thriller', this)">Thriller</button>
            </div>

            {{-- Sort --}}
            <div class="wn-fav-select-wrap">
                <select class="wn-fav-select" onchange="sortMovies(this.value)">
                    <option value="popular">Most Popular</option>
                    <option value="rating">Highest Rated</option>
                    <option value="year">Newest First</option>
                    <option value="title">Title A–Z</option>
                </select>
                <span class="wn-select-arrow">⌄</span>
            </div>

        </div>
    </div>

    {{-- ── MOVIES GRID ── --}}
    <div class="container wn-movies-container">

        <p class="wn-movies-count">
            Showing <span id="moviesCount">12</span> movies
        </p>

        <div class="wn-movies-grid" id="moviesGrid">

            {{-- TODO: replace with @foreach($movies as $movie) --}}
            @php
            $demoMovies = [
                ['id'=>1,'title'=>'Inception','year'=>2010,'genre'=>'scifi','rating'=>8.8,'duration'=>'2h 28min','color'=>'3b82f6'],
                ['id'=>2,'title'=>'The Dark Knight','year'=>2008,'genre'=>'action','rating'=>9.0,'duration'=>'2h 32min','color'=>'1c1c1c'],
                ['id'=>3,'title'=>'Interstellar','year'=>2014,'genre'=>'scifi','rating'=>8.6,'duration'=>'2h 49min','color'=>'7c3aed'],
                ['id'=>4,'title'=>'Pulp Fiction','year'=>1994,'genre'=>'crime','rating'=>8.9,'duration'=>'2h 34min','color'=>'b45309'],
                ['id'=>5,'title'=>'The Godfather','year'=>1972,'genre'=>'crime','rating'=>9.2,'duration'=>'2h 55min','color'=>'1f2937'],
                ['id'=>6,'title'=>'Forrest Gump','year'=>1994,'genre'=>'drama','rating'=>8.8,'duration'=>'2h 22min','color'=>'065f46'],
                ['id'=>7,'title'=>'The Matrix','year'=>1999,'genre'=>'action','rating'=>8.7,'duration'=>'2h 16min','color'=>'14532d'],
                ['id'=>8,'title'=>'Goodfellas','year'=>1990,'genre'=>'crime','rating'=>8.7,'duration'=>'2h 26min','color'=>'7f1d1d'],
                ['id'=>9,'title'=>'Fight Club','year'=>1999,'genre'=>'thriller','rating'=>8.8,'duration'=>'2h 19min','color'=>'713f12'],
                ['id'=>10,'title'=>'The Silence of the Lambs','year'=>1991,'genre'=>'thriller','rating'=>8.6,'duration'=>'1h 58min','color'=>'1e1b4b'],
                ['id'=>11,'title'=>'Amélie','year'=>2001,'genre'=>'comedy','rating'=>8.3,'duration'=>'2h 2min','color'=>'86198f'],
                ['id'=>12,'title'=>'Schindler\'s List','year'=>1993,'genre'=>'drama','rating'=>9.0,'duration'=>'3h 15min','color'=>'374151'],
            ];
            @endphp

            @foreach($demoMovies as $m)
            <div class="wn-movie-card"
                 data-genre="{{ $m['genre'] }}"
                 data-title="{{ $m['title'] }}"
                 data-rating="{{ $m['rating'] }}"
                 data-year="{{ $m['year'] }}">

                <div class="wn-movie-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/{{ $m['color'] }}/e50914?text={{ urlencode($m['title']) }}"
                         alt="{{ $m['title'] }}"
                         class="wn-movie-poster-img"
                         loading="lazy">

                    {{-- Overlay --}}
                    <div class="wn-movie-card-overlay">
                        <a href="{{ url('/movie/' . $m['id']) }}" class="wn-movie-play-btn">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                       <div class="wn-movie-card-btns">
    <a href="{{ url('/watch/' . $m['id']) }}" class="wn-movie-detail-btn"
       style="background:var(--wn-red);color:white;border:none;">
        <i class="bi bi-play-fill"></i> Watch
    </a>
    <a href="{{ url('/movie/' . $m['id']) }}" class="wn-movie-detail-btn">
        <i class="bi bi-info-circle"></i>
    </a>
    <button class="wn-movie-fav-btn" onclick="toggleFav(this, {{ $m['id'] }})" title="Add to Favorites">
        <i class="bi bi-heart"></i>
    </button>
</div>
                    </div>

                    {{-- Badges --}}
                    <div class="wn-movie-rating-badge">⭐ {{ $m['rating'] }}</div>
                    <div class="wn-movie-duration-badge">{{ $m['duration'] }}</div>
                </div>

                <div class="wn-movie-card-info">
                    <h3 class="wn-movie-card-title">{{ $m['title'] }}</h3>
                    <div class="wn-movie-card-meta">
                        <span>{{ $m['year'] }}</span>
                        <span class="wn-meta-dot">·</span>
                        <span>{{ ucfirst($m['genre']) }}</span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>{{-- /grid --}}

        {{-- No results --}}
        <div class="wn-movies-empty" id="moviesEmpty" style="display:none;">
            <div style="font-size:3rem;margin-bottom:16px;">😕</div>
            <h3 style="color:var(--wn-white);margin:0 0 8px;">No movies found</h3>
            <p style="color:#b0b0b0;">Try a different genre filter.</p>
        </div>

    </div>{{-- /container --}}
</div>{{-- /page --}}


@push('styles')
<style>
.wn-movies-page { min-height:100vh; background:var(--wn-dark); padding-bottom:80px; }

/* Hero */
.wn-movies-hero { position:relative; padding:110px 0 50px; text-align:center; overflow:hidden; }
.wn-movies-hero-bg { position:absolute; inset:0; background:radial-gradient(ellipse at 50% 0%, rgba(229,9,20,0.15) 0%, transparent 65%), linear-gradient(180deg,#0a0a0a 0%,var(--wn-dark) 100%); }
.wn-movies-hero-inner { position:relative; z-index:1; }
.wn-movies-hero-title { font-size:clamp(2rem,4vw,3.2rem); font-weight:800; color:var(--wn-white); letter-spacing:-0.03em; margin:0 0 14px; }
.wn-red-text { color:var(--wn-red); }
.wn-movies-hero-sub { color:#b0b0b0; font-size:1rem; max-width:480px; margin:0 auto; }

/* Filters */
.wn-movies-filters-wrap { padding:28px 0 8px; }
.wn-movies-filters { display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
.wn-genre-chips { display:flex; gap:8px; flex-wrap:wrap; }
.wn-genre-chip { background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-muted); padding:6px 16px; border-radius:20px; font-size:0.82rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
.wn-genre-chip:hover { border-color:var(--wn-red); color:var(--wn-text); }
.wn-genre-chip.active { background:var(--wn-red); border-color:var(--wn-red); color:white; }
.wn-fav-select-wrap { position:relative; }
.wn-fav-select { appearance:none; background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); padding:8px 36px 8px 14px; border-radius:6px; font-size:0.85rem; cursor:pointer; }
.wn-fav-select:focus { border-color:var(--wn-red); outline:none; }
.wn-select-arrow { position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--wn-muted); pointer-events:none; }

/* Container */
.wn-movies-container { padding-top:20px; }
.wn-movies-count { color:var(--wn-muted); font-size:0.85rem; margin-bottom:24px; }
.wn-movies-count span { color:var(--wn-white); font-weight:700; }

/* Grid */
.wn-movies-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:22px; }

/* Card */
.wn-movie-card { border-radius:10px; overflow:hidden; background:var(--wn-card); border:1px solid var(--wn-border); transition:transform 0.25s,box-shadow 0.25s,border-color 0.25s; animation:wn-fadein 0.4s ease both; }
.wn-movie-card:hover { transform:translateY(-7px); box-shadow:0 20px 45px rgba(0,0,0,0.6); border-color:var(--wn-red); }
.wn-movie-card:nth-child(1){animation-delay:.03s}.wn-movie-card:nth-child(2){animation-delay:.06s}.wn-movie-card:nth-child(3){animation-delay:.09s}.wn-movie-card:nth-child(4){animation-delay:.12s}.wn-movie-card:nth-child(5){animation-delay:.15s}.wn-movie-card:nth-child(6){animation-delay:.18s}.wn-movie-card:nth-child(7){animation-delay:.21s}.wn-movie-card:nth-child(8){animation-delay:.24s}.wn-movie-card:nth-child(9){animation-delay:.27s}.wn-movie-card:nth-child(10){animation-delay:.30s}.wn-movie-card:nth-child(11){animation-delay:.33s}.wn-movie-card:nth-child(12){animation-delay:.36s}

/* Poster */
.wn-movie-poster-wrap { position:relative; aspect-ratio:2/3; overflow:hidden; }
.wn-movie-poster-img { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s; }
.wn-movie-card:hover .wn-movie-poster-img { transform:scale(1.06); }

/* Overlay */
.wn-movie-card-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.65); display:flex; flex-direction:column; align-items:center; justify-content:center; gap:12px; opacity:0; transition:opacity 0.25s; }
.wn-movie-card:hover .wn-movie-card-overlay { opacity:1; }
.wn-movie-play-btn { background:var(--wn-red); color:white; border-radius:50%; width:52px; height:52px; display:flex; align-items:center; justify-content:center; text-decoration:none; transition:transform 0.2s,background 0.2s; }
.wn-movie-play-btn:hover { transform:scale(1.12); background:var(--wn-red-dark); color:white; }
.wn-movie-card-btns { display:flex; gap:8px; align-items:center; }
.wn-movie-detail-btn { background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:white; border-radius:20px; padding:5px 14px; font-size:0.75rem; font-weight:600; text-decoration:none; transition:background 0.2s; display:flex; align-items:center; gap:5px; }
.wn-movie-detail-btn:hover { background:rgba(255,255,255,0.25); color:white; }
.wn-movie-fav-btn { background:rgba(229,9,20,0.2); border:1px solid rgba(229,9,20,0.4); color:#ff6b6b; border-radius:50%; width:34px; height:34px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.2s; font-size:0.85rem; }
.wn-movie-fav-btn:hover,.wn-movie-fav-btn.active { background:var(--wn-red); border-color:var(--wn-red); color:white; }

/* Badges */
.wn-movie-rating-badge { position:absolute; bottom:8px; left:8px; background:rgba(0,0,0,0.85); color:#f5c518; font-size:0.72rem; font-weight:700; padding:3px 8px; border-radius:4px; }
.wn-movie-duration-badge { position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.75); color:#b0b0b0; font-size:0.65rem; font-weight:700; padding:3px 8px; border-radius:4px; }

/* Info */
.wn-movie-card-info { padding:12px 14px; }
.wn-movie-card-title { font-size:0.88rem; font-weight:700; color:var(--wn-white); margin:0 0 5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.wn-movie-card-meta { font-size:0.76rem; color:var(--wn-muted); }
.wn-meta-dot { margin:0 5px; }

/* Hidden */
.wn-movie-card.hidden { display:none; }

/* Empty */
.wn-movies-empty { text-align:center; padding:60px 20px; }

@keyframes wn-fadein { from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)} }

@media(max-width:768px) { .wn-movies-filters{flex-direction:column;align-items:flex-start} .wn-movies-grid{grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:14px} }
@media(max-width:480px) { .wn-movies-grid{grid-template-columns:repeat(2,1fr)} }
</style>
@endpush


@push('scripts')
<script>
function filterGenre(genre, btn) {
    document.querySelectorAll('.wn-genre-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    let visible = 0;
    document.querySelectorAll('.wn-movie-card').forEach(function(card) {
        if (genre === 'all' || card.dataset.genre === genre) {
            card.classList.remove('hidden');
            visible++;
        } else {
            card.classList.add('hidden');
        }
    });
    document.getElementById('moviesCount').textContent = visible;
    document.getElementById('moviesEmpty').style.display = visible === 0 ? 'block' : 'none';
}

function sortMovies(criterion) {
    const grid = document.getElementById('moviesGrid');
    const cards = Array.from(grid.querySelectorAll('.wn-movie-card'));
    cards.sort(function(a, b) {
        if (criterion === 'title')  return a.dataset.title.localeCompare(b.dataset.title);
        if (criterion === 'rating') return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        if (criterion === 'year')   return parseInt(b.dataset.year) - parseInt(a.dataset.year);
        return 0;
    });
    cards.forEach(card => grid.appendChild(card));
}

function toggleFav(btn, id) {
    btn.classList.toggle('active');
    btn.innerHTML = btn.classList.contains('active')
        ? '<i class="bi bi-heart-fill"></i>'
        : '<i class="bi bi-heart"></i>';
    // TODO: Backend → POST /favorites/add with movie_id = id
}
</script>
@endpush

@endsection