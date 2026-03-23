@extends('layouts.app')

@section('title', 'My Favorites — WolfNet')

@section('content')

{{-- ============================================================
     FAVORITES PAGE — WolfNet
     USER5: Je veux ajouter favoris
     Backend TODO: pass $favorites (collection of movie objects)
     Each movie: id, title, year, genre, rating, poster_url
     ============================================================ --}}

<div class="wn-favorites-page">

    {{-- ── PAGE HEADER ── --}}
    <div class="wn-fav-header">
        <div class="container">
            <div class="wn-fav-header-inner">
                <div>
                    <h1 class="wn-fav-title">
                        <span class="wn-fav-icon">&#9825;</span>
                        My Favorites
                    </h1>
                    <p class="wn-fav-subtitle">
                        {{-- TODO: replace hardcoded count with $favorites->count() --}}
                        <span class="wn-fav-count" id="favCount">0</span> titles saved
                    </p>
                </div>

                {{-- ── SORT / FILTER BAR ── --}}
                <div class="wn-fav-controls">
                    <div class="wn-fav-select-wrap">
                        <select class="wn-fav-select" id="sortSelect" onchange="sortFavorites(this.value)">
                            <option value="added">Recently Added</option>
                            <option value="title">Title A–Z</option>
                            <option value="rating">Highest Rated</option>
                            <option value="year">Newest First</option>
                        </select>
                        <span class="wn-select-arrow">&#8964;</span>
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

    {{-- ── MAIN CONTENT ── --}}
    <div class="container wn-fav-container">

        {{-- ── SUCCESS / ERROR ALERTS ── --}}
        @if(session('success'))
            <div class="wn-alert-success wn-alert-dismissible mb-4" role="alert">
                <span>{{ session('success') }}</span>
                <button class="wn-alert-close" onclick="this.parentElement.remove()">&#10005;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="wn-alert-danger wn-alert-dismissible mb-4" role="alert">
                <span>{{ session('error') }}</span>
                <button class="wn-alert-close" onclick="this.parentElement.remove()">&#10005;</button>
            </div>
        @endif

        {{-- ══════════════════════════════════════════════════
             EMPTY STATE  (shown when $favorites is empty)
             TODO: replace the static demo block with:
             @if($favorites->isEmpty()) ... @else ... @endif
        ══════════════════════════════════════════════════ --}}

        {{-- EMPTY STATE — shown by JS when list is empty --}}
        <div class="wn-fav-empty" id="emptyState" style="display:none;">
            <div class="wn-empty-icon">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M40 68 L10 38 C4 32 4 22 10 16 C16 10 26 10 32 16 L40 24 L48 16 C54 10 64 10 70 16 C76 22 76 32 70 38 Z"
                          stroke="var(--wn-border)" stroke-width="3" fill="none" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="wn-empty-title">No favorites yet</h2>
            <p class="wn-empty-text">Start exploring WolfNet and hit the heart icon to save titles here.</p>
            <a href="{{ url('/') }}" class="wn-btn-primary wn-empty-cta">Browse Movies</a>
        </div>

        {{-- ══════════════════════════════════════════════════
             FAVORITES GRID / LIST
             TODO: backend — replace static demo cards with:
             @foreach($favorites as $movie)
               <div class="wn-fav-card"
                    data-id="{{ $movie->id }}"
                    data-title="{{ $movie->title }}"
                    data-rating="{{ $movie->rating }}"
                    data-year="{{ $movie->year }}">
                 ... card content ...
               </div>
             @endforeach
        ══════════════════════════════════════════════════ --}}

        <div class="wn-fav-grid" id="favGrid">

            {{-- ── DEMO CARDS (remove when backend sends real $favorites) ── --}}

            {{-- Card 1 --}}
            <div class="wn-fav-card" data-id="1" data-title="Inception" data-rating="8.8" data-year="2010" data-added="1">
                <div class="wn-fav-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=INCEPTION"
                         alt="Inception poster"
                         class="wn-fav-poster"
                         loading="lazy">
                    <div class="wn-fav-overlay">
                        <a href="{{ url('/movie/1') }}" class="wn-overlay-play" title="Watch now">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </a>
                    </div>
                    <button class="wn-fav-remove-btn"
                            onclick="removeFavorite(this, 1)"
                            title="Remove from favorites">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                    <div class="wn-fav-badge">&#9733; 8.8</div>
                </div>
                <div class="wn-fav-info">
                    <h3 class="wn-fav-card-title">Inception</h3>
                    <div class="wn-fav-meta">
                        <span>2010</span>
                        <span class="wn-meta-dot">·</span>
                        <span>Sci-Fi</span>
                    </div>
                    <div class="wn-fav-actions">
                        <a href="{{ url('/movie/1') }}" class="wn-fav-action-btn wn-fav-action-watch">
                            &#9654; Watch
                        </a>
                        {{-- TODO: wire to POST /favorites/remove --}}
                        <button class="wn-fav-action-btn wn-fav-action-remove"
                                onclick="removeFavorite(this, 1)">
                            &#10005; Remove
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="wn-fav-card" data-id="2" data-title="The Dark Knight" data-rating="9.0" data-year="2008" data-added="2">
                <div class="wn-fav-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=DARK+KNIGHT"
                         alt="The Dark Knight poster"
                         class="wn-fav-poster"
                         loading="lazy">
                    <div class="wn-fav-overlay">
                        <a href="{{ url('/movie/2') }}" class="wn-overlay-play" title="Watch now">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </a>
                    </div>
                    <button class="wn-fav-remove-btn" onclick="removeFavorite(this, 2)" title="Remove from favorites">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                    <div class="wn-fav-badge">&#9733; 9.0</div>
                </div>
                <div class="wn-fav-info">
                    <h3 class="wn-fav-card-title">The Dark Knight</h3>
                    <div class="wn-fav-meta">
                        <span>2008</span>
                        <span class="wn-meta-dot">·</span>
                        <span>Action</span>
                    </div>
                    <div class="wn-fav-actions">
                        <a href="{{ url('/movie/2') }}" class="wn-fav-action-btn wn-fav-action-watch">
                            &#9654; Watch
                        </a>
                        <button class="wn-fav-action-btn wn-fav-action-remove" onclick="removeFavorite(this, 2)">
                            &#10005; Remove
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="wn-fav-card" data-id="3" data-title="Interstellar" data-rating="8.6" data-year="2014" data-added="3">
                <div class="wn-fav-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=INTERSTELLAR"
                         alt="Interstellar poster"
                         class="wn-fav-poster"
                         loading="lazy">
                    <div class="wn-fav-overlay">
                        <a href="{{ url('/movie/3') }}" class="wn-overlay-play" title="Watch now">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </a>
                    </div>
                    <button class="wn-fav-remove-btn" onclick="removeFavorite(this, 3)" title="Remove from favorites">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                    <div class="wn-fav-badge">&#9733; 8.6</div>
                </div>
                <div class="wn-fav-info">
                    <h3 class="wn-fav-card-title">Interstellar</h3>
                    <div class="wn-fav-meta">
                        <span>2014</span>
                        <span class="wn-meta-dot">·</span>
                        <span>Drama</span>
                    </div>
                    <div class="wn-fav-actions">
                        <a href="{{ url('/movie/3') }}" class="wn-fav-action-btn wn-fav-action-watch">
                            &#9654; Watch
                        </a>
                        <button class="wn-fav-action-btn wn-fav-action-remove" onclick="removeFavorite(this, 3)">
                            &#10005; Remove
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card 4 --}}
            <div class="wn-fav-card" data-id="4" data-title="Pulp Fiction" data-rating="8.9" data-year="1994" data-added="4">
                <div class="wn-fav-poster-wrap">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=PULP+FICTION"
                         alt="Pulp Fiction poster"
                         class="wn-fav-poster"
                         loading="lazy">
                    <div class="wn-fav-overlay">
                        <a href="{{ url('/movie/4') }}" class="wn-overlay-play" title="Watch now">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </a>
                    </div>
                    <button class="wn-fav-remove-btn" onclick="removeFavorite(this, 4)" title="Remove from favorites">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                    <div class="wn-fav-badge">&#9733; 8.9</div>
                </div>
                <div class="wn-fav-info">
                    <h3 class="wn-fav-card-title">Pulp Fiction</h3>
                    <div class="wn-fav-meta">
                        <span>1994</span>
                        <span class="wn-meta-dot">·</span>
                        <span>Crime</span>
                    </div>
                    <div class="wn-fav-actions">
                        <a href="{{ url('/movie/4') }}" class="wn-fav-action-btn wn-fav-action-watch">
                            &#9654; Watch
                        </a>
                        <button class="wn-fav-action-btn wn-fav-action-remove" onclick="removeFavorite(this, 4)">
                            &#10005; Remove
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── END DEMO CARDS ── --}}

        </div>{{-- /wn-fav-grid --}}

    </div>{{-- /container --}}
</div>{{-- /wn-favorites-page --}}


{{-- ════════════════════════════════════════════════════════
     SCOPED CSS — Favorites Page
════════════════════════════════════════════════════════ --}}
@push('styles')
<style>
/* ── Page wrapper ── */
.wn-favorites-page {
    min-height: 100vh;
    background: var(--wn-dark);
    padding-bottom: 80px;
}

/* ── Header ── */
.wn-fav-header {
    background: linear-gradient(180deg, #0a0a0a 0%, var(--wn-dark) 100%);
    border-bottom: 1px solid var(--wn-border);
    padding: 100px 0 28px;
}
.wn-fav-header-inner {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}
.wn-fav-title {
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    font-weight: 700;
    color: var(--wn-white);
    letter-spacing: -0.02em;
    margin: 0 0 6px;
}
.wn-fav-icon {
    color: var(--wn-red);
    margin-right: 10px;
    font-size: 1.1em;
}
.wn-fav-subtitle {
    color: var(--wn-muted);
    font-size: 0.9rem;
    margin: 0;
}
.wn-fav-count {
    color: var(--wn-text);
    font-weight: 600;
}

/* ── Controls (sort + view toggle) ── */
.wn-fav-controls {
    display: flex;
    align-items: center;
    gap: 12px;
}
.wn-fav-select-wrap {
    position: relative;
}
.wn-fav-select {
    appearance: none;
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    color: var(--wn-text);
    padding: 8px 36px 8px 14px;
    border-radius: 6px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: border-color 0.2s;
}
.wn-fav-select:hover,
.wn-fav-select:focus {
    border-color: var(--wn-red);
    outline: none;
}
.wn-select-arrow {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--wn-muted);
    pointer-events: none;
    font-size: 1.1rem;
}

/* ── View toggle buttons ── */
.wn-view-toggle {
    display: flex;
    gap: 4px;
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    border-radius: 6px;
    padding: 4px;
}
.wn-view-btn {
    background: transparent;
    border: none;
    color: var(--wn-muted);
    padding: 6px 8px;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, color 0.2s;
}
.wn-view-btn:hover { color: var(--wn-text); }
.wn-view-btn.active {
    background: var(--wn-red);
    color: var(--wn-white);
}

/* ── Container ── */
.wn-fav-container {
    padding-top: 36px;
}

/* ── Alerts (dismissible) ── */
.wn-alert-dismissible {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 0.9rem;
}
.wn-alert-close {
    background: none;
    border: none;
    color: inherit;
    opacity: 0.7;
    cursor: pointer;
    font-size: 0.8rem;
    padding: 0 0 0 12px;
}
.wn-alert-close:hover { opacity: 1; }

/* ── Empty state ── */
.wn-fav-empty {
    text-align: center;
    padding: 80px 20px;
    animation: wn-fadein 0.4s ease;
}
.wn-empty-icon svg {
    width: 80px;
    height: 80px;
    margin: 0 auto 24px;
    display: block;
}
.wn-empty-title {
    color: var(--wn-white);
    font-size: 1.5rem;
    margin: 0 0 12px;
}
.wn-empty-text {
    color: var(--wn-muted);
    font-size: 0.95rem;
    margin: 0 0 28px;
    max-width: 360px;
    margin-left: auto;
    margin-right: auto;
}
.wn-empty-cta {
    display: inline-block;
    padding: 12px 32px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: background 0.2s, transform 0.15s;
}
.wn-empty-cta:hover { transform: translateY(-2px); }

/* ══ GRID VIEW (default) ══ */
.wn-fav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 24px;
}

/* ── Card ── */
.wn-fav-card {
    background: var(--wn-card);
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--wn-border);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    animation: wn-fadein 0.35s ease both;
}
.wn-fav-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.6);
    border-color: var(--wn-red);
}

/* Poster wrapper */
.wn-fav-poster-wrap {
    position: relative;
    aspect-ratio: 2/3;
    overflow: hidden;
}
.wn-fav-poster {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}
.wn-fav-card:hover .wn-fav-poster {
    transform: scale(1.06);
}

/* Overlay play button */
.wn-fav-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.25s;
}
.wn-fav-card:hover .wn-fav-overlay { opacity: 1; }
.wn-overlay-play {
    color: var(--wn-white);
    background: var(--wn-red);
    border-radius: 50%;
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s, background 0.2s;
    text-decoration: none;
}
.wn-overlay-play:hover {
    background: var(--wn-red-dark);
    transform: scale(1.1);
    color: var(--wn-white);
}

/* Remove × button (top-right corner) */
.wn-fav-remove-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0,0,0,0.75);
    border: none;
    color: var(--wn-muted);
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.2s, color 0.2s, background 0.2s;
    z-index: 2;
}
.wn-fav-card:hover .wn-fav-remove-btn { opacity: 1; }
.wn-fav-remove-btn:hover {
    background: var(--wn-red);
    color: var(--wn-white);
}

/* Rating badge */
.wn-fav-badge {
    position: absolute;
    bottom: 8px;
    left: 8px;
    background: rgba(0,0,0,0.8);
    color: #f5c518;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 4px;
    letter-spacing: 0.02em;
}

/* Info section */
.wn-fav-info {
    padding: 14px;
}
.wn-fav-card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--wn-white);
    margin: 0 0 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.wn-fav-meta {
    font-size: 0.78rem;
    color: var(--wn-muted);
    margin: 0 0 12px;
}
.wn-meta-dot { margin: 0 5px; }

/* Action buttons */
.wn-fav-actions {
    display: flex;
    gap: 8px;
}
.wn-fav-action-btn {
    flex: 1;
    border: none;
    border-radius: 5px;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 7px 6px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    transition: opacity 0.2s, transform 0.15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}
.wn-fav-action-btn:hover { opacity: 0.85; transform: translateY(-1px); }
.wn-fav-action-watch {
    background: var(--wn-red);
    color: var(--wn-white);
}
.wn-fav-action-remove {
    background: var(--wn-border);
    color: var(--wn-muted);
}
.wn-fav-action-remove:hover {
    background: #3a1010;
    color: #ff6b6b;
}

/* ══ LIST VIEW ══ */
.wn-fav-grid.list-view {
    grid-template-columns: 1fr;
    gap: 12px;
}
.wn-fav-grid.list-view .wn-fav-card {
    display: flex;
    flex-direction: row;
    align-items: stretch;
}
.wn-fav-grid.list-view .wn-fav-poster-wrap {
    width: 90px;
    flex-shrink: 0;
    aspect-ratio: unset;
}
.wn-fav-grid.list-view .wn-fav-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 16px 20px;
}
.wn-fav-grid.list-view .wn-fav-card-title {
    font-size: 1rem;
    white-space: normal;
}
.wn-fav-grid.list-view .wn-fav-actions {
    max-width: 260px;
}

/* ── Card removal animation ── */
.wn-fav-card.removing {
    animation: wn-slideout 0.35s ease forwards;
}

/* ── Keyframes ── */
@keyframes wn-fadein {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes wn-slideout {
    to { opacity: 0; transform: scale(0.88); }
}

/* ── Staggered entry animations ── */
.wn-fav-card:nth-child(1)  { animation-delay: 0.04s; }
.wn-fav-card:nth-child(2)  { animation-delay: 0.08s; }
.wn-fav-card:nth-child(3)  { animation-delay: 0.12s; }
.wn-fav-card:nth-child(4)  { animation-delay: 0.16s; }
.wn-fav-card:nth-child(5)  { animation-delay: 0.20s; }
.wn-fav-card:nth-child(6)  { animation-delay: 0.24s; }
.wn-fav-card:nth-child(7)  { animation-delay: 0.28s; }
.wn-fav-card:nth-child(8)  { animation-delay: 0.32s; }


@media (max-width: 768px) {
    .wn-fav-header-inner { flex-direction: column; align-items: flex-start; }
    .wn-fav-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 16px; }
    .wn-fav-grid.list-view .wn-fav-poster-wrap { width: 70px; }
}
@media (max-width: 480px) {
    .wn-fav-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush


{{-- ════════════════════════════════════════════════════════
     JAVASCRIPT — Sort, View Toggle, Remove
════════════════════════════════════════════════════════ --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    updateCount();
});

/* ── Update title count ── */
function updateCount() {
    const cards = document.querySelectorAll('#favGrid .wn-fav-card');
    document.getElementById('favCount').textContent = cards.length;
    document.getElementById('emptyState').style.display = cards.length === 0 ? 'block' : 'none';
}

/* ── View toggle: grid / list ── */
function setView(view) {
    const grid = document.getElementById('favGrid');
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

/* ── Sort favorites ── */
function sortFavorites(criterion) {
    const grid = document.getElementById('favGrid');
    const cards = Array.from(grid.querySelectorAll('.wn-fav-card'));

    cards.sort(function(a, b) {
        if (criterion === 'title') {
            return a.dataset.title.localeCompare(b.dataset.title);
        }
        if (criterion === 'rating') {
            return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        }
        if (criterion === 'year') {
            return parseInt(b.dataset.year) - parseInt(a.dataset.year);
        }
        // 'added' — original order (data-added index)
        return parseInt(a.dataset.added) - parseInt(b.dataset.added);
    });

    // Re-append in sorted order
    cards.forEach(function(card) { grid.appendChild(card); });
}

/* ── Remove favorite (with animation) ──
   TODO: backend — replace alert with real AJAX call:
   fetch('/favorites/remove', {
       method: 'POST',
       headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                  'Content-Type': 'application/json' },
       body: JSON.stringify({ movie_id: movieId })
   }).then(r => r.json()).then(data => { if(data.success) removeCard(btn); });
*/
function removeFavorite(btn, movieId) {
    // Find the parent card
    const card = btn.closest('.wn-fav-card');
    if (!card) return;

    // Animate out, then remove from DOM
    card.classList.add('removing');
    card.addEventListener('animationend', function () {
        card.remove();
        updateCount();
    }, { once: true });

    // TODO: replace with real AJAX POST to /favorites/remove
    console.log('Remove favorite: movie_id =', movieId);
}
</script>
@endpush

@endsection