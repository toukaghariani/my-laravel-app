@extends('layouts.app')

@section('title', 'Watch — WolfNet')

@section('content')

{{-- ============================================================
     VIDEO PLAYER PAGE — WolfNet
     Backend TODO:
       - Route: GET /watch/{id} → WatchController@show
       - Pass $movie object with: id, title, video_url, poster_url,
         description, year, genre, rating, cast, director
       - Pass $related collection
     ============================================================ --}}

<div class="wn-watch-page">

    {{-- ── VIDEO PLAYER SECTION ── --}}
    <div class="wn-player-section">

        {{-- ── MAIN PLAYER ── --}}
        <div class="wn-player-wrap" id="playerWrap">

            {{-- Video element --}}
            {{-- TODO: replace src with {{ $movie->video_url }} --}}
            <video
                id="mainPlayer"
                class="wn-video-el"
                poster="https://via.placeholder.com/1280x720/0a0a0a/e50914?text=▶+WolfNet+Player"
                preload="metadata">
                {{-- TODO: <source src="{{ $movie->video_url }}" type="video/mp4"> --}}
                <source src="" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>

            {{-- ── CUSTOM CONTROLS ── --}}
            <div class="wn-controls" id="playerControls">

                {{-- Progress bar --}}
                <div class="wn-progress-wrap">
                    <div class="wn-progress-bar" id="progressBar" onclick="seekVideo(event)">
                        <div class="wn-progress-buffered" id="buffered"></div>
                        <div class="wn-progress-fill" id="progressFill"></div>
                        <div class="wn-progress-thumb" id="progressThumb"></div>
                    </div>
                    <div class="wn-time-row">
                        <span id="currentTime">0:00</span>
                        <span id="totalTime">0:00</span>
                    </div>
                </div>

                {{-- Buttons row --}}
                <div class="wn-controls-row">

                    {{-- Left controls --}}
                    <div class="wn-controls-left">
                        <button class="wn-ctrl-btn" onclick="skipBack()" title="Rewind 10s">
                            <i class="bi bi-skip-backward-fill"></i>
                        </button>
                        <button class="wn-ctrl-btn wn-play-pause-btn" id="playPauseBtn" onclick="togglePlay()" title="Play/Pause">
                            <i class="bi bi-play-fill" id="playIcon"></i>
                        </button>
                        <button class="wn-ctrl-btn" onclick="skipForward()" title="Forward 10s">
                            <i class="bi bi-skip-forward-fill"></i>
                        </button>

                        {{-- Volume --}}
                        <div class="wn-volume-wrap">
                            <button class="wn-ctrl-btn" id="muteBtn" onclick="toggleMute()" title="Mute">
                                <i class="bi bi-volume-up-fill" id="volumeIcon"></i>
                            </button>
                            <input type="range" class="wn-volume-slider" id="volumeSlider"
                                   min="0" max="100" value="80" oninput="setVolume(this.value)">
                        </div>

                        <span class="wn-time-display">
                            <span id="currentTimeDisplay">0:00</span> /
                            <span id="totalTimeDisplay">0:00</span>
                        </span>
                    </div>

                    {{-- Right controls --}}
                    <div class="wn-controls-right">
                        <button class="wn-ctrl-btn" onclick="toggleSubtitles()" title="Subtitles" id="subBtn">
                            <i class="bi bi-badge-cc"></i>
                        </button>
                        <div class="wn-quality-wrap">
                            <button class="wn-ctrl-btn wn-quality-btn" onclick="toggleQualityMenu()" title="Quality">
                                <span id="qualityLabel">HD</span>
                            </button>
                            <div class="wn-quality-menu" id="qualityMenu" style="display:none;">
                                <button onclick="setQuality('4K')">4K Ultra HD</button>
                                <button onclick="setQuality('1080p')">1080p Full HD</button>
                                <button class="active" onclick="setQuality('HD')">720p HD</button>
                                <button onclick="setQuality('480p')">480p SD</button>
                            </div>
                        </div>
                        <button class="wn-ctrl-btn" onclick="togglePiP()" title="Picture in Picture">
                            <i class="bi bi-pip"></i>
                        </button>
                        <button class="wn-ctrl-btn" onclick="toggleFullscreen()" title="Fullscreen" id="fullscreenBtn">
                            <i class="bi bi-fullscreen" id="fullscreenIcon"></i>
                        </button>
                    </div>

                </div>
            </div>

            {{-- ── PLAY OVERLAY (shown when paused) ── --}}
            <div class="wn-play-overlay" id="playOverlay" onclick="togglePlay()">
                <div class="wn-play-overlay-btn">
                    <i class="bi bi-play-fill"></i>
                </div>
                <p class="wn-play-overlay-title">Inception (2010)</p>
            </div>

            {{-- ── PREMIUM LOCK OVERLAY ── --}}
            <div class="wn-lock-overlay" id="lockOverlay">
                <div class="wn-lock-content">
                    <div class="wn-lock-icon">🔒</div>
                    <h2 class="wn-lock-title">Premium Content</h2>
                    <p class="wn-lock-text">Upgrade to Premium to watch the full movie in HD quality.</p>
                    <a href="{{ url('/premium') }}" class="wn-lock-btn">♛ Upgrade Now — 15 TND/month</a>
                    <button class="wn-lock-trailer-btn" onclick="watchTrailer()">
                        <i class="bi bi-play-circle"></i> Watch Free Trailer Instead
                    </button>
                </div>
            </div>

        </div>{{-- /player wrap --}}

    </div>{{-- /player section --}}


    {{-- ── MOVIE INFO + EPISODES ── --}}
    <div class="container wn-watch-info-section">
        <div class="wn-watch-layout">

            {{-- ── LEFT: MOVIE INFO ── --}}
            <div class="wn-watch-main">

                {{-- Title row --}}
                <div class="wn-watch-title-row">
                    <div>
                        <h1 class="wn-watch-title">Inception</h1>
                        <div class="wn-watch-meta">
                            <span class="wn-meta-chip wn-chip-rating">⭐ 8.8</span>
                            <span class="wn-meta-chip">2010</span>
                            <span class="wn-meta-chip">2h 28min</span>
                            <span class="wn-meta-chip wn-chip-genre">Sci-Fi</span>
                        </div>
                    </div>
                    <div class="wn-watch-title-actions">
                        <button class="wn-watch-action-btn" onclick="toggleFav(this)" title="Add to Favorites">
                            <i class="bi bi-heart"></i>
                        </button>
                        <button class="wn-watch-action-btn" onclick="toggleWatchlist(this)" title="Add to Watchlist">
                            <i class="bi bi-bookmark"></i>
                        </button>
                        <button class="wn-watch-action-btn" onclick="shareMovie()" title="Share">
                            <i class="bi bi-share"></i>
                        </button>
                    </div>
                </div>

                {{-- Description --}}
                <p class="wn-watch-desc">
                    A thief who steals corporate secrets through dream-sharing technology is given the task
                    of planting an idea into the mind of a C.E.O. A mind-bending thriller that will leave
                    you questioning reality.
                </p>

                {{-- Credits --}}
                <div class="wn-watch-credits">
                    <div class="wn-watch-credit-item">
                        <span class="wn-credit-label">Director</span>
                        <span class="wn-credit-val">Christopher Nolan</span>
                    </div>
                    <div class="wn-watch-credit-item">
                        <span class="wn-credit-label">Cast</span>
                        <span class="wn-credit-val">Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page, Tom Hardy</span>
                    </div>
                    <div class="wn-watch-credit-item">
                        <span class="wn-credit-label">Genre</span>
                        <span class="wn-credit-val">Sci-Fi, Action, Thriller</span>
                    </div>
                </div>

                {{-- Up Next --}}
                <div class="wn-up-next">
                    <h3 class="wn-up-next-title">🎬 Up Next</h3>
                    <div class="wn-up-next-list">
                        @for($i = 1; $i <= 4; $i++)
                        <a href="{{ url('/watch/' . $i) }}" class="wn-up-next-card">
                            <div class="wn-up-next-thumb">
                                <img src="https://via.placeholder.com/160x90/1c1c1c/e50914?text=Movie+{{ $i }}"
                                     alt="Movie {{ $i }}" loading="lazy">
                                <div class="wn-up-next-overlay">
                                    <i class="bi bi-play-fill"></i>
                                </div>
                            </div>
                            <div class="wn-up-next-info">
                                <p class="wn-up-next-name">Movie Title {{ $i }}</p>
                                <span class="wn-up-next-meta">2h 10min · Action</span>
                            </div>
                        </a>
                        @endfor
                    </div>
                </div>

            </div>{{-- /watch main --}}

            {{-- ── RIGHT: RELATED ── --}}
            <div class="wn-watch-sidebar">
                <h3 class="wn-watch-sidebar-title">Related Movies</h3>
                <div class="wn-watch-related-list">
                    @for($i = 1; $i <= 6; $i++)
                    <a href="{{ url('/watch/' . $i) }}" class="wn-watch-related-card">
                        <img src="https://via.placeholder.com/80x120/1c1c1c/e50914?text={{ $i }}"
                             alt="Movie {{ $i }}" loading="lazy">
                        <div class="wn-watch-related-info">
                            <p class="wn-watch-related-title">Related Movie {{ $i }}</p>
                            <span class="wn-watch-related-meta">2024 · Action</span>
                            <span class="wn-watch-related-rating">⭐ 7.{{ $i }}</span>
                        </div>
                    </a>
                    @endfor
                </div>
            </div>

        </div>
    </div>

</div>{{-- /watch page --}}


@push('styles')
<style>
/* ── Page ── */
.wn-watch-page { min-height:100vh; background:#000; padding-top:64px; }

/* ── Player section ── */
.wn-player-section { background:#000; width:100%; }
.wn-player-wrap {
    position:relative;
    width:100%;
    max-width:1280px;
    margin:0 auto;
    background:#000;
    aspect-ratio:16/9;
    overflow:hidden;
}
.wn-video-el { width:100%; height:100%; object-fit:contain; display:block; background:#000; }

/* ── Controls ── */
.wn-controls {
    position:absolute;
    bottom:0; left:0; right:0;
    background:linear-gradient(transparent, rgba(0,0,0,0.9));
    padding:40px 20px 16px;
    opacity:0;
    transition:opacity 0.3s;
    z-index:10;
}
.wn-player-wrap:hover .wn-controls { opacity:1; }

/* Progress bar */
.wn-progress-wrap { margin-bottom:10px; }
.wn-progress-bar {
    position:relative;
    height:4px;
    background:rgba(255,255,255,0.2);
    border-radius:2px;
    cursor:pointer;
    transition:height 0.2s;
    margin-bottom:6px;
}
.wn-progress-bar:hover { height:6px; }
.wn-progress-buffered { position:absolute; top:0; left:0; height:100%; background:rgba(255,255,255,0.3); border-radius:2px; width:0%; }
.wn-progress-fill { position:absolute; top:0; left:0; height:100%; background:var(--wn-red); border-radius:2px; width:0%; transition:width 0.1s; }
.wn-progress-thumb {
    position:absolute;
    top:50%; left:0%;
    transform:translate(-50%, -50%);
    width:14px; height:14px;
    background:var(--wn-red);
    border-radius:50%;
    opacity:0;
    transition:opacity 0.2s;
}
.wn-progress-bar:hover .wn-progress-thumb { opacity:1; }
.wn-time-row { display:flex; justify-content:space-between; font-size:0.72rem; color:rgba(255,255,255,0.5); }

/* Controls row */
.wn-controls-row { display:flex; align-items:center; justify-content:space-between; gap:8px; }
.wn-controls-left, .wn-controls-right { display:flex; align-items:center; gap:6px; }
.wn-ctrl-btn { background:transparent; border:none; color:white; font-size:1.1rem; padding:6px 8px; cursor:pointer; border-radius:4px; transition:background 0.2s, transform 0.15s; display:flex; align-items:center; justify-content:center; }
.wn-ctrl-btn:hover { background:rgba(255,255,255,0.15); transform:scale(1.1); }
.wn-play-pause-btn { font-size:1.3rem; }
.wn-time-display { color:rgba(255,255,255,0.8); font-size:0.8rem; white-space:nowrap; margin:0 6px; }

/* Volume */
.wn-volume-wrap { display:flex; align-items:center; gap:4px; }
.wn-volume-slider {
    width:70px; height:3px;
    appearance:none;
    background:rgba(255,255,255,0.3);
    border-radius:2px;
    cursor:pointer;
    outline:none;
}
.wn-volume-slider::-webkit-slider-thumb { appearance:none; width:12px; height:12px; background:white; border-radius:50%; }

/* Quality menu */
.wn-quality-wrap { position:relative; }
.wn-quality-btn { font-size:0.75rem; font-weight:700; border:1px solid rgba(255,255,255,0.3); border-radius:4px; padding:4px 10px; }
.wn-quality-menu {
    position:absolute;
    bottom:calc(100% + 8px);
    right:0;
    background:#1a1a1a;
    border:1px solid var(--wn-border);
    border-radius:8px;
    overflow:hidden;
    min-width:140px;
    z-index:20;
}
.wn-quality-menu button { display:block; width:100%; padding:8px 14px; background:transparent; border:none; color:var(--wn-text); font-size:0.82rem; text-align:left; cursor:pointer; transition:background 0.2s; }
.wn-quality-menu button:hover { background:rgba(229,9,20,0.1); }
.wn-quality-menu button.active { color:var(--wn-red); font-weight:700; }

/* ── Play overlay ── */
.wn-play-overlay {
    position:absolute; inset:0;
    display:flex; flex-direction:column;
    align-items:center; justify-content:center;
    background:rgba(0,0,0,0.4);
    cursor:pointer;
    z-index:5;
    transition:opacity 0.3s;
}
.wn-play-overlay.hidden { opacity:0; pointer-events:none; }
.wn-play-overlay-btn {
    width:72px; height:72px;
    background:rgba(229,9,20,0.9);
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:2rem; color:white;
    transition:transform 0.2s, background 0.2s;
    margin-bottom:16px;
}
.wn-play-overlay:hover .wn-play-overlay-btn { transform:scale(1.1); background:var(--wn-red); }
.wn-play-overlay-title { color:white; font-size:1rem; font-weight:600; opacity:0.8; }

/* ── Lock overlay ── */
.wn-lock-overlay {
    position:absolute; inset:0;
    background:rgba(0,0,0,0.88);
    backdrop-filter:blur(8px);
    display:flex; align-items:center; justify-content:center;
    z-index:15;
}
.wn-lock-content { text-align:center; max-width:400px; padding:20px; }
.wn-lock-icon { font-size:3rem; margin-bottom:16px; }
.wn-lock-title { font-size:1.6rem; font-weight:800; color:white; margin:0 0 12px; }
.wn-lock-text { color:#b0b0b0; font-size:0.95rem; margin:0 0 24px; line-height:1.6; }
.wn-lock-btn {
    display:block;
    background:linear-gradient(135deg, #f5c518, #e6a800);
    color:#000; font-weight:800; font-size:0.95rem;
    padding:14px 28px; border-radius:10px;
    text-decoration:none; margin-bottom:12px;
    transition:opacity 0.2s, transform 0.15s;
}
.wn-lock-btn:hover { opacity:0.9; transform:translateY(-2px); color:#000; }
.wn-lock-trailer-btn {
    background:transparent; border:1px solid rgba(255,255,255,0.3);
    color:rgba(255,255,255,0.7); padding:10px 20px; border-radius:8px;
    font-size:0.88rem; cursor:pointer; transition:all 0.2s;
    display:inline-flex; align-items:center; gap:8px;
}
.wn-lock-trailer-btn:hover { border-color:white; color:white; }

/* ── Watch info section ── */
.wn-watch-info-section { padding-top:32px; padding-bottom:80px; }
.wn-watch-layout { display:grid; grid-template-columns:1fr 300px; gap:32px; align-items:start; }

/* Title row */
.wn-watch-title-row { display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:16px; flex-wrap:wrap; }
.wn-watch-title { font-size:clamp(1.5rem,3vw,2.2rem); font-weight:800; color:var(--wn-white); margin:0 0 10px; letter-spacing:-0.02em; }
.wn-watch-meta { display:flex; gap:8px; flex-wrap:wrap; }
.wn-meta-chip { background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); font-size:0.78rem; font-weight:600; padding:3px 10px; border-radius:16px; }
.wn-chip-rating { border-color:rgba(245,197,24,0.4); color:#f5c518; background:rgba(245,197,24,0.08); }
.wn-chip-genre { border-color:rgba(229,9,20,0.4); color:#ff6b6b; background:rgba(229,9,20,0.08); }
.wn-watch-title-actions { display:flex; gap:8px; }
.wn-watch-action-btn { background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-muted); width:38px; height:38px; border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:0.95rem; transition:all 0.2s; }
.wn-watch-action-btn:hover { border-color:var(--wn-red); color:var(--wn-red); }
.wn-watch-action-btn.active { border-color:var(--wn-red); color:var(--wn-red); background:rgba(229,9,20,0.08); }

/* Description */
.wn-watch-desc { color:#b0b0b0; font-size:0.95rem; line-height:1.7; margin-bottom:20px; }

/* Credits */
.wn-watch-credits { display:flex; flex-direction:column; gap:8px; margin-bottom:28px; padding:16px; background:var(--wn-card); border:1px solid var(--wn-border); border-radius:10px; }
.wn-watch-credit-item { display:flex; gap:12px; font-size:0.85rem; }
.wn-credit-label { color:var(--wn-muted); font-weight:600; min-width:65px; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.05em; padding-top:1px; }
.wn-credit-val { color:var(--wn-text); }

/* Up Next */
.wn-up-next { }
.wn-up-next-title { font-size:0.95rem; font-weight:700; color:var(--wn-white); margin:0 0 16px; }
.wn-up-next-list { display:flex; flex-direction:column; gap:12px; }
.wn-up-next-card { display:flex; gap:12px; text-decoration:none; border-radius:8px; overflow:hidden; transition:background 0.2s; padding:8px; border:1px solid transparent; }
.wn-up-next-card:hover { background:var(--wn-card); border-color:var(--wn-border); }
.wn-up-next-thumb { position:relative; flex-shrink:0; width:130px; border-radius:6px; overflow:hidden; }
.wn-up-next-thumb img { width:100%; aspect-ratio:16/9; object-fit:cover; display:block; }
.wn-up-next-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.5); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity 0.2s; color:white; font-size:1.2rem; }
.wn-up-next-card:hover .wn-up-next-overlay { opacity:1; }
.wn-up-next-info { display:flex; flex-direction:column; justify-content:center; gap:4px; }
.wn-up-next-name { font-size:0.88rem; font-weight:600; color:var(--wn-white); margin:0; }
.wn-up-next-meta { font-size:0.75rem; color:var(--wn-muted); }

/* Sidebar */
.wn-watch-sidebar { position:sticky; top:80px; }
.wn-watch-sidebar-title { font-size:0.95rem; font-weight:700; color:var(--wn-white); margin:0 0 16px; }
.wn-watch-related-list { display:flex; flex-direction:column; gap:12px; }
.wn-watch-related-card { display:flex; gap:10px; text-decoration:none; border-radius:8px; padding:8px; border:1px solid transparent; transition:background 0.2s, border-color 0.2s; }
.wn-watch-related-card:hover { background:var(--wn-card); border-color:var(--wn-border); }
.wn-watch-related-card img { width:70px; aspect-ratio:2/3; object-fit:cover; border-radius:6px; flex-shrink:0; }
.wn-watch-related-info { display:flex; flex-direction:column; justify-content:center; gap:4px; }
.wn-watch-related-title { font-size:0.85rem; font-weight:600; color:var(--wn-white); margin:0; }
.wn-watch-related-meta { font-size:0.72rem; color:var(--wn-muted); }
.wn-watch-related-rating { font-size:0.72rem; color:#f5c518; font-weight:600; }

@media(max-width:900px) { .wn-watch-layout { grid-template-columns:1fr; } .wn-watch-sidebar { position:static; } }
@media(max-width:576px) { .wn-watch-title-row { flex-direction:column; } .wn-up-next-thumb { width:100px; } }
</style>
@endpush


@push('scripts')
<script>
const video = document.getElementById('mainPlayer');
/* ── Stream URL Fetch + Playback Logic ── */
const MOVIE_ID = 1;
const STREAM_URL = '';

function loadStream() {
    // If backend gives us a direct URL
    if (STREAM_URL && STREAM_URL !== '') {
        playStream(STREAM_URL);
        return;
    }

    // Otherwise fetch from backend
    fetch('/watch/' + MOVIE_ID + '/stream', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(function(response) {
        if (!response.ok) throw new Error('Stream not available');
        return response.json();
    })
    .then(function(data) {
        if (data.url) {
            playStream(data.url);
        } else {
            showStreamError('No stream URL returned from server.');
        }
    })
    .catch(function(err) {
        showStreamError('Could not load stream: ' + err.message);
        console.error('Stream fetch error:', err);
    });
}

function playStream(url) {
    // Remove lock overlay if user is premium
   
    document.getElementById('lockOverlay').style.display = 'none';

    // Set video source
    const source = document.createElement('source');
    source.src = url;

    // Detect format
    if (url.includes('.m3u8')) {
        source.type = 'application/x-mpegURL'; // HLS stream
        loadHLS(url);
    } else if (url.includes('.mpd')) {
        source.type = 'application/dash+xml'; // DASH stream
    } else {
        source.type = 'video/mp4'; // Regular MP4
        video.src = url;
        video.load();
    }

    console.log('Stream loaded:', url);
}

function loadHLS(url) {
    // Check if browser supports HLS natively (Safari)
    if (video.canPlayType('application/vnd.apple.mpegurl')) {
        video.src = url;
        video.load();
    } else {
        // For Chrome/Firefox — load hls.js library
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/hls.js@latest';
        script.onload = function() {
            if (window.Hls && Hls.isSupported()) {
                const hls = new Hls();
                hls.loadSource(url);
                hls.attachMedia(video);
                hls.on(Hls.Events.MANIFEST_PARSED, function() {
                    console.log('HLS manifest loaded');
                });
            }
        };
        document.head.appendChild(script);
    }
}

function showStreamError(msg) {
    const overlay = document.getElementById('playOverlay');
    overlay.style.display = 'flex';
    overlay.innerHTML = `
        <div style="text-align:center;padding:20px;">
            <div style="font-size:3rem;margin-bottom:16px;">⚠️</div>
            <p style="color:white;font-size:1rem;font-weight:700;">Stream Unavailable</p>
            <p style="color:#b0b0b0;font-size:0.85rem;">${msg}</p>
        </div>
    `;
    overlay.onclick = null;
}

// Auto-load stream on page load
document.addEventListener('DOMContentLoaded', function() {
    loadStream();
});
const playPauseBtn = document.getElementById('playPauseBtn');
const playIcon = document.getElementById('playIcon');
const playOverlay = document.getElementById('playOverlay');
const progressFill = document.getElementById('progressFill');
const progressThumb = document.getElementById('progressThumb');
const buffered = document.getElementById('buffered');
const currentTimeDisplay = document.getElementById('currentTimeDisplay');
const totalTimeDisplay = document.getElementById('totalTimeDisplay');

/* ── Play / Pause ── */
function togglePlay() {
    if (video.paused) {
        video.play();
        playIcon.className = 'bi bi-pause-fill';
        playOverlay.classList.add('hidden');
    } else {
        video.pause();
        playIcon.className = 'bi bi-play-fill';
        playOverlay.classList.remove('hidden');
    }
}

/* ── Skip ── */
function skipBack() { video.currentTime = Math.max(0, video.currentTime - 10); }
function skipForward() { video.currentTime = Math.min(video.duration, video.currentTime + 10); }

/* ── Volume ── */
function setVolume(val) {
    video.volume = val / 100;
    document.getElementById('volumeIcon').className =
        val == 0 ? 'bi bi-volume-mute-fill' :
        val < 50 ? 'bi bi-volume-down-fill' : 'bi bi-volume-up-fill';
}
function toggleMute() {
    video.muted = !video.muted;
    document.getElementById('volumeIcon').className =
        video.muted ? 'bi bi-volume-mute-fill' : 'bi bi-volume-up-fill';
    document.getElementById('volumeSlider').value = video.muted ? 0 : video.volume * 100;
}

/* ── Progress ── */
video.addEventListener('timeupdate', function() {
    if (!video.duration) return;
    const pct = (video.currentTime / video.duration) * 100;
    progressFill.style.width = pct + '%';
    progressThumb.style.left = pct + '%';
    currentTimeDisplay.textContent = formatTime(video.currentTime);
});
video.addEventListener('loadedmetadata', function() {
    totalTimeDisplay.textContent = formatTime(video.duration);
});
video.addEventListener('progress', function() {
    if (video.buffered.length > 0) {
        const pct = (video.buffered.end(video.buffered.length - 1) / video.duration) * 100;
        buffered.style.width = pct + '%';
    }
});

function seekVideo(e) {
    const bar = e.currentTarget;
    const rect = bar.getBoundingClientRect();
    const pct = (e.clientX - rect.left) / rect.width;
    video.currentTime = pct * video.duration;
}

function formatTime(s) {
    if (isNaN(s)) return '0:00';
    const m = Math.floor(s / 60);
    const sec = Math.floor(s % 60);
    return m + ':' + (sec < 10 ? '0' : '') + sec;
}

/* ── Fullscreen ── */
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.getElementById('playerWrap').requestFullscreen();
        document.getElementById('fullscreenIcon').className = 'bi bi-fullscreen-exit';
    } else {
        document.exitFullscreen();
        document.getElementById('fullscreenIcon').className = 'bi bi-fullscreen';
    }
}

/* ── Picture in Picture ── */
function togglePiP() {
    if (document.pictureInPictureElement) {
        document.exitPictureInPicture();
    } else if (video.requestPictureInPicture) {
        video.requestPictureInPicture();
    }
}

/* ── Quality ── */
function toggleQualityMenu() {
    const menu = document.getElementById('qualityMenu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function setQuality(q) {
    document.getElementById('qualityLabel').textContent = q;
    document.getElementById('qualityMenu').style.display = 'none';
    document.querySelectorAll('.wn-quality-menu button').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');
}

/* ── Subtitles ── */
let subsOn = false;
function toggleSubtitles() {
    subsOn = !subsOn;
    document.getElementById('subBtn').style.color = subsOn ? 'var(--wn-red)' : 'white';
}

/* ── Fav / Watchlist ── */
function toggleFav(btn) {
    btn.classList.toggle('active');
    btn.querySelector('i').className = btn.classList.contains('active') ? 'bi bi-heart-fill' : 'bi bi-heart';
}
function toggleWatchlist(btn) {
    btn.classList.toggle('active');
    btn.querySelector('i').className = btn.classList.contains('active') ? 'bi bi-bookmark-fill' : 'bi bi-bookmark';
}

/* ── Share ── */
function shareMovie() {
    if (navigator.share) {
        navigator.share({ title: 'Inception', url: window.location.href });
    } else {
        navigator.clipboard.writeText(window.location.href).then(() => alert('Link copied!'));
    }
}

/* ── Watch trailer (unlock overlay) ── */
function watchTrailer() {
    document.getElementById('lockOverlay').style.display = 'none';
    // TODO: load trailer src
}

/* ── Hide quality menu on outside click ── */
document.addEventListener('click', function(e) {
    if (!e.target.closest('.wn-quality-wrap')) {
        document.getElementById('qualityMenu').style.display = 'none';
    }
});

/* ── Keyboard shortcuts ── */
document.addEventListener('keydown', function(e) {
    if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
    if (e.code === 'Space') { e.preventDefault(); togglePlay(); }
    if (e.code === 'ArrowLeft') skipBack();
    if (e.code === 'ArrowRight') skipForward();
    if (e.code === 'KeyF') toggleFullscreen();
    if (e.code === 'KeyM') toggleMute();
});
</script>

@endpush

@include('components.progress-tracker', [
    'movieId' => 1,
    'duration' => 7200
])

@endsection
