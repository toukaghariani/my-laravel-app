@extends('layouts.app')

@section('title', 'Admin — Videos List')

@section('content')

{{-- ============================================================
     ADMIN VIDEOS LIST — WolfNet
     Backend TODO:
       - Route: GET /admin/videos → AdminVideoController@index
       - Pass $videos (paginated collection)
       - Each video: id, title, type, genre, year, rating,
         duration, status (published/draft), views, created_at
     ============================================================ --}}

<div class="wn-admin-videos-page">

    {{-- ── HEADER ── --}}
    <div class="wn-av-header">
        <div class="container">
            <div class="wn-av-header-inner">
                <div>
                    <div class="wn-av-breadcrumb">
                        <a href="{{ url('/admin') }}" class="wn-av-bread-link">
                            <i class="bi bi-speedometer2"></i> Admin
                        </a>
                        <span class="wn-av-bread-sep">›</span>
                        <span class="wn-av-bread-current">Videos</span>
                    </div>
                    <h1 class="wn-av-title">🎬 Videos Management</h1>
                    <p class="wn-av-subtitle">
                        <span class="wn-av-count" id="videoCount">12</span> videos total
                    </p>
                </div>
                <div class="wn-av-header-actions">
                    <a href="{{ url('/admin/videos/create') }}" class="wn-av-add-btn">
                        <i class="bi bi-plus-lg"></i> Add New Video
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MAIN CONTENT ── --}}
    <div class="container wn-av-container">

        {{-- ── FILTERS BAR ── --}}
        <div class="wn-av-filters">
            <div class="wn-av-search-wrap">
                <i class="bi bi-search wn-av-search-icon"></i>
                <input type="text"
                       class="wn-av-search-input"
                       id="videoSearch"
                       placeholder="Search videos..."
                       oninput="filterVideos()">
            </div>
            <div class="wn-av-filter-chips">
                <button class="wn-av-chip active" onclick="filterByType('all', this)">All</button>
                <button class="wn-av-chip" onclick="filterByType('movie', this)">🎬 Movies</button>
                <button class="wn-av-chip" onclick="filterByType('series', this)">📺 Series</button>
            </div>
            <div class="wn-av-filter-chips">
                <button class="wn-av-chip active-green" onclick="filterByStatus('all', this)">All Status</button>
                <button class="wn-av-chip" onclick="filterByStatus('published', this)">✅ Published</button>
                <button class="wn-av-chip" onclick="filterByStatus('draft', this)">📝 Draft</button>
            </div>
            <div class="wn-fav-select-wrap">
                <select class="wn-fav-select" onchange="sortVideos(this.value)">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="title">Title A–Z</option>
                    <option value="views">Most Viewed</option>
                    <option value="rating">Highest Rated</option>
                </select>
                <span class="wn-select-arrow">⌄</span>
            </div>
        </div>

        {{-- ── SUCCESS / ERROR ALERTS ── --}}
        @if(session('success'))
            <div class="wn-alert-success wn-alert-dismissible mb-4">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="wn-alert-close">✕</button>
            </div>
        @endif

        {{-- ── VIDEOS TABLE ── --}}
        <div class="wn-av-table-card">
            <div class="wn-av-table-wrap">
                <table class="wn-av-table" id="videosTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="wn-av-checkbox" id="selectAll"
                                       onchange="toggleSelectAll(this)">
                            </th>
                            <th>Video</th>
                            <th>Type</th>
                            <th>Genre</th>
                            <th>Year</th>
                            <th>Rating</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="videosTableBody">

                        {{-- TODO: replace with @foreach($videos as $video) --}}
                        @php
                        $videos = [
                            ['id'=>1,'title'=>'Inception','type'=>'movie','genre'=>'Sci-Fi','year'=>2010,'rating'=>8.8,'views'=>24500,'status'=>'published','duration'=>'2h 28min'],
                            ['id'=>2,'title'=>'The Dark Knight','type'=>'movie','genre'=>'Action','year'=>2008,'rating'=>9.0,'views'=>31200,'status'=>'published','duration'=>'2h 32min'],
                            ['id'=>3,'title'=>'Breaking Bad','type'=>'series','genre'=>'Crime','year'=>2008,'rating'=>9.5,'views'=>18900,'status'=>'published','duration'=>'47min/ep'],
                            ['id'=>4,'title'=>'Interstellar','type'=>'movie','genre'=>'Drama','year'=>2014,'rating'=>8.6,'views'=>15600,'status'=>'published','duration'=>'2h 49min'],
                            ['id'=>5,'title'=>'Stranger Things','type'=>'series','genre'=>'Sci-Fi','year'=>2016,'rating'=>8.7,'views'=>22100,'status'=>'published','duration'=>'51min/ep'],
                            ['id'=>6,'title'=>'Pulp Fiction','type'=>'movie','genre'=>'Crime','year'=>1994,'rating'=>8.9,'views'=>12400,'status'=>'draft','duration'=>'2h 34min'],
                            ['id'=>7,'title'=>'Dark','type'=>'series','genre'=>'Thriller','year'=>2017,'rating'=>8.8,'views'=>9800,'status'=>'published','duration'=>'60min/ep'],
                            ['id'=>8,'title'=>'The Matrix','type'=>'movie','genre'=>'Action','year'=>1999,'rating'=>8.7,'views'=>19300,'status'=>'draft','duration'=>'2h 16min'],
                            ['id'=>9,'title'=>'Money Heist','type'=>'series','genre'=>'Crime','year'=>2017,'rating'=>8.3,'views'=>28700,'status'=>'published','duration'=>'40min/ep'],
                            ['id'=>10,'title'=>'Fight Club','type'=>'movie','genre'=>'Thriller','year'=>1999,'rating'=>8.8,'views'=>11200,'status'=>'published','duration'=>'2h 19min'],
                            ['id'=>11,'title'=>'Squid Game','type'=>'series','genre'=>'Thriller','year'=>2021,'rating'=>8.0,'views'=>45000,'status'=>'published','duration'=>'32min/ep'],
                            ['id'=>12,'title'=>'Goodfellas','type'=>'movie','genre'=>'Crime','year'=>1990,'rating'=>8.7,'views'=>8900,'status'=>'draft','duration'=>'2h 26min'],
                        ];
                        @endphp

                        @foreach($videos as $v)
                        <tr class="wn-av-row"
                            data-type="{{ $v['type'] }}"
                            data-status="{{ $v['status'] }}"
                            data-title="{{ strtolower($v['title']) }}"
                            data-views="{{ $v['views'] }}"
                            data-rating="{{ $v['rating'] }}"
                            data-year="{{ $v['year'] }}">
                            <td>
                                <input type="checkbox" class="wn-av-checkbox wn-row-check" value="{{ $v['id'] }}">
                            </td>
                            <td>
                                <div class="wn-av-video-cell">
                                    <div class="wn-av-thumb">
                                        <img src="https://via.placeholder.com/60x40/1c1c1c/e50914?text={{ urlencode(substr($v['title'],0,3)) }}"
                                             alt="{{ $v['title'] }}">
                                        <div class="wn-av-thumb-overlay">
                                            <i class="bi bi-play-fill"></i>
                                        </div>
                                    </div>
                                    <div class="wn-av-video-info">
                                        <span class="wn-av-video-title">{{ $v['title'] }}</span>
                                        <span class="wn-av-video-duration">{{ $v['duration'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="wn-av-type-badge {{ $v['type'] === 'movie' ? 'wn-type-movie' : 'wn-type-series' }}">
                                    {{ $v['type'] === 'movie' ? '🎬 Movie' : '📺 Series' }}
                                </span>
                            </td>
                            <td class="wn-av-genre">{{ $v['genre'] }}</td>
                            <td class="wn-av-year">{{ $v['year'] }}</td>
                            <td>
                                <span class="wn-av-rating">⭐ {{ $v['rating'] }}</span>
                            </td>
                            <td class="wn-av-views">{{ number_format($v['views']) }}</td>
                            <td>
                                <span class="wn-av-status-badge {{ $v['status'] === 'published' ? 'wn-status-pub' : 'wn-status-draft' }}">
                                    {{ $v['status'] === 'published' ? '✅ Published' : '📝 Draft' }}
                                </span>
                            </td>
                            <td>
                                <div class="wn-av-actions">
                                    {{-- View --}}
                                    <a href="{{ url('/watch/' . $v['id']) }}"
                                       class="wn-av-action-btn wn-av-btn-view"
                                       title="Preview" target="_blank">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ url('/admin/videos/' . $v['id'] . '/edit') }}"
                                       class="wn-av-action-btn wn-av-btn-edit"
                                       title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    {{-- Toggle status --}}
                                    <button class="wn-av-action-btn wn-av-btn-status"
                                            onclick="toggleStatus(this, {{ $v['id'] }}, '{{ $v['status'] }}')"
                                            title="{{ $v['status'] === 'published' ? 'Unpublish' : 'Publish' }}">
                                        <i class="bi bi-{{ $v['status'] === 'published' ? 'eye-slash' : 'check-circle' }}-fill"></i>
                                    </button>
                                    {{-- Delete --}}
                                    <button class="wn-av-action-btn wn-av-btn-delete"
                                            onclick="confirmDelete({{ $v['id'] }}, '{{ $v['title'] }}')"
                                            title="Delete">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- ── BULK ACTIONS ── --}}
            <div class="wn-av-bulk-bar" id="bulkBar" style="display:none;">
                <span class="wn-av-bulk-count"><span id="selectedCount">0</span> selected</span>
                <div class="wn-av-bulk-actions">
                    <button class="wn-av-bulk-btn wn-bulk-publish" onclick="bulkAction('publish')">
                        <i class="bi bi-check-circle"></i> Publish All
                    </button>
                    <button class="wn-av-bulk-btn wn-bulk-draft" onclick="bulkAction('draft')">
                        <i class="bi bi-eye-slash"></i> Set as Draft
                    </button>
                    <button class="wn-av-bulk-btn wn-bulk-delete" onclick="bulkAction('delete')">
                        <i class="bi bi-trash3"></i> Delete All
                    </button>
                </div>
            </div>

            {{-- ── PAGINATION ── --}}
            <div class="wn-av-pagination">
                <span class="wn-av-page-info">Showing <strong id="showingCount">12</strong> of <strong>12</strong> videos</span>
                <div class="wn-av-page-btns">
                    <button class="wn-av-page-btn" disabled>‹ Prev</button>
                    <button class="wn-av-page-btn wn-page-active">1</button>
                    <button class="wn-av-page-btn">2</button>
                    <button class="wn-av-page-btn">Next ›</button>
                </div>
            </div>

        </div>{{-- /table card --}}
    </div>{{-- /container --}}

</div>{{-- /page --}}


{{-- ── DELETE CONFIRM MODAL ── --}}
<div class="wn-modal-backdrop" id="deleteModal" style="display:none;" onclick="closeDeleteModal(event)">
    <div class="wn-modal-box" style="max-width:420px;text-align:center;">
        <div style="font-size:2.5rem;margin-bottom:16px;">🗑️</div>
        <h3 class="wn-modal-title">Delete Video?</h3>
        <p style="color:#b0b0b0;font-size:0.9rem;margin:12px 0 28px;">
            Are you sure you want to delete <strong id="deleteVideoTitle" style="color:white;"></strong>?
            This cannot be undone.
        </p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="hideDeleteModal()" class="wn-plan-btn wn-plan-btn-outline" style="max-width:130px;">Cancel</button>
            {{-- TODO: wire to DELETE /admin/videos/{id} --}}
            <button id="confirmDeleteBtn" class="wn-plan-btn wn-plan-btn-primary"
                    style="max-width:160px;background:#dc2626;border-color:#dc2626;"
                    onclick="deleteVideo()">
                Yes, Delete
            </button>
        </div>
    </div>
</div>


@push('styles')
<style>
/* ── Page ── */
.wn-admin-videos-page { min-height:100vh; background:var(--wn-dark); padding-bottom:80px; }

/* ── Header ── */
.wn-av-header { background:linear-gradient(180deg,#0a0a0a 0%,var(--wn-dark) 100%); border-bottom:1px solid var(--wn-border); padding:100px 0 28px; }
.wn-av-header-inner { display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:20px; }
.wn-av-breadcrumb { display:flex; align-items:center; gap:8px; font-size:0.82rem; margin-bottom:10px; }
.wn-av-bread-link { color:var(--wn-muted); text-decoration:none; transition:color 0.2s; }
.wn-av-bread-link:hover { color:var(--wn-red); }
.wn-av-bread-sep { color:var(--wn-border); }
.wn-av-bread-current { color:var(--wn-text); }
.wn-av-title { font-size:clamp(1.6rem,3vw,2.2rem); font-weight:800; color:var(--wn-white); letter-spacing:-0.02em; margin:0 0 6px; }
.wn-av-subtitle { color:var(--wn-muted); font-size:0.9rem; margin:0; }
.wn-av-count { color:var(--wn-white); font-weight:700; }
.wn-av-add-btn { display:inline-flex; align-items:center; gap:8px; background:var(--wn-red); color:white; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:700; font-size:0.9rem; transition:opacity 0.2s, transform 0.15s; }
.wn-av-add-btn:hover { opacity:0.88; transform:translateY(-2px); color:white; }

/* ── Container ── */
.wn-av-container { padding-top:32px; }

/* ── Filters ── */
.wn-av-filters { display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:24px; }
.wn-av-search-wrap { position:relative; flex:1; min-width:200px; }
.wn-av-search-icon { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--wn-muted); font-size:0.9rem; }
.wn-av-search-input { width:100%; background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); padding:9px 14px 9px 36px; border-radius:8px; font-size:0.85rem; outline:none; transition:border-color 0.2s; }
.wn-av-search-input:focus { border-color:var(--wn-red); }
.wn-av-filter-chips { display:flex; gap:6px; }
.wn-av-chip { background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-muted); padding:6px 14px; border-radius:20px; font-size:0.78rem; font-weight:600; cursor:pointer; transition:all 0.2s; white-space:nowrap; }
.wn-av-chip:hover { border-color:var(--wn-red); color:var(--wn-text); }
.wn-av-chip.active { background:var(--wn-red); border-color:var(--wn-red); color:white; }
.wn-av-chip.active-green { background:#22c55e; border-color:#22c55e; color:white; }
.wn-fav-select-wrap { position:relative; }
.wn-fav-select { appearance:none; background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); padding:8px 32px 8px 14px; border-radius:6px; font-size:0.82rem; cursor:pointer; }
.wn-fav-select:focus { border-color:var(--wn-red); outline:none; }
.wn-select-arrow { position:absolute; right:10px; top:50%; transform:translateY(-50%); color:var(--wn-muted); pointer-events:none; }

/* ── Table card ── */
.wn-av-table-card { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:14px; overflow:hidden; }
.wn-av-table-wrap { overflow-x:auto; }
.wn-av-table { width:100%; border-collapse:collapse; font-size:0.85rem; }
.wn-av-table thead tr { background:#111; }
.wn-av-table th { padding:14px 16px; text-align:left; color:var(--wn-muted); font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; border-bottom:1px solid var(--wn-border); white-space:nowrap; }
.wn-av-table td { padding:14px 16px; border-bottom:1px solid rgba(42,42,42,0.5); vertical-align:middle; }
.wn-av-table tr:last-child td { border-bottom:none; }
.wn-av-table tbody tr:hover td { background:rgba(255,255,255,0.02); }
.wn-av-row.hidden { display:none; }

/* Checkbox */
.wn-av-checkbox { width:16px; height:16px; accent-color:var(--wn-red); cursor:pointer; }

/* Video cell */
.wn-av-video-cell { display:flex; align-items:center; gap:12px; }
.wn-av-thumb { position:relative; width:60px; flex-shrink:0; border-radius:6px; overflow:hidden; }
.wn-av-thumb img { width:100%; aspect-ratio:16/9; object-fit:cover; display:block; }
.wn-av-thumb-overlay { position:absolute; inset:0; background:rgba(0,0,0,0.5); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity 0.2s; color:white; font-size:0.9rem; }
.wn-av-row:hover .wn-av-thumb-overlay { opacity:1; }
.wn-av-video-info { display:flex; flex-direction:column; gap:3px; }
.wn-av-video-title { font-weight:700; color:var(--wn-white); font-size:0.88rem; }
.wn-av-video-duration { font-size:0.72rem; color:var(--wn-muted); }

/* Badges */
.wn-av-type-badge { font-size:0.72rem; font-weight:700; padding:3px 10px; border-radius:10px; white-space:nowrap; }
.wn-type-movie { background:rgba(229,9,20,0.15); color:#ff6b6b; }
.wn-type-series { background:rgba(59,130,246,0.15); color:#93c5fd; }
.wn-av-status-badge { font-size:0.72rem; font-weight:700; padding:3px 10px; border-radius:10px; white-space:nowrap; }
.wn-status-pub { background:rgba(34,197,94,0.15); color:#22c55e; }
.wn-status-draft { background:rgba(245,197,24,0.15); color:#f5c518; }
.wn-av-rating { color:#f5c518; font-weight:700; font-size:0.82rem; }
.wn-av-genre, .wn-av-year { color:var(--wn-muted); }
.wn-av-views { color:var(--wn-text); font-weight:600; }

/* Action buttons */
.wn-av-actions { display:flex; gap:6px; }
.wn-av-action-btn { width:32px; height:32px; border:none; border-radius:6px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:0.8rem; transition:all 0.2s; text-decoration:none; }
.wn-av-btn-view { background:rgba(59,130,246,0.15); color:#3b82f6; }
.wn-av-btn-view:hover { background:rgba(59,130,246,0.3); color:#60a5fa; }
.wn-av-btn-edit { background:rgba(245,197,24,0.15); color:#f5c518; }
.wn-av-btn-edit:hover { background:rgba(245,197,24,0.3); }
.wn-av-btn-status { background:rgba(34,197,94,0.15); color:#22c55e; }
.wn-av-btn-status:hover { background:rgba(34,197,94,0.3); }
.wn-av-btn-delete { background:rgba(220,38,38,0.15); color:#ff6b6b; }
.wn-av-btn-delete:hover { background:rgba(220,38,38,0.3); }

/* ── Bulk bar ── */
.wn-av-bulk-bar { display:flex; align-items:center; gap:16px; padding:14px 20px; background:rgba(229,9,20,0.08); border-top:1px solid rgba(229,9,20,0.2); flex-wrap:wrap; }
.wn-av-bulk-count { color:var(--wn-red); font-weight:700; font-size:0.88rem; }
.wn-av-bulk-actions { display:flex; gap:8px; }
.wn-av-bulk-btn { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:6px; font-size:0.78rem; font-weight:700; cursor:pointer; border:none; transition:opacity 0.2s; }
.wn-bulk-publish { background:#22c55e; color:white; }
.wn-bulk-draft { background:#f5c518; color:#000; }
.wn-bulk-delete { background:#dc2626; color:white; }
.wn-av-bulk-btn:hover { opacity:0.85; }

/* ── Pagination ── */
.wn-av-pagination { display:flex; align-items:center; justify-content:space-between; padding:16px 20px; border-top:1px solid var(--wn-border); flex-wrap:wrap; gap:12px; }
.wn-av-page-info { color:var(--wn-muted); font-size:0.82rem; }
.wn-av-page-info strong { color:var(--wn-white); }
.wn-av-page-btns { display:flex; gap:6px; }
.wn-av-page-btn { background:var(--wn-border); border:none; color:var(--wn-text); padding:6px 12px; border-radius:6px; font-size:0.82rem; cursor:pointer; transition:background 0.2s; }
.wn-av-page-btn:hover:not(:disabled) { background:var(--wn-red); color:white; }
.wn-av-page-btn:disabled { opacity:0.4; cursor:not-allowed; }
.wn-av-page-btn.wn-page-active { background:var(--wn-red); color:white; }

/* ── Alerts ── */
.wn-alert-dismissible { display:flex; align-items:center; justify-content:space-between; border-radius:8px; padding:12px 16px; font-size:0.88rem; }
.wn-alert-close { background:none; border:none; color:inherit; opacity:0.7; cursor:pointer; }

/* ── Modal ── */
.wn-modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:1050; display:flex; align-items:center; justify-content:center; padding:20px; animation:wn-fadein 0.2s ease; }
.wn-modal-box { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:16px; padding:40px 36px; width:100%; position:relative; animation:wn-slideup 0.3s ease; }
.wn-modal-title { font-size:1.3rem; font-weight:700; color:var(--wn-white); margin:0; }

@keyframes wn-fadein { from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)} }
@keyframes wn-slideup { from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)} }

@media(max-width:768px) { .wn-av-header-inner{flex-direction:column;align-items:flex-start} .wn-av-filters{flex-direction:column;align-items:stretch} .wn-av-filter-chips{flex-wrap:wrap} }
</style>
@endpush


@push('scripts')
<script>
let deleteTargetId = null;

/* ── Search filter ── */
function filterVideos() {
    const q = document.getElementById('videoSearch').value.toLowerCase();
    let visible = 0;
    document.querySelectorAll('.wn-av-row').forEach(function(row) {
        const title = row.dataset.title || '';
        const show = title.includes(q);
        row.classList.toggle('hidden', !show);
        if (show) visible++;
    });
    document.getElementById('showingCount').textContent = visible;
}

/* ── Filter by type ── */
function filterByType(type, btn) {
    document.querySelectorAll('.wn-av-filter-chips .wn-av-chip').forEach(c => {
        if (c.onclick && c.onclick.toString().includes('filterByType')) c.classList.remove('active');
    });
    btn.classList.add('active');
    let visible = 0;
    document.querySelectorAll('.wn-av-row').forEach(function(row) {
        const show = type === 'all' || row.dataset.type === type;
        row.classList.toggle('hidden', !show);
        if (show) visible++;
    });
    document.getElementById('showingCount').textContent = visible;
}

/* ── Filter by status ── */
function filterByStatus(status, btn) {
    document.querySelectorAll('.wn-av-filter-chips .wn-av-chip').forEach(c => {
        if (c.onclick && c.onclick.toString().includes('filterByStatus')) c.classList.remove('active', 'active-green');
    });
    btn.classList.add(status === 'published' ? 'active' : status === 'all' ? 'active-green' : 'active');
    document.querySelectorAll('.wn-av-row').forEach(function(row) {
        const show = status === 'all' || row.dataset.status === status;
        row.classList.toggle('hidden', !show);
    });
}

/* ── Sort videos ── */
function sortVideos(criterion) {
    const tbody = document.getElementById('videosTableBody');
    const rows = Array.from(tbody.querySelectorAll('.wn-av-row'));
    rows.sort(function(a, b) {
        if (criterion === 'title')   return a.dataset.title.localeCompare(b.dataset.title);
        if (criterion === 'views')   return parseInt(b.dataset.views) - parseInt(a.dataset.views);
        if (criterion === 'rating')  return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        if (criterion === 'newest')  return parseInt(b.dataset.year) - parseInt(a.dataset.year);
        if (criterion === 'oldest')  return parseInt(a.dataset.year) - parseInt(b.dataset.year);
        return 0;
    });
    rows.forEach(row => tbody.appendChild(row));
}

/* ── Select all ── */
function toggleSelectAll(checkbox) {
    document.querySelectorAll('.wn-row-check').forEach(cb => cb.checked = checkbox.checked);
    updateBulkBar();
}

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('wn-row-check')) updateBulkBar();
});

function updateBulkBar() {
    const checked = document.querySelectorAll('.wn-row-check:checked');
    const bulkBar = document.getElementById('bulkBar');
    document.getElementById('selectedCount').textContent = checked.length;
    bulkBar.style.display = checked.length > 0 ? 'flex' : 'none';
}

/* ── Bulk actions ── */
function bulkAction(action) {
    const checked = document.querySelectorAll('.wn-row-check:checked');
    const ids = Array.from(checked).map(cb => cb.value);
    if (action === 'delete') {
        if (!confirm('Delete ' + ids.length + ' selected videos?')) return;
        checked.forEach(cb => cb.closest('tr').remove());
    } else {
        checked.forEach(function(cb) {
            const row = cb.closest('tr');
            row.dataset.status = action === 'publish' ? 'published' : 'draft';
            const badge = row.querySelector('.wn-av-status-badge');
            if (action === 'publish') {
                badge.className = 'wn-av-status-badge wn-status-pub';
                badge.textContent = '✅ Published';
            } else {
                badge.className = 'wn-av-status-badge wn-status-draft';
                badge.textContent = '📝 Draft';
            }
        });
    }
    document.getElementById('selectAll').checked = false;
    updateBulkBar();
    // TODO: Backend → POST /admin/videos/bulk with ids and action
}

/* ── Toggle status ── */
function toggleStatus(btn, id, currentStatus) {
    const row = btn.closest('tr');
    const badge = row.querySelector('.wn-av-status-badge');
    if (currentStatus === 'published') {
        btn.title = 'Publish';
        btn.querySelector('i').className = 'bi bi-check-circle-fill';
        badge.className = 'wn-av-status-badge wn-status-draft';
        badge.textContent = '📝 Draft';
        btn.onclick = function() { toggleStatus(btn, id, 'draft'); };
        row.dataset.status = 'draft';
    } else {
        btn.title = 'Unpublish';
        btn.querySelector('i').className = 'bi bi-eye-slash-fill';
        badge.className = 'wn-av-status-badge wn-status-pub';
        badge.textContent = '✅ Published';
        btn.onclick = function() { toggleStatus(btn, id, 'published'); };
        row.dataset.status = 'published';
    }
    // TODO: Backend → POST /admin/videos/{id}/toggle-status
}

/* ── Delete modal ── */
function confirmDelete(id, title) {
    deleteTargetId = id;
    document.getElementById('deleteVideoTitle').textContent = title;
    document.getElementById('deleteModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    document.body.style.overflow = '';
    deleteTargetId = null;
}
function closeDeleteModal(e) {
    if (e.target === document.getElementById('deleteModal')) hideDeleteModal();
}
function deleteVideo() {
    if (!deleteTargetId) return;
    // Remove row from table
    const row = document.querySelector('.wn-row-check[value="' + deleteTargetId + '"]')?.closest('tr');
    if (row) {
        row.style.animation = 'wn-fadein 0.3s ease reverse forwards';
        setTimeout(() => { row.remove(); }, 300);
    }
    hideDeleteModal();
    // TODO: Backend → DELETE /admin/videos/{id}
    console.log('Delete video id:', deleteTargetId);
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') hideDeleteModal(); });
</script>
@endpush

@endsection