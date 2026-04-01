@extends('layouts.app')

@section('title', 'Admin — Edit Video')

@section('content')

{{-- ============================================================
     ADMIN EDIT VIDEO FORM — WolfNet
     Backend TODO:
       - Route: GET /admin/videos/{id}/edit → AdminVideoController@edit
       - Route: PUT /admin/videos/{id} → AdminVideoController@update
       - Pass $video object with all fields
     ============================================================ --}}

<div class="wn-admin-form-page">

    {{-- ── HEADER ── --}}
    <div class="wn-av-header">
        <div class="container">
            <div class="wn-av-header-inner">
                <div>
                    <div class="wn-av-breadcrumb">
                        <a href="{{ url('/admin') }}" class="wn-av-bread-link"><i class="bi bi-speedometer2"></i> Admin</a>
                        <span class="wn-av-bread-sep">›</span>
                        <a href="{{ url('/admin/videos') }}" class="wn-av-bread-link">Videos</a>
                        <span class="wn-av-bread-sep">›</span>
                        {{-- TODO: <span class="wn-av-bread-current">Edit: {{ $video->title }}</span> --}}
                        <span class="wn-av-bread-current">Edit: Inception</span>
                    </div>
                    <h1 class="wn-av-title">✏️ Edit Video</h1>
                    <p class="wn-av-subtitle">Update the details for this video</p>
                </div>
                <div class="wn-av-header-actions-row">
                    <a href="{{ url('/watch/1') }}" class="wn-av-preview-btn" target="_blank">
                        <i class="bi bi-eye-fill"></i> Preview
                    </a>
                    <a href="{{ url('/admin/videos') }}" class="wn-av-back-btn">
                        <i class="bi bi-arrow-left"></i> Back to Videos
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── FORM ── --}}
    <div class="container wn-av-container">

        {{-- TODO: action="{{ route('admin.videos.update', $video->id) }}" --}}
        <form method="POST" action="{{ url('/admin/videos/1') }}"
              enctype="multipart/form-data" id="editVideoForm">
            @csrf
            @method('PUT')

            <div class="wn-form-layout">

                {{-- ── LEFT: MAIN INFO ── --}}
                <div class="wn-form-main">

                    {{-- Basic Info --}}
                    <div class="wn-form-card">
                        <h3 class="wn-form-card-title">
                            <i class="bi bi-info-circle-fill"></i> Basic Information
                        </h3>

                        <div class="wn-form-group">
                            <label class="wn-form-label">Title <span class="wn-required">*</span></label>
                            {{-- TODO: value="{{ $video->title }}" --}}
                            <input type="text" name="title" class="wn-input"
                                   placeholder="Enter movie or series title" required
                                   value="{{ old('title', 'Inception') }}">
                        </div>

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">Type <span class="wn-required">*</span></label>
                                <select name="type" class="wn-input" required id="typeSelect" onchange="toggleSeriesFields()">
                                    {{-- TODO: selected based on $video->type --}}
                                    <option value="movie" selected>🎬 Movie</option>
                                    <option value="series">📺 Series</option>
                                </select>
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Genre <span class="wn-required">*</span></label>
                                <select name="genre" class="wn-input" required>
                                    <option value="action">Action</option>
                                    <option value="drama">Drama</option>
                                    <option value="comedy">Comedy</option>
                                    <option value="scifi" selected>Sci-Fi</option>
                                    <option value="thriller">Thriller</option>
                                    <option value="crime">Crime</option>
                                    <option value="horror">Horror</option>
                                    <option value="romance">Romance</option>
                                    <option value="documentary">Documentary</option>
                                    <option value="animation">Animation</option>
                                </select>
                            </div>
                        </div>

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">Release Year <span class="wn-required">*</span></label>
                                <input type="number" name="year" class="wn-input"
                                       min="1900" max="2030" required
                                       value="{{ old('year', 2010) }}">
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Duration</label>
                                <input type="text" name="duration" class="wn-input"
                                       value="{{ old('duration', '2h 28min') }}">
                            </div>
                        </div>

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">IMDb Rating</label>
                                <input type="number" name="rating" class="wn-input"
                                       min="0" max="10" step="0.1"
                                       value="{{ old('rating', 8.8) }}">
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Language</label>
                                <select name="language" class="wn-input">
                                    <option value="english" selected>English</option>
                                    <option value="french">French</option>
                                    <option value="arabic">Arabic</option>
                                    <option value="spanish">Spanish</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="wn-form-group">
                            <label class="wn-form-label">Description <span class="wn-required">*</span></label>
                            <textarea name="description" class="wn-input wn-textarea" rows="4" required>{{ old('description', 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.') }}</textarea>
                        </div>

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">Director</label>
                                <input type="text" name="director" class="wn-input"
                                       value="{{ old('director', 'Christopher Nolan') }}">
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Age Rating</label>
                                <select name="age_rating" class="wn-input">
                                    <option value="G">G — All Ages</option>
                                    <option value="PG">PG</option>
                                    <option value="PG-13" selected>PG-13</option>
                                    <option value="R">R</option>
                                    <option value="NC-17">NC-17</option>
                                </select>
                            </div>
                        </div>

                        <div class="wn-form-group">
                            <label class="wn-form-label">Cast</label>
                            <input type="text" name="cast" class="wn-input"
                                   value="{{ old('cast', 'Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page, Tom Hardy') }}">
                            <span class="wn-field-hint">Separate names with commas</span>
                        </div>
                    </div>

                    {{-- Series fields --}}
                    <div class="wn-form-card" id="seriesFields" style="display:none;">
                        <h3 class="wn-form-card-title">
                            <i class="bi bi-collection-play-fill"></i> Series Details
                        </h3>
                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">Number of Seasons</label>
                                <input type="number" name="seasons" class="wn-input" placeholder="1" min="1">
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Total Episodes</label>
                                <input type="number" name="episodes" class="wn-input" placeholder="10" min="1">
                            </div>
                        </div>
                    </div>

                    {{-- Video Files --}}
                    <div class="wn-form-card">
                        <h3 class="wn-form-card-title">
                            <i class="bi bi-camera-video-fill"></i> Video & Trailer
                        </h3>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Video URL</label>
                            <input type="url" name="video_url" class="wn-input"
                                   placeholder="https://..."
                                   value="{{ old('video_url') }}">
                            <span class="wn-field-hint">Leave blank to keep current video</span>
                        </div>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Trailer URL (YouTube Embed)</label>
                            <input type="url" name="trailer_url" class="wn-input"
                                   placeholder="https://www.youtube.com/embed/..."
                                   value="{{ old('trailer_url', 'https://www.youtube.com/embed/YoHD9XEInc0') }}">
                        </div>
                    </div>

                    {{-- Danger zone --}}
                    <div class="wn-form-card wn-danger-card">
                        <h3 class="wn-form-card-title wn-danger-title">
                            <i class="bi bi-exclamation-triangle-fill"></i> Danger Zone
                        </h3>
                        <p class="wn-danger-text">Deleting this video is permanent and cannot be undone.</p>
                        <button type="button" class="wn-danger-btn" onclick="confirmDelete()">
                            <i class="bi bi-trash3-fill me-1"></i> Delete This Video
                        </button>
                    </div>

                </div>{{-- /form main --}}

                {{-- ── RIGHT: SIDEBAR ── --}}
                <div class="wn-form-sidebar">

                    {{-- Publish settings --}}
                    <div class="wn-form-card">
                        <h3 class="wn-form-card-title">
                            <i class="bi bi-gear-fill"></i> Publish Settings
                        </h3>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Status</label>
                            {{-- TODO: selected="{{ $video->status }}" --}}
                            <select name="status" class="wn-input">
                                <option value="published" selected>✅ Published</option>
                                <option value="draft">📝 Draft</option>
                            </select>
                        </div>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Access Level</label>
                            <select name="access" class="wn-input">
                                <option value="free">🆓 Free</option>
                                <option value="premium" selected>👑 Premium Only</option>
                            </select>
                        </div>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Featured</label>
                            <div class="wn-toggle-row">
                                <span class="wn-toggle-text">Show on homepage</span>
                                <label class="wn-switch">
                                    <input type="checkbox" name="featured" value="1" checked>
                                    <span class="wn-switch-slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Trending</label>
                            <div class="wn-toggle-row">
                                <span class="wn-toggle-text">Show in trending</span>
                                <label class="wn-switch">
                                    <input type="checkbox" name="trending" value="1">
                                    <span class="wn-switch-slider"></span>
                                </label>
                            </div>
                        </div>

                        {{-- Stats --}}
                        <div class="wn-edit-stats">
                            <div class="wn-edit-stat">
                                <span class="wn-edit-stat-num">24,500</span>
                                <span class="wn-edit-stat-label">Total Views</span>
                            </div>
                            <div class="wn-edit-stat">
                                <span class="wn-edit-stat-num">1,240</span>
                                <span class="wn-edit-stat-label">Favorites</span>
                            </div>
                            <div class="wn-edit-stat">
                                <span class="wn-edit-stat-num">Jan 2025</span>
                                <span class="wn-edit-stat-label">Added</span>
                            </div>
                        </div>

                        {{-- Submit buttons --}}
                        <div class="wn-form-submit-btns">
                            <button type="submit" class="wn-save-btn w-100" style="justify-content:center;">
                                <span class="wn-btn-bg"></span>
                                <span class="wn-btn-content">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>Save Changes</span>
                                </span>
                            </button>
                            <a href="{{ url('/admin/videos') }}" class="wn-reset-btn w-100" style="justify-content:center;text-decoration:none;">
                                <i class="bi bi-x-circle"></i>
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>

                    {{-- Current poster --}}
                    <div class="wn-form-card">
                        <h3 class="wn-form-card-title">
                            <i class="bi bi-image-fill"></i> Poster Image
                        </h3>
                        <div class="wn-current-image">
                            {{-- TODO: src="{{ $video->poster_url }}" --}}
                            <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=INCEPTION"
                                 alt="Current poster" id="posterImg">
                            <p class="wn-current-image-label">Current poster</p>
                        </div>
                        <div class="wn-upload-zone" style="margin-top:12px;" onclick="document.getElementById('posterInput').click()">
                            <div class="wn-upload-placeholder">
                                <i class="bi bi-cloud-upload"></i>
                                <p>Upload new poster</p>
                                <span>JPG, PNG — Max 2MB</span>
                            </div>
                            <input type="file" id="posterInput" name="poster" accept="image/*"
                                   style="display:none;" onchange="previewPoster(this)">
                        </div>
                        <div class="wn-form-group" style="margin-top:12px;">
                            <label class="wn-form-label">Or paste image URL</label>
                            <input type="url" name="poster_url" class="wn-input" placeholder="https://...">
                        </div>
                    </div>

                </div>{{-- /sidebar --}}
            </div>{{-- /form layout --}}
        </form>
    </div>{{-- /container --}}
</div>{{-- /page --}}


{{-- DELETE MODAL --}}
<div class="wn-modal-backdrop" id="deleteModal" style="display:none;" onclick="closeDeleteModal(event)">
    <div class="wn-modal-box" style="max-width:420px;text-align:center;">
        <div style="font-size:2.5rem;margin-bottom:16px;">🗑️</div>
        <h3 class="wn-modal-title">Delete This Video?</h3>
        <p style="color:#b0b0b0;font-size:0.9rem;margin:12px 0 28px;">
            This will permanently delete <strong style="color:white;">Inception</strong> and all its data. This cannot be undone.
        </p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="hideDeleteModal()" class="wn-plan-btn wn-plan-btn-outline" style="max-width:130px;">Cancel</button>
            <form method="POST" action="{{ url('/admin/videos/1') }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="wn-plan-btn wn-plan-btn-primary"
                        style="max-width:160px;background:#dc2626;border-color:#dc2626;">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>


@push('styles')
<style>
.wn-admin-form-page { min-height:100vh; background:var(--wn-dark); padding-bottom:80px; }
.wn-av-header { background:linear-gradient(180deg,#0a0a0a 0%,var(--wn-dark) 100%); border-bottom:1px solid var(--wn-border); padding:100px 0 28px; }
.wn-av-header-inner { display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:20px; }
.wn-av-breadcrumb { display:flex; align-items:center; gap:8px; font-size:0.82rem; margin-bottom:10px; }
.wn-av-bread-link { color:var(--wn-muted); text-decoration:none; transition:color 0.2s; }
.wn-av-bread-link:hover { color:var(--wn-red); }
.wn-av-bread-sep { color:var(--wn-border); }
.wn-av-bread-current { color:var(--wn-text); }
.wn-av-title { font-size:clamp(1.6rem,3vw,2.2rem); font-weight:800; color:var(--wn-white); letter-spacing:-0.02em; margin:0 0 6px; }
.wn-av-subtitle { color:var(--wn-muted); font-size:0.9rem; margin:0; }
.wn-av-header-actions-row { display:flex; gap:10px; align-items:center; }
.wn-av-preview-btn { display:inline-flex; align-items:center; gap:8px; background:rgba(59,130,246,0.15); border:1px solid rgba(59,130,246,0.3); color:#60a5fa; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.88rem; transition:all 0.2s; }
.wn-av-preview-btn:hover { background:rgba(59,130,246,0.25); color:#93c5fd; }
.wn-av-back-btn { display:inline-flex; align-items:center; gap:8px; background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.88rem; transition:all 0.2s; }
.wn-av-back-btn:hover { border-color:var(--wn-red); color:var(--wn-white); }
.wn-av-container { padding-top:32px; }
.wn-form-layout { display:grid; grid-template-columns:1fr 320px; gap:24px; align-items:start; }
.wn-form-card { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:14px; padding:24px; margin-bottom:20px; }
.wn-form-card-title { font-size:0.95rem; font-weight:700; color:var(--wn-white); margin:0 0 20px; display:flex; align-items:center; gap:8px; }
.wn-form-card-title i { color:var(--wn-red); }
.wn-form-group { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
.wn-form-group:last-child { margin-bottom:0; }
.wn-form-label { font-size:0.78rem; font-weight:600; color:var(--wn-muted); text-transform:uppercase; letter-spacing:0.06em; }
.wn-required { color:var(--wn-red); }
.wn-form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
.wn-textarea { resize:vertical; min-height:100px; }
.wn-field-hint { font-size:0.72rem; color:var(--wn-muted); }
.wn-toggle-row { display:flex; align-items:center; justify-content:space-between; }
.wn-toggle-text { font-size:0.85rem; color:var(--wn-text); }
.wn-switch { position:relative; width:40px; height:22px; flex-shrink:0; }
.wn-switch input { opacity:0; width:0; height:0; }
.wn-switch-slider { position:absolute; inset:0; background:var(--wn-border); border-radius:11px; cursor:pointer; transition:background 0.3s; }
.wn-switch-slider::before { content:''; position:absolute; width:16px; height:16px; left:3px; top:3px; background:white; border-radius:50%; transition:transform 0.3s; }
.wn-switch input:checked + .wn-switch-slider { background:var(--wn-red); }
.wn-switch input:checked + .wn-switch-slider::before { transform:translateX(18px); }
.wn-edit-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin:16px 0; padding:16px; background:#111; border-radius:8px; }
.wn-edit-stat { text-align:center; }
.wn-edit-stat-num { display:block; font-size:0.95rem; font-weight:800; color:var(--wn-white); }
.wn-edit-stat-label { font-size:0.68rem; color:var(--wn-muted); text-transform:uppercase; letter-spacing:0.05em; }
.wn-form-submit-btns { display:flex; flex-direction:column; gap:10px; margin-top:20px; }
.wn-save-btn { position:relative; overflow:hidden; border:none; border-radius:10px; padding:13px 24px; font-size:0.92rem; font-weight:700; cursor:pointer; background:linear-gradient(135deg,#e50914,#ff4d57); color:white; transition:transform 0.2s,box-shadow 0.2s; box-shadow:0 4px 20px rgba(229,9,20,0.4); display:flex; align-items:center; gap:8px; }
.wn-save-btn:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(229,9,20,0.55); }
.wn-btn-bg { position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,0.15),transparent); pointer-events:none; }
.wn-btn-content { position:relative; display:flex; align-items:center; gap:8px; }
.wn-reset-btn { display:inline-flex; align-items:center; gap:8px; padding:13px 24px; border-radius:10px; border:1.5px solid var(--wn-border); background:transparent; color:var(--wn-muted); font-size:0.88rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
.wn-reset-btn:hover { border-color:var(--wn-text); color:var(--wn-white); }
.wn-current-image { border-radius:8px; overflow:hidden; }
.wn-current-image img { width:100%; display:block; max-height:200px; object-fit:cover; }
.wn-current-image-label { font-size:0.72rem; color:var(--wn-muted); text-align:center; margin:6px 0 0; }
.wn-upload-zone { border:2px dashed var(--wn-border); border-radius:10px; cursor:pointer; transition:border-color 0.2s; padding:16px; text-align:center; }
.wn-upload-zone:hover { border-color:var(--wn-red); }
.wn-upload-placeholder i { font-size:1.5rem; color:var(--wn-muted); display:block; margin-bottom:6px; }
.wn-upload-placeholder p { color:var(--wn-text); font-size:0.82rem; margin:0 0 4px; font-weight:600; }
.wn-upload-placeholder span { color:var(--wn-muted); font-size:0.72rem; }
.wn-danger-card { border-color:rgba(220,38,38,0.3); background:rgba(220,38,38,0.04); }
.wn-danger-title { color:#ff6b6b !important; }
.wn-danger-title i { color:#ff6b6b !important; }
.wn-danger-text { color:#b0b0b0; font-size:0.88rem; margin-bottom:16px; }
.wn-danger-btn { background:transparent; border:1px solid rgba(220,38,38,0.4); color:#ff6b6b; padding:9px 20px; border-radius:8px; font-size:0.88rem; font-weight:600; cursor:pointer; transition:background 0.2s; }
.wn-danger-btn:hover { background:rgba(220,38,38,0.1); }
.wn-form-sidebar { position:sticky; top:80px; }
.wn-modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:1050; display:flex; align-items:center; justify-content:center; padding:20px; }
.wn-modal-box { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:16px; padding:40px 36px; width:100%; }
.wn-modal-title { font-size:1.3rem; font-weight:700; color:var(--wn-white); margin:0; }
@media(max-width:992px) { .wn-form-layout{grid-template-columns:1fr} .wn-form-sidebar{position:static} }
@media(max-width:576px) { .wn-form-row-2{grid-template-columns:1fr} .wn-av-header-actions-row{flex-direction:column} }
</style>
@endpush

@push('scripts')
<script>
function toggleSeriesFields() {
    const type = document.getElementById('typeSelect').value;
    document.getElementById('seriesFields').style.display = type === 'series' ? 'block' : 'none';
}

function previewPoster(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('posterImg').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function confirmDelete() {
    document.getElementById('deleteModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function hideDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    document.body.style.overflow = '';
}
function closeDeleteModal(e) {
    if (e.target === document.getElementById('deleteModal')) hideDeleteModal();
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') hideDeleteModal(); });
</script>
@endpush

@endsection