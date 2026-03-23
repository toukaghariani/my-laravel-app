@extends('layouts.app')

@section('title', 'Watch History — WolfNet')

@section('content')

{{-- ============================================================
     WATCH HISTORY PAGE — WolfNet
     Backend TODO:
       - Route: GET /history → HistoryController@index
       - Pass $history (collection grouped by date)
       - Each item: id, title, year, genre, rating, poster_url,
         type, watched_at, progress (0-100%)
     ============================================================ --}}

<div class="wn-history-page">

    {{-- ── HEADER ── --}}
    <div class="wn-hist-header">
        <div class="container">
            <div class="wn-hist-header-inner">
                <div>
                    <h1 class="wn-hist-title">
                        <span>🕐</span> Watch History
                    </h1>
                    <p class="wn-hist-subtitle">
                        <span class="wn-hist-count" id="histCount">0</span> titles watched
                    </p>
                </div>
                <div class="wn-hist-controls">
                    <div class="wn-fav-select-wrap">
                        <select class="wn-fav-select" onchange="filterHistory(this.value)">
                            <option value="all">All Time</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                        <span class="wn-select-arrow">⌄</span>
                    </div>
                    <button class="wn-clear-btn" onclick="confirmClear()">
                        <i class="bi bi-trash3"></i> Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MAIN ── --}}
    <div class="container wn-hist-container">

        {{-- Empty state --}}
        <div class="wn-hist-empty" id="emptyState" style="display:none;">
            <div class="wn-hist-empty-icon">📺</div>
            <h2 class="wn-empty-title">No watch history yet</h2>
            <p class="wn-empty-text">Movies and series you watch will appear here.</p>
            <a href="{{ url('/') }}" class="wn-browse-btn">Start Watching</a>
        </div>

        {{-- ══ HISTORY LIST ══
             TODO: Backend → replace demo items with:
             @foreach($history->groupBy('date') as $date => $items)
               <div class="wn-hist-date-group">
                 <h3 class="wn-hist-date-label">{{ $date }}</h3>
                 @foreach($items as $item) ... @endforeach
               </div>
             @endforeach
        ══ --}}

        <div id="historyList">

            {{-- ── DATE GROUP: Today ── --}}
            <div class="wn-hist-date-group" data-period="today week month">
                <h3 class="wn-hist-date-label">
                    <span class="wn-date-dot"></span> Today
                </h3>

                {{-- Item 1 --}}
                <div class="wn-hist-item" data-id="1">
                    <div class="wn-hist-poster-wrap">
                        <img src="https://via.placeholder.com/120x180/1c1c1c/e50914?text=TDK"
                             alt="The Dark Knight" class="wn-hist-poster" loading="lazy">
                        <a href="{{ url('/movie/2') }}" class="wn-hist-play-overlay">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <div class="wn-hist-info">
                        <div class="wn-hist-top">
                            <div>
                                <h4 class="wn-hist-item-title">The Dark Knight</h4>
                                <div class="wn-hist-meta">
                                    <span class="wn-hist-type-badge wn-type-movie">🎬 Movie</span>
                                    <span>2008</span>
                                    <span class="wn-meta-dot">·</span>
                                    <span>Action</span>
                                    <span class="wn-meta-dot">·</span>
                                    <span class="wn-hist-rating">⭐ 9.0</span>
                                </div>
                                <p class="wn-hist-time">Watched at 2:30 PM</p>
                            </div>
                            <button class="wn-hist-remove-btn" onclick="removeHistoryItem(this, 1)" title="Remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="wn-hist-progress-wrap">
                            <div class="wn-hist-progress-bar">
                                <div class="wn-hist-progress-fill" style="width:100%"></div>
                            </div>
                            <span class="wn-hist-progress-label">Completed</span>
                        </div>
                        <div class="wn-hist-item-actions">
                            <a href="{{ url('/movie/2') }}" class="wn-hist-action-btn wn-hist-rewatch">
                                ↺ Rewatch
                            </a>
                            <button class="wn-hist-action-btn wn-hist-del" onclick="removeHistoryItem(this, 1)">
                                ✕ Remove
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="wn-hist-item" data-id="2">
                    <div class="wn-hist-poster-wrap">
                        <img src="https://via.placeholder.com/120x180/1c1c1c/e50914?text=BB"
                             alt="Breaking Bad" class="wn-hist-poster" loading="lazy">
                        <a href="{{ url('/movie/4') }}" class="wn-hist-play-overlay">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <div class="wn-hist-info">
                        <div class="wn-hist-top">
                            <div>
                                <h4 class="wn-hist-item-title">Breaking Bad</h4>
                                <div class="wn-hist-meta">
                                    <span class="wn-hist-type-badge wn-type-series">📺 Series</span>
                                    <span>2008</span>
                                    <span class="wn-meta-dot">·</span>
                                    <span>Crime</span>
                                    <span class="wn-meta-dot">·</span>
                                    <span class="wn-hist-rating">⭐ 9.5</span>
                                </div>
                                <p class="wn-hist-time">Watched at 10:15 AM</p>
                            </div>
                            <button class="wn-hist-remove-btn" onclick="removeHistoryItem(this, 2)" title="Remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="wn-hist-progress-wrap">
                            <div class="wn-hist-progress-bar">
                                <div class="wn-hist-progress-fill" style="width:65%"></div>
                            </div>
                            <span class="wn-hist-progress-label">65% watched</span>
                        </div>
                        <div class="wn-hist-item-actions">
                            <a href="{{ url('/movie/4') }}" class="wn-hist-action-btn wn-hist-rewatch">
                                ▶ Continue
                            </a>
                            <button class="wn-hist-action-btn wn-hist-del" onclick="removeHistoryItem(this, 2)">
                                ✕ Remove
                            </button>
                        </div>
                    </div>
                </div>

            </div>{{-- /Today --}}

            {{-- ── DATE GROUP: Yesterday ── --}}
            <div class="wn-hist-date-group" data-period="week month">
                <h3 class="wn-hist-date-label">
                    <span class="wn-date-dot"></span> Yesterday
                </h3>

                {{-- Item 3 --}}
                <div class="wn-hist-item" data-id="3">
                    <div class="wn-hist-poster-wrap">
                        <img src="https://via.placeholder.com/120x180/1c1c1c/e50914?text=INC"
                             alt="Inception" class="wn-hist-poster" loading="lazy">
                        <a href="{{ url('/movie/1') }}" class="wn-hist-play-overlay">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <div class="wn-hist-info">
                        <div class="wn-hist-top">
                            <div>
                                <h4 class="wn-hist-item-title">Inception</h4>
                                <div class="wn-hist-meta">
                                    <span class="wn-hist-type-badge wn-type-movie">🎬 Movie</span>
                                    <span>2010</span>
                                    <span class="wn-meta-dot">·</span>
                                    <span>Sci-Fi</span>
                                    <span class="wn-meta-dot">·</span>
                                    <span class="wn-hist-rating">⭐ 8.8</span>
                                </div>
                                <p class="wn-hist-time">Watched at 8:00 PM</p>
                            </div>
                            <button class="wn-hist-remove-btn" onclick="removeHistoryItem(this, 3)" title="Remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="wn-hist-progress-wrap">
                            <div class="wn-hist-progress-bar">
                                <div class="wn-hist-progress-fill" style="width:100%"></div>
                            </div>
                            <span class="wn-hist-progress-label">Completed</span>
                        </div>
                        <div class="wn-hist-item-actions">
                            <a href="{{ url('/movie/1') }}" class="wn-hist-action-btn wn-hist-rewatch">
                                ↺ Rewatch
                            </a>
                            <button class="wn-hist-action-btn wn-hist-del" onclick="removeHistoryItem(this, 3)">
                                ✕ Remove
                            </button>
                        </div>
                    </div>
                </div>

            </div>{{-- /Yesterday --}}

            {{-- ── DATE GROUP: This Month ── --}}
            <div class="wn-hist-date-group" data-period="month">
                <h3 class="wn-hist-date-label">
                    <span class="wn-date-dot"></span> March 15
                </h3>

                {{-- Item 4 --}}
                <div class="wn-hist-item" data-id="4">
                    <div class="wn-hist-poster-wrap">
                        <img src="https://via.placeholder.com/120x180/1c1c1c/e50914?text=INT"
                             alt="Interstellar" class="wn-hist-poster" loading="lazy">
                        <a href="{{ url('/movie/3') }}" class="wn-hist-play-overlay">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    <div class="wn-hist-info">
                        <div class="wn-hist-top">
                            <div>
                                <h4 class="wn-hist-item-title">Interstellar</h4>
                                <div class="wn-hist-meta">
                                    <span class="wn-hist-type-badge wn-type-movie">🎬 Movie</span>
                                    <span>2014</span>
                                    <span class="wn-meta-dot">·</span>
                                    <span>Drama</span>
                                    <span class="wn-meta-dot">·</span>
                                    <span class="wn-hist-rating">⭐ 8.6</span>
                                </div>
                                <p class="wn-hist-time">Watched at 3:45 PM</p>
                            </div>
                            <button class="wn-hist-remove-btn" onclick="removeHistoryItem(this, 4)" title="Remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="wn-hist-progress-wrap">
                            <div class="wn-hist-progress-bar">
                                <div class="wn-hist-progress-fill" style="width:40%"></div>
                            </div>
                            <span class="wn-hist-progress-label">40% watched</span>
                        </div>
                        <div class="wn-hist-item-actions">
                            <a href="{{ url('/movie/3') }}" class="wn-hist-action-btn wn-hist-rewatch">
                                ▶ Continue
                            </a>
                            <button class="wn-hist-action-btn wn-hist-del" onclick="removeHistoryItem(this, 4)">
                                ✕ Remove
                            </button>
                        </div>
                    </div>
                </div>

            </div>{{-- /March 15 --}}

        </div>{{-- /historyList --}}

    </div>{{-- /container --}}

    {{-- ── CLEAR ALL MODAL ── --}}
    <div class="wn-modal-backdrop" id="clearModal" style="display:none;" onclick="closeClearModal(event)">
        <div class="wn-modal-box" style="max-width:420px;text-align:center;">
            <div style="font-size:2.5rem;margin-bottom:16px;">🗑️</div>
            <h3 class="wn-modal-title">Clear Watch History?</h3>
            <p style="color:#b0b0b0;font-size:0.9rem;margin:12px 0 28px;">
                This will remove all titles from your watch history. This cannot be undone.
            </p>
            <div style="display:flex;gap:12px;justify-content:center;">
                <button onclick="hideClearModal()" class="wn-plan-btn wn-plan-btn-outline" style="max-width:130px;">Cancel</button>
                <button onclick="clearAllHistory()" class="wn-plan-btn wn-plan-btn-primary" style="max-width:180px;background:#dc2626;border-color:#dc2626;">
                    Yes, Clear All
                </button>
            </div>
        </div>
    </div>

</div>{{-- /page --}}


@push('styles')
<style>
.wn-history-page { min-height:100vh; background:var(--wn-dark); padding-bottom:80px; }

/* Header */
.wn-hist-header { background:linear-gradient(180deg,#0a0a0a 0%,var(--wn-dark) 100%); border-bottom:1px solid var(--wn-border); padding:100px 0 28px; }
.wn-hist-header-inner { display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:20px; }
.wn-hist-title { font-size:clamp(1.6rem,3vw,2.4rem); font-weight:700; color:var(--wn-white); letter-spacing:-0.02em; margin:0 0 6px; }
.wn-hist-subtitle { color:var(--wn-muted); font-size:0.9rem; margin:0; }
.wn-hist-count { color:var(--wn-text); font-weight:600; }
.wn-hist-controls { display:flex; align-items:center; gap:12px; }
.wn-fav-select-wrap { position:relative; }
.wn-fav-select { appearance:none; background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); padding:8px 36px 8px 14px; border-radius:6px; font-size:0.85rem; cursor:pointer; }
.wn-fav-select:focus { border-color:var(--wn-red); outline:none; }
.wn-select-arrow { position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--wn-muted); pointer-events:none; }
.wn-clear-btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; background:transparent; border:1px solid rgba(220,38,38,0.3); color:#ff6b6b; border-radius:6px; font-size:0.85rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
.wn-clear-btn:hover { background:rgba(220,38,38,0.1); border-color:#dc2626; }

/* Container */
.wn-hist-container { padding-top:36px; }

/* Empty */
.wn-hist-empty { text-align:center; padding:80px 20px; }
.wn-hist-empty-icon { font-size:4rem; margin-bottom:20px; }
.wn-empty-title { color:var(--wn-white); font-size:1.5rem; margin:0 0 12px; }
.wn-empty-text { color:#b0b0b0; font-size:0.95rem; margin:0 0 28px; }
.wn-browse-btn { display:inline-block; padding:12px 32px; background:var(--wn-red); color:var(--wn-white); border-radius:8px; text-decoration:none; font-weight:700; transition:opacity 0.2s,transform 0.15s; }
.wn-browse-btn:hover { opacity:0.85; transform:translateY(-2px); color:var(--wn-white); }

/* Date group */
.wn-hist-date-group { margin-bottom:40px; animation:wn-fadein 0.4s ease both; }
.wn-hist-date-label { font-size:0.82rem; font-weight:700; color:var(--wn-muted); text-transform:uppercase; letter-spacing:0.1em; margin:0 0 16px; display:flex; align-items:center; gap:10px; }
.wn-date-dot { width:8px; height:8px; background:var(--wn-red); border-radius:50%; flex-shrink:0; }

/* History item */
.wn-hist-item { display:flex; gap:16px; background:var(--wn-card); border:1px solid var(--wn-border); border-radius:12px; padding:16px; margin-bottom:12px; transition:border-color 0.2s,transform 0.2s,box-shadow 0.2s; animation:wn-fadein 0.35s ease both; }
.wn-hist-item:hover { border-color:var(--wn-red); transform:translateX(4px); box-shadow:0 4px 20px rgba(0,0,0,0.3); }
.wn-hist-item.removing { animation:wn-slideout 0.35s ease forwards; }

/* Poster */
.wn-hist-poster-wrap { position:relative; flex-shrink:0; width:80px; border-radius:8px; overflow:hidden; }
.wn-hist-poster { width:100%; aspect-ratio:2/3; object-fit:cover; display:block; }
.wn-hist-play-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.55); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity 0.2s; color:white; text-decoration:none; border-radius:8px; }
.wn-hist-item:hover .wn-hist-play-overlay { opacity:1; }

/* Info */
.wn-hist-info { flex:1; display:flex; flex-direction:column; gap:10px; min-width:0; }
.wn-hist-top { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; }
.wn-hist-item-title { font-size:1rem; font-weight:700; color:var(--wn-white); margin:0 0 6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.wn-hist-meta { display:flex; align-items:center; gap:6px; flex-wrap:wrap; font-size:0.8rem; color:var(--wn-muted); margin-bottom:4px; }
.wn-hist-type-badge { font-size:0.68rem; font-weight:700; padding:2px 7px; border-radius:4px; }
.wn-type-movie { background:rgba(229,9,20,0.85); color:#fff; }
.wn-type-series { background:rgba(59,130,246,0.85); color:#fff; }
.wn-hist-rating { color:#f5c518; font-weight:600; }
.wn-hist-time { font-size:0.75rem; color:var(--wn-muted); margin:0; }
.wn-meta-dot { opacity:0.4; }

/* Remove button */
.wn-hist-remove-btn { background:transparent; border:none; color:var(--wn-muted); cursor:pointer; padding:4px; border-radius:4px; flex-shrink:0; transition:color 0.2s,background 0.2s; font-size:0.75rem; }
.wn-hist-remove-btn:hover { color:#ff6b6b; background:rgba(220,38,38,0.1); }

/* Progress bar */
.wn-hist-progress-wrap { display:flex; align-items:center; gap:10px; }
.wn-hist-progress-bar { flex:1; height:4px; background:var(--wn-border); border-radius:2px; overflow:hidden; }
.wn-hist-progress-fill { height:100%; background:linear-gradient(90deg, var(--wn-red), #ff4d57); border-radius:2px; transition:width 0.6s ease; }
.wn-hist-progress-label { font-size:0.72rem; color:var(--wn-muted); white-space:nowrap; min-width:80px; text-align:right; }

/* Action buttons */
.wn-hist-item-actions { display:flex; gap:8px; }
.wn-hist-action-btn { padding:6px 16px; border-radius:6px; font-size:0.78rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:opacity 0.2s,transform 0.15s; display:inline-flex; align-items:center; gap:4px; }
.wn-hist-action-btn:hover { opacity:0.85; transform:translateY(-1px); }
.wn-hist-rewatch { background:var(--wn-red); color:var(--wn-white); }
.wn-hist-del { background:var(--wn-border); color:var(--wn-muted); }
.wn-hist-del:hover { background:#3a1010; color:#ff6b6b; }

/* Modal */
.wn-modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:1050; display:flex; align-items:center; justify-content:center; padding:20px; animation:wn-fadein 0.2s ease; }
.wn-modal-box { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:16px; padding:40px 36px; width:100%; position:relative; animation:wn-slideup 0.3s ease; }
.wn-modal-title { font-size:1.3rem; font-weight:700; color:var(--wn-white); margin:0; }

@keyframes wn-fadein { from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)} }
@keyframes wn-slideout { to{opacity:0;transform:translateX(-20px)} }
@keyframes wn-slideup { from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)} }

@media(max-width:768px) { .wn-hist-header-inner{flex-direction:column;align-items:flex-start} .wn-hist-item{flex-direction:column} .wn-hist-poster-wrap{width:100%;max-width:120px} }
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() { updateCount(); });

function updateCount() {
    const items = document.querySelectorAll('.wn-hist-item');
    document.getElementById('histCount').textContent = items.length;
    document.getElementById('emptyState').style.display = items.length === 0 ? 'block' : 'none';
}

function filterHistory(period) {
    const groups = document.querySelectorAll('.wn-hist-date-group');
    groups.forEach(function(group) {
        const periods = group.dataset.period || '';
        if (period === 'all' || periods.includes(period)) {
            group.style.display = '';
        } else {
            group.style.display = 'none';
        }
    });
}

function removeHistoryItem(btn, itemId) {
    const item = btn.closest('.wn-hist-item');
    if (!item) return;
    item.classList.add('removing');
    item.addEventListener('animationend', function() {
        item.remove();
        updateCount();
    }, { once: true });
    // TODO: Backend → POST /history/remove with item_id
}

function confirmClear() {
    document.getElementById('clearModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function hideClearModal() {
    document.getElementById('clearModal').style.display = 'none';
    document.body.style.overflow = '';
}
function closeClearModal(e) {
    if (e.target === document.getElementById('clearModal')) hideClearModal();
}
function clearAllHistory() {
    const items = document.querySelectorAll('.wn-hist-item');
    items.forEach(function(item) { item.remove(); });
    hideClearModal();
    updateCount();
    // TODO: Backend → POST /history/clear
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') hideClearModal(); });
</script>
@endpush

@endsection