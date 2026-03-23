@extends('layouts.app')

@section('title', 'Movie Detail — WolfNet')

@section('content')

{{-- ============================================================
     MOVIE DETAIL PAGE — WolfNet
     USER3 + USER6: Movie detail + trailer streaming
     Backend TODO:
       - Route: GET /movie/{id}  → MovieController@show
       - Pass $movie object with: id, title, year, genre, rating,
         description, duration, director, cast[], poster_url,
         backdrop_url, trailer_url (YouTube embed URL)
       - Pass $related (collection of related movies)
     ============================================================ --}}

{{-- ── BACKDROP HERO ── --}}
<div class="wn-movie-backdrop" id="movieBackdrop">
    {{-- TODO: replace placeholder with $movie->backdrop_url --}}
    <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1920&q=80"
     alt="Movie backdrop"
     class="wn-backdrop-img"
     id="backdropImg">
    <div class="wn-backdrop-overlay"></div>
</div>

{{-- ── MAIN CONTENT ── --}}
<div class="wn-movie-page">
    <div class="container">
        <div class="wn-movie-layout">

            {{-- ── LEFT: POSTER ── --}}
            <div class="wn-movie-poster-col">
                <div class="wn-movie-poster-wrap">
                    {{-- TODO: replace with <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}"> --}}
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=MOVIE"
                         alt="Movie Poster"
                         class="wn-movie-poster"
                         id="moviePoster">
                    <div class="wn-poster-shine"></div>
                </div>
            </div>

            {{-- ── RIGHT: INFO ── --}}
            <div class="wn-movie-info-col">

                {{-- Breadcrumb --}}
                <nav class="wn-breadcrumb">
                    <a href="{{ url('/') }}" class="wn-breadcrumb-link">Home</a>
                    <span class="wn-breadcrumb-sep">›</span>
                    {{-- TODO: <a href="{{ url('/movies') }}" class="wn-breadcrumb-link">Movies</a> --}}
                    <a href="{{ url('/') }}" class="wn-breadcrumb-link">Movies</a>
                    <span class="wn-breadcrumb-sep">›</span>
                    {{-- TODO: <span class="wn-breadcrumb-current">{{ $movie->title }}</span> --}}
                    <span class="wn-breadcrumb-current" id="movieTitleBreadcrumb">Inception</span>
                </nav>

                {{-- Title --}}
                {{-- TODO: <h1 class="wn-movie-title">{{ $movie->title }}</h1> --}}
                <h1 class="wn-movie-title" id="movieTitle">Inception</h1>

                {{-- Meta row --}}
                <div class="wn-movie-meta-row">
                    {{-- TODO: {{ $movie->year }} --}}
                    <span class="wn-meta-chip">2010</span>
                    {{-- TODO: {{ $movie->duration }} --}}
                    <span class="wn-meta-chip">2h 28min</span>
                    {{-- TODO: {{ $movie->genre }} --}}
                    <span class="wn-meta-chip wn-chip-genre">Sci-Fi / Action</span>
                    {{-- TODO: {{ $movie->rating }} --}}
                    <span class="wn-meta-chip wn-chip-rating">
                        <i class="bi bi-star-fill"></i> 8.8
                    </span>
                </div>

                {{-- Description --}}
                {{-- TODO: <p class="wn-movie-desc">{{ $movie->description }}</p> --}}
                <p class="wn-movie-desc" id="movieDesc">
                    A thief who steals corporate secrets through the use of dream-sharing
                    technology is given the inverse task of planting an idea into the mind
                    of a C.E.O., but his tragic past may doom the project and his team to disaster.
                </p>

                {{-- Director + Cast --}}
                <div class="wn-movie-credits">
                    <div class="wn-credit-item">
                        <span class="wn-credit-label">Director</span>
                        {{-- TODO: <span class="wn-credit-value">{{ $movie->director }}</span> --}}
                        <span class="wn-credit-value">Christopher Nolan</span>
                    </div>
                    <div class="wn-credit-item">
                        <span class="wn-credit-label">Cast</span>
                        {{-- TODO: <span class="wn-credit-value">{{ implode(', ', $movie->cast) }}</span> --}}
                        <span class="wn-credit-value">Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page</span>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="wn-movie-actions">
                    {{-- Watch Trailer --}}
                    <button class="wn-btn-primary wn-action-btn" onclick="openTrailer()">
                        <i class="bi bi-play-fill"></i> Watch Trailer
                    </button>

                    {{-- Add to Favorites --}}
                    {{-- TODO: wire to POST /favorites/add with movie_id --}}
                    <button class="wn-action-btn wn-action-fav" id="favBtn" onclick="toggleFavorite()">
                        <i class="bi bi-heart" id="favIcon"></i>
                        <span id="favText">Add to Favorites</span>
                    </button>

                    {{-- Share --}}
                    <button class="wn-action-btn wn-action-share" onclick="shareMovie()">
                        <i class="bi bi-share"></i>
                    </button>
                </div>

                {{-- Premium badge --}}
                <div class="wn-premium-notice">
                    <i class="bi bi-shield-fill-check text-warning"></i>
                    <span>Full movie available for <a href="{{ url('/premium') }}" class="wn-premium-link">Premium members</a></span>
                </div>

            </div>{{-- /info col --}}
        </div>{{-- /layout --}}
    </div>{{-- /container --}}
</div>{{-- /movie page --}}


{{-- ── TRAILER MODAL ── --}}
<div class="wn-trailer-modal" id="trailerModal" style="display:none;" onclick="closeTrailerOnBackdrop(event)">
    <div class="wn-trailer-box">
        <button class="wn-trailer-close" onclick="closeTrailer()">&#10005;</button>
        <div class="wn-trailer-title-bar">
            <span id="trailerMovieTitle">Inception</span> — Official Trailer
        </div>
        <div class="wn-trailer-frame-wrap">
            {{-- TODO: replace with $movie->trailer_url (YouTube embed) --}}
            {{-- Example: https://www.youtube.com/embed/YoHD9XEInc0 --}}
            <iframe
                id="trailerFrame"
                src=""
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                class="wn-trailer-frame">
            </iframe>
        </div>
    </div>
</div>


{{-- ── RELATED MOVIES SECTION ── --}}
<div class="wn-related-section">
    <div class="container">
        <h2 class="wn-section-title">You Might Also Like</h2>
        <div class="row g-3">

            {{-- TODO: replace with @foreach($related as $movie) ... @endforeach --}}
            @for($i = 1; $i <= 6; $i++)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="{{ url('/movie/' . $i) }}" class="wn-related-card-link">
                    <div class="wn-card">
                        <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=Movie+{{ $i }}"
                             alt="Related Movie {{ $i }}"
                             loading="lazy">
                        <div class="wn-card-body">
                            <p class="wn-card-title">Related Movie {{ $i }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="wn-card-meta">2024</span>
                                <span class="wn-rating">
                                    <i class="bi bi-star-fill"></i> 7.{{ $i }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endfor

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     SCOPED CSS
════════════════════════════════════════════════════════ --}}
@push('styles')
<style>

/* ── Backdrop ── */
.wn-movie-backdrop {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100vh;
    z-index: 0;
    pointer-events: none;
    background-image: url('/images/cinema.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
.wn-backdrop-img {
    display: none;
}
.wn-backdrop-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(10,10,10,0.55) 0%,
        rgba(10,10,10,0.80) 40%,
        #141414 100%
    );
}

/* ── Movie page wrapper ── */
.wn-movie-page {
    position: relative;
    z-index: 1;
    padding-top: 110px;
    padding-bottom: 60px;
    min-height: 100vh;
}

/* ── Two-column layout ── */
.wn-movie-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 48px;
    align-items: start;
}

/* ── Poster ── */
.wn-movie-poster-col { position: sticky; top: 100px; }
.wn-movie-poster-wrap {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,0.7), 0 0 0 1px var(--wn-border);
}
.wn-movie-poster {
    width: 100%;
    display: block;
    aspect-ratio: 2/3;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.wn-movie-poster-wrap:hover .wn-movie-poster { transform: scale(1.03); }
.wn-poster-shine {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, transparent 60%);
    pointer-events: none;
}

/* ── Breadcrumb ── */
.wn-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 20px;
    font-size: 0.82rem;
    animation: wn-fadein 0.4s ease;
}
.wn-breadcrumb-link { color: var(--wn-muted); text-decoration: none; transition: color 0.2s; }
.wn-breadcrumb-link:hover { color: var(--wn-red); }
.wn-breadcrumb-sep { color: var(--wn-border); }
.wn-breadcrumb-current { color: var(--wn-text); }

/* ── Title ── */
.wn-movie-title {
    font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 800;
    color: var(--wn-white);
    letter-spacing: -0.03em;
    line-height: 1.1;
    margin: 0 0 20px;
    animation: wn-fadein 0.5s ease 0.05s both;
}

/* ── Meta chips ── */
.wn-movie-meta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 24px;
    animation: wn-fadein 0.5s ease 0.1s both;
}
.wn-meta-chip {
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    color: var(--wn-text);
    font-size: 0.8rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
}
.wn-chip-genre { border-color: rgba(229,9,20,0.4); color: #ff6b6b; background: rgba(229,9,20,0.08); }
.wn-chip-rating { border-color: rgba(245,197,24,0.4); color: #f5c518; background: rgba(245,197,24,0.08); }
.wn-chip-rating i { font-size: 0.7rem; margin-right: 3px; }

/* ── Description ── */
.wn-movie-desc {
    color: #b0b0b0;
    font-size: 0.97rem;
    line-height: 1.75;
    margin-bottom: 28px;
    max-width: 580px;
    animation: wn-fadein 0.5s ease 0.15s both;
}

/* ── Credits ── */
.wn-movie-credits {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 32px;
    animation: wn-fadein 0.5s ease 0.2s both;
}
.wn-credit-item { display: flex; gap: 12px; font-size: 0.88rem; }
.wn-credit-label {
    color: var(--wn-muted);
    font-weight: 600;
    min-width: 70px;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.06em;
    padding-top: 2px;
}
.wn-credit-value { color: var(--wn-text); }

/* ── Action buttons ── */
.wn-movie-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 24px;
    animation: wn-fadein 0.5s ease 0.25s both;
}
.wn-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    transition: opacity 0.2s, transform 0.15s;
    text-decoration: none;
}
.wn-action-btn:hover { opacity: 0.85; transform: translateY(-2px); }

.wn-action-fav {
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    color: var(--wn-text);
}
.wn-action-fav.active {
    border-color: var(--wn-red);
    color: var(--wn-red);
    background: rgba(229,9,20,0.08);
}
.wn-action-share {
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    color: var(--wn-muted);
    padding: 12px 16px;
}
.wn-action-share:hover { color: var(--wn-white); border-color: var(--wn-text); }

/* ── Premium notice ── */
.wn-premium-notice {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: var(--wn-muted);
    background: rgba(245,197,24,0.06);
    border: 1px solid rgba(245,197,24,0.15);
    border-radius: 8px;
    padding: 10px 16px;
    animation: wn-fadein 0.5s ease 0.3s both;
}
.wn-premium-link {
    color: #f5c518;
    text-decoration: none;
    font-weight: 600;
}
.wn-premium-link:hover { text-decoration: underline; }

/* ── Trailer modal ── */
.wn-trailer-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.92);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: wn-fadein 0.2s ease;
}
.wn-trailer-box {
    width: 100%;
    max-width: 900px;
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    border-radius: 14px;
    overflow: hidden;
    animation: wn-slideup 0.3s ease;
}
.wn-trailer-title-bar {
    padding: 14px 20px;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--wn-muted);
    border-bottom: 1px solid var(--wn-border);
}
.wn-trailer-frame-wrap {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}
.wn-trailer-frame {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    border: none;
}
.wn-trailer-close {
    position: absolute;
    top: 10px; right: 14px;
    background: rgba(0,0,0,0.6);
    border: none;
    color: var(--wn-muted);
    border-radius: 50%;
    width: 32px; height: 32px;
    cursor: pointer;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    transition: background 0.2s, color 0.2s;
}
.wn-trailer-close:hover { background: var(--wn-red); color: var(--wn-white); }

/* ── Related section ── */
.wn-related-section {
    position: relative;
    z-index: 1;
    background: var(--wn-dark);
    padding: 50px 0 80px;
    border-top: 1px solid var(--wn-border);
}
.wn-related-card-link { text-decoration: none; display: block; }

/* ── Keyframes ── */
@keyframes wn-fadein {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes wn-slideup {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .wn-movie-layout { grid-template-columns: 1fr; gap: 28px; }
    .wn-movie-poster-col { position: static; max-width: 200px; margin: 0 auto; }
    .wn-movie-info-col { text-align: center; }
    .wn-movie-meta-row { justify-content: center; }
    .wn-movie-actions { justify-content: center; }
    .wn-movie-credits { align-items: center; }
    .wn-premium-notice { justify-content: center; }
}
</style>
@endpush


{{-- ════════════════════════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════════════════════ --}}
@push('scripts')
<script>
/* ── Trailer URL
   TODO: Backend dev → replace this hardcoded URL with the real trailer from database
   Example YouTube embed: https://www.youtube.com/embed/YoHD9XEInc0
*/
var TRAILER_URL = 'https://www.youtube.com/embed/YoHD9XEInc0?autoplay=1';

/* ── Open trailer modal ── */
function openTrailer() {
    document.getElementById('trailerFrame').src = TRAILER_URL;
    document.getElementById('trailerModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

/* ── Close trailer modal ── */
function closeTrailer() {
    document.getElementById('trailerFrame').src = '';
    document.getElementById('trailerModal').style.display = 'none';
    document.body.style.overflow = '';
}

/* ── Close on backdrop click ── */
function closeTrailerOnBackdrop(e) {
    if (e.target === document.getElementById('trailerModal')) closeTrailer();
}

/* ── Close on ESC ── */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeTrailer();
});

/* ── Toggle favorite ──
   TODO: Backend dev → replace with AJAX POST to /favorites/add
   fetch('/favorites/add', {
       method: 'POST',
       headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                  'Content-Type': 'application/json' },
       body: JSON.stringify({ movie_id: MOVIE_ID })
   });
*/
var isFav = false;
function toggleFavorite() {
    isFav = !isFav;
    const btn  = document.getElementById('favBtn');
    const icon = document.getElementById('favIcon');
    const text = document.getElementById('favText');
    if (isFav) {
        btn.classList.add('active');
        icon.className = 'bi bi-heart-fill';
        text.textContent = 'Saved to Favorites';
    } else {
        btn.classList.remove('active');
        icon.className = 'bi bi-heart';
        text.textContent = 'Add to Favorites';
    }
}

/* ── Share ── */
function shareMovie() {
    if (navigator.share) {
        navigator.share({
            title: document.getElementById('movieTitle').textContent,
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Link copied to clipboard!');
        });
    }
}
</script>
@endpush

@endsection