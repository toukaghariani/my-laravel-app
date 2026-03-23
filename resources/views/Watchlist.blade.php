@extends('layouts.app')

@section('title', 'My Watchlist — WolfNet')

@section('content')

{{-- ============================================================
     WATCHLIST PAGE — WolfNet
     Backend TODO:
       - Route: GET /watchlist → WatchlistController@index
       - Pass $watchlist (collection of movie objects)
       - Each movie: id, title, year, genre, rating, poster_url, type
     ============================================================ --}}

<div class="wn-watchlist-page">

    {{-- ── HEADER ── --}}
    <div class="wn-wl-header">
        <div class="container">
            <div class="wn-wl-header-inner">
                <div>
                    <h1 class="wn-wl-title">
                        <span class="wn-wl-icon">🔖</span> My Watchlist
                    </h1>
                    <p class="wn-wl-subtitle">
                        <span class="wn-wl-count" id="wlCount">0</span> titles queued up
                    </p>
                </div>
                <div class="wn-fav-controls">
                    <div class="wn-fav-select-wrap">
                        <select class="wn-fav-select" onchange="sortWatchlist(this.value)">
                            <option value="added">Recently Added</option>
                            <option value="title">Title A–Z</option>
                            <option value="rating">Highest Rated</option>
                            <option value="year">Newest First</option>
                        </select>
                        <span class="wn-select-arrow">⌄</span>
                    </div>
                    <div class="wn-view-toggle">
                        <button class="wn-view-btn active" id="btnGrid" onclick="setView('grid')" title="Grid view">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <rect x="0" y="0" width="7" height="7"/><rect x="9" y="0" width="7" height="7"/>
                                <rect x="0" y="9" width="7" height="7"/><rect x="9" y="9" width="7" height="7"/>
                            </svg>
                        </button>
                        <button class="wn-view-btn" id="btnList" onclick="setView('list')" title="List view">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <rect x="0" y="1" width="16" height="2"/><rect x="0" y="7" width="16" height="2"/>
                                <rect x="0" y="13" width="16" height="2"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MAIN ── --}}
    <div class="container wn-wl-container">

        {{-- ── EMPTY STATE ── --}}
        <div class="wn-wl-empty" id="emptyState" style="display:none;">
            <div class="wn-wl-empty-icon">🔖</div>
            <h2 class="wn-empty-title">Your watchlist is empty</h2>
            <p class="wn-empty-text">Browse movies and series and add them here to watch later.</p>
            <a href="{{ url('/') }}" class="wn-browse-btn">Browse Movies</a>
        </div>

        {{-- ── WATCHLIST GRID ── --}}
        <div class="wn-wl-grid" id="wlGrid">

            {{-- DEMO CARDS — replace with @foreach($watchlist as $movie) --}}

            {{-- Card 1 --}}
            <div class="wn-wl-card" data-id="1" data-title="The Dark Knight" data-rating="9.0" data-year="2008" data-added="1">
                <div class="wn-wl-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=DARK+KNIGHT"
                         alt="The Dark Knight" class="wn-wl-poster" loading="lazy">
                    <div class="wn-wl-overlay">
                        <a href="{{ url('/movie/2') }}" class="wn-overlay-play">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <button class="wn-wl-remove-btn" onclick="removeFromWatchlist(this, 1)" title="Remove">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </button>
                    <div class="wn-wl-badge">⭐ 9.0</div>
                    <div class="wn-wl-type-badge wn-type-movie">🎬 Movie</div>
                </div>
                <div class="wn-wl-info">
                    <h3 class="wn-wl-card-title">The Dark Knight</h3>
                    <div class="wn-wl-meta">
                        <span>2008</span><span class="wn-meta-dot">·</span><span>Action</span>
                    </div>
                    <div class="wn-wl-actions">
                        <a href="{{ url('/movie/2') }}" class="wn-wl-action-btn wn-wl-watch">▶ Watch</a>
                        <button class="wn-wl-action-btn wn-wl-remove" onclick="removeFromWatchlist(this, 1)">✕ Remove</button>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="wn-wl-card" data-id="2" data-title="Breaking Bad" data-rating="9.5" data-year="2008" data-added="2">
                <div class="wn-wl-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=BREAKING+BAD"
                         alt="Breaking Bad" class="wn-wl-poster" loading="lazy">
                    <div class="wn-wl-overlay">
                        <a href="{{ url('/movie/4') }}" class="wn-overlay-play">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <button class="wn-wl-remove-btn" onclick="removeFromWatchlist(this, 2)" title="Remove">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </button>
                    <div class="wn-wl-badge">⭐ 9.5</div>
                    <div class="wn-wl-type-badge wn-type-series">📺 Series</div>
                </div>
                <div class="wn-wl-info">
                    <h3 class="wn-wl-card-title">Breaking Bad</h3>
                    <div class="wn-wl-meta">
                        <span>2008</span><span class="wn-meta-dot">·</span><span>Crime</span>
                    </div>
                    <div class="wn-wl-actions">
                        <a href="{{ url('/movie/4') }}" class="wn-wl-action-btn wn-wl-watch">▶ Watch</a>
                        <button class="wn-wl-action-btn wn-wl-remove" onclick="removeFromWatchlist(this, 2)">✕ Remove</button>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="wn-wl-card" data-id="3" data-title="Interstellar" data-rating="8.6" data-year="2014" data-added="3">
                <div class="wn-wl-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=INTERSTELLAR"
                         alt="Interstellar" class="wn-wl-poster" loading="lazy">
                    <div class="wn-wl-overlay">
                        <a href="{{ url('/movie/3') }}" class="wn-overlay-play">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <button class="wn-wl-remove-btn" onclick="removeFromWatchlist(this, 3)" title="Remove">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </button>
                    <div class="wn-wl-badge">⭐ 8.6</div>
                    <div class="wn-wl-type-badge wn-type-movie">🎬 Movie</div>
                </div>
                <div class="wn-wl-info">
                    <h3 class="wn-wl-card-title">Interstellar</h3>
                    <div class="wn-wl-meta">
                        <span>2014</span><span class="wn-meta-dot">·</span><span>Sci-Fi</span>
                    </div>
                    <div class="wn-wl-actions">
                        <a href="{{ url('/movie/3') }}" class="wn-wl-action-btn wn-wl-watch">▶ Watch</a>
                        <button class="wn-wl-action-btn wn-wl-remove" onclick="removeFromWatchlist(this, 3)">✕ Remove</button>
                    </div>
                </div>
            </div>

            {{-- Card 4 --}}
            <div class="wn-wl-card" data-id="4" data-title="Inception" data-rating="8.8" data-year="2010" data-added="4">
                <div class="wn-wl-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=INCEPTION"
                         alt="Inception" class="wn-wl-poster" loading="lazy">
                    <div class="wn-wl-overlay">
                        <a href="{{ url('/movie/1') }}" class="wn-overlay-play">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <button class="wn-wl-remove-btn" onclick="removeFromWatchlist(this, 4)" title="Remove">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </button>
                    <div class="wn-wl-badge">⭐ 8.8</div>
                    <div class="wn-wl-type-badge wn-type-movie">🎬 Movie</div>
                </div>
                <div class="wn-wl-info">
                    <h3 class="wn-wl-card-title">Inception</h3>
                    <div class="wn-wl-meta">
                        <span>2010</span><span class="wn-meta-dot">·</span><span>Sci-Fi</span>
                    </div>
                    <div class="wn-wl-actions">
                        <a href="{{ url('/movie/1') }}" class="wn-wl-action-btn wn-wl-watch">▶ Watch</a>
                        <button class="wn-wl-action-btn wn-wl-remove" onclick="removeFromWatchlist(this, 4)">✕ Remove</button>
                    </div>
                </div>
            </div>

        </div>{{-- /wlGrid --}}
    </div>{{-- /container --}}
</div>{{-- /page --}}


@push('styles')
<style>
.wn-watchlist-page { min-height:100vh; background:var(--wn-dark); padding-bottom:80px; }

/* Header */
.wn-wl-header { background:linear-gradient(180deg,#0a0a0a 0%,var(--wn-dark) 100%); border-bottom:1px solid var(--wn-border); padding:100px 0 28px; }
.wn-wl-header-inner { display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:20px; }
.wn-wl-title { font-size:clamp(1.6rem,3vw,2.4rem); font-weight:700; color:var(--wn-white); letter-spacing:-0.02em; margin:0 0 6px; }
.wn-wl-icon { margin-right:8px; }
.wn-wl-subtitle { color:var(--wn-muted); font-size:0.9rem; margin:0; }
.wn-wl-count { color:var(--wn-text); font-weight:600; }

/* Controls */
.wn-fav-controls { display:flex; align-items:center; gap:12px; }
.wn-fav-select-wrap { position:relative; }
.wn-fav-select { appearance:none; background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); padding:8px 36px 8px 14px; border-radius:6px; font-size:0.85rem; cursor:pointer; transition:border-color 0.2s; }
.wn-fav-select:hover,.wn-fav-select:focus { border-color:var(--wn-red); outline:none; }
.wn-select-arrow { position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--wn-muted); pointer-events:none; }
.wn-view-toggle { display:flex; gap:4px; background:var(--wn-card); border:1px solid var(--wn-border); border-radius:6px; padding:4px; }
.wn-view-btn { background:transparent; border:none; color:var(--wn-muted); padding:6px 8px; border-radius:4px; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background 0.2s,color 0.2s; }
.wn-view-btn:hover { color:var(--wn-text); }
.wn-view-btn.active { background:var(--wn-red); color:var(--wn-white); }

/* Container */
.wn-wl-container { padding-top:36px; }

/* Empty state */
.wn-wl-empty { text-align:center; padding:80px 20px; animation:wn-fadein 0.4s ease; }
.wn-wl-empty-icon { font-size:4rem; margin-bottom:20px; }
.wn-empty-title { color:var(--wn-white); font-size:1.5rem; margin:0 0 12px; }
.wn-empty-text { color:#b0b0b0; font-size:0.95rem; margin:0 0 28px; }
.wn-browse-btn { display:inline-block; padding:12px 32px; background:var(--wn-red); color:var(--wn-white); border-radius:8px; text-decoration:none; font-weight:700; transition:opacity 0.2s,transform 0.15s; }
.wn-browse-btn:hover { opacity:0.85; transform:translateY(-2px); color:var(--wn-white); }

/* Grid */
.wn-wl-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:24px; }

/* Card */
.wn-wl-card { background:var(--wn-card); border-radius:10px; overflow:hidden; border:1px solid var(--wn-border); transition:transform 0.25s ease,box-shadow 0.25s ease,border-color 0.25s ease; animation:wn-fadein 0.35s ease both; }
.wn-wl-card:hover { transform:translateY(-6px); box-shadow:0 16px 40px rgba(0,0,0,0.6); border-color:var(--wn-red); }
.wn-wl-card:nth-child(1){animation-delay:0.04s}
.wn-wl-card:nth-child(2){animation-delay:0.08s}
.wn-wl-card:nth-child(3){animation-delay:0.12s}
.wn-wl-card:nth-child(4){animation-delay:0.16s}
.wn-wl-card:nth-child(5){animation-delay:0.20s}
.wn-wl-card:nth-child(6){animation-delay:0.24s}

/* Poster */
.wn-wl-poster-wrap { position:relative; aspect-ratio:2/3; overflow:hidden; }
.wn-wl-poster { width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s ease; }
.wn-wl-card:hover .wn-wl-poster { transform:scale(1.06); }

/* Overlay */
.wn-wl-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.55); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity 0.25s; }
.wn-wl-card:hover .wn-wl-overlay { opacity:1; }
.wn-overlay-play { color:var(--wn-white); background:var(--wn-red); border-radius:50%; width:54px; height:54px; display:flex; align-items:center; justify-content:center; transition:transform 0.2s,background 0.2s; text-decoration:none; }
.wn-overlay-play:hover { background:var(--wn-red-dark); transform:scale(1.1); color:var(--wn-white); }

/* Remove btn */
.wn-wl-remove-btn { position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.75); border:none; color:var(--wn-muted); border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; cursor:pointer; opacity:0; transition:opacity 0.2s,color 0.2s,background 0.2s; z-index:2; }
.wn-wl-card:hover .wn-wl-remove-btn { opacity:1; }
.wn-wl-remove-btn:hover { background:var(--wn-red); color:var(--wn-white); }

/* Badges */
.wn-wl-badge { position:absolute; bottom:8px; left:8px; background:rgba(0,0,0,0.8); color:#f5c518; font-size:0.75rem; font-weight:700; padding:3px 8px; border-radius:4px; }
.wn-wl-type-badge { position:absolute; top:8px; left:8px; font-size:0.68rem; font-weight:700; padding:3px 8px; border-radius:4px; }
.wn-type-movie { background:rgba(229,9,20,0.85); color:#fff; }
.wn-type-series { background:rgba(59,130,246,0.85); color:#fff; }

/* Info */
.wn-wl-info { padding:14px; }
.wn-wl-card-title { font-size:0.9rem; font-weight:600; color:var(--wn-white); margin:0 0 6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.wn-wl-meta { font-size:0.78rem; color:var(--wn-muted); margin:0 0 12px; }
.wn-meta-dot { margin:0 5px; }
.wn-wl-actions { display:flex; gap:8px; }
.wn-wl-action-btn { flex:1; border:none; border-radius:5px; font-size:0.75rem; font-weight:600; padding:7px 6px; cursor:pointer; text-align:center; text-decoration:none; transition:opacity 0.2s,transform 0.15s; display:inline-flex; align-items:center; justify-content:center; gap:4px; }
.wn-wl-action-btn:hover { opacity:0.85; transform:translateY(-1px); }
.wn-wl-watch { background:var(--wn-red); color:var(--wn-white); }
.wn-wl-remove { background:var(--wn-border); color:var(--wn-muted); }
.wn-wl-remove:hover { background:#3a1010; color:#ff6b6b; }

/* List view */
.wn-wl-grid.list-view { grid-template-columns:1fr; gap:12px; }
.wn-wl-grid.list-view .wn-wl-card { display:flex; flex-direction:row; }
.wn-wl-grid.list-view .wn-wl-poster-wrap { width:90px; flex-shrink:0; aspect-ratio:unset; }
.wn-wl-grid.list-view .wn-wl-info { flex:1; display:flex; flex-direction:column; justify-content:center; padding:16px 20px; }
.wn-wl-grid.list-view .wn-wl-card-title { white-space:normal; font-size:1rem; }
.wn-wl-grid.list-view .wn-wl-actions { max-width:260px; }

/* Remove animation */
.wn-wl-card.removing { animation:wn-slideout 0.35s ease forwards; }

@keyframes wn-fadein { from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)} }
@keyframes wn-slideout { to{opacity:0;transform:scale(0.88)} }

@media(max-width:768px) { .wn-wl-header-inner{flex-direction:column;align-items:flex-start} .wn-wl-grid{grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:16px} }
@media(max-width:480px) { .wn-wl-grid{grid-template-columns:repeat(2,1fr)} }
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() { updateCount(); });

function updateCount() {
    const cards = document.querySelectorAll('#wlGrid .wn-wl-card');
    document.getElementById('wlCount').textContent = cards.length;
    document.getElementById('emptyState').style.display = cards.length === 0 ? 'block' : 'none';
}

function setView(view) {
    const grid = document.getElementById('wlGrid');
    const btnGrid = document.getElementById('btnGrid');
    const btnList = document.getElementById('btnList');
    if (view === 'list') {
        grid.classList.add('list-view');
        btnList.classList.add('active');
        btnGrid.classList.remove('active');
    } else {
        grid.classList.remove('list-view');
        btnGrid.classList.add('active');
        btnList.classList.remove('active');
    }
}

function sortWatchlist(criterion) {
    const grid = document.getElementById('wlGrid');
    const cards = Array.from(grid.querySelectorAll('.wn-wl-card'));
    cards.sort(function(a, b) {
        if (criterion === 'title')  return a.dataset.title.localeCompare(b.dataset.title);
        if (criterion === 'rating') return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        if (criterion === 'year')   return parseInt(b.dataset.year) - parseInt(a.dataset.year);
        return parseInt(a.dataset.added) - parseInt(b.dataset.added);
    });
    cards.forEach(card => grid.appendChild(card));
}

function removeFromWatchlist(btn, movieId) {
    const card = btn.closest('.wn-wl-card');
    if (!card) return;
    card.classList.add('removing');
    card.addEventListener('animationend', function() {
        card.remove();
        updateCount();
    }, { once: true });
    // TODO: Backend → POST /watchlist/remove with movie_id
    console.log('Remove from watchlist: movie_id =', movieId);
}
</script>
@endpush

@endsection