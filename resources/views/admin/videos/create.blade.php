@extends('layouts.app')

@section('title', 'Admin — Create Video')

@section('content')

{{-- ============================================================
     ADMIN CREATE VIDEO FORM — WolfNet
     Backend TODO:
       - Route: GET /admin/videos/create → AdminVideoController@create
       - Route: POST /admin/videos → AdminVideoController@store
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
                        <span class="wn-av-bread-current">Create New</span>
                    </div>
                    <h1 class="wn-av-title">➕ Add New Video</h1>
                    <p class="wn-av-subtitle">Fill in the details to add a new movie or series</p>
                </div>
                <a href="{{ url('/admin/videos') }}" class="wn-av-back-btn">
                    <i class="bi bi-arrow-left"></i> Back to Videos
                </a>
            </div>
        </div>
    </div>

    {{-- ── FORM ── --}}
    <div class="container wn-av-container">

        {{-- TODO: action="{{ route('admin.videos.store') }}" --}}
        <form method="POST" action="{{ url('/admin/videos') }}"
              enctype="multipart/form-data" id="createVideoForm">
            @csrf

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
                            <input type="text" name="title" class="wn-input"
                                   placeholder="Enter movie or series title" required
                                   value="{{ old('title') }}">
                            @error('title') <span class="wn-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">Type <span class="wn-required">*</span></label>
                                <select name="type" class="wn-input" required id="typeSelect" onchange="toggleSeriesFields()">
                                    <option value="">Select type</option>
                                    <option value="movie" {{ old('type') === 'movie' ? 'selected' : '' }}>🎬 Movie</option>
                                    <option value="series" {{ old('type') === 'series' ? 'selected' : '' }}>📺 Series</option>
                                </select>
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Genre <span class="wn-required">*</span></label>
                                <select name="genre" class="wn-input" required>
                                    <option value="">Select genre</option>
                                    <option value="action">Action</option>
                                    <option value="drama">Drama</option>
                                    <option value="comedy">Comedy</option>
                                    <option value="scifi">Sci-Fi</option>
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
                                       placeholder="2024" min="1900" max="2030" required
                                       value="{{ old('year') }}">
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Duration</label>
                                <input type="text" name="duration" class="wn-input"
                                       placeholder="e.g. 2h 28min or 45min/ep"
                                       value="{{ old('duration') }}">
                            </div>
                        </div>

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">IMDb Rating</label>
                                <input type="number" name="rating" class="wn-input"
                                       placeholder="8.5" min="0" max="10" step="0.1"
                                       value="{{ old('rating') }}">
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Language</label>
                                <select name="language" class="wn-input">
                                    <option value="english">English</option>
                                    <option value="french">French</option>
                                    <option value="arabic">Arabic</option>
                                    <option value="spanish">Spanish</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="wn-form-group">
                            <label class="wn-form-label">Description <span class="wn-required">*</span></label>
                            <textarea name="description" class="wn-input wn-textarea" rows="4"
                                      placeholder="Write a compelling description..." required>{{ old('description') }}</textarea>
                        </div>

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">Director</label>
                                <input type="text" name="director" class="wn-input"
                                       placeholder="Director name"
                                       value="{{ old('director') }}">
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Age Rating</label>
                                <select name="age_rating" class="wn-input">
                                    <option value="G">G — All Ages</option>
                                    <option value="PG">PG — Parental Guidance</option>
                                    <option value="PG-13" selected>PG-13</option>
                                    <option value="R">R — Restricted</option>
                                    <option value="NC-17">NC-17</option>
                                </select>
                            </div>
                        </div>

                        <div class="wn-form-group">
                            <label class="wn-form-label">Cast</label>
                            <input type="text" name="cast" class="wn-input"
                                   placeholder="Actor 1, Actor 2, Actor 3..."
                                   value="{{ old('cast') }}">
                            <span class="wn-field-hint">Separate names with commas</span>
                        </div>
                    </div>

                    {{-- Series fields (shown only for series) --}}
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
                        <div class="wn-form-group">
                            <label class="wn-form-label">Network / Platform</label>
                            <input type="text" name="network" class="wn-input" placeholder="Netflix, HBO, AMC...">
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
                                   placeholder="https://... (MP4 or streaming URL)"
                                   value="{{ old('video_url') }}">
                            <span class="wn-field-hint">Direct MP4 URL or HLS stream URL</span>
                        </div>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Trailer URL (YouTube Embed)</label>
                            <input type="url" name="trailer_url" class="wn-input"
                                   placeholder="https://www.youtube.com/embed/..."
                                   value="{{ old('trailer_url') }}">
                        </div>
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
                            <select name="status" class="wn-input">
                                <option value="draft">📝 Draft</option>
                                <option value="published">✅ Published</option>
                            </select>
                        </div>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Access Level</label>
                            <select name="access" class="wn-input">
                                <option value="free">🆓 Free</option>
                                <option value="premium">👑 Premium Only</option>
                            </select>
                        </div>
                        <div class="wn-form-group">
                            <label class="wn-form-label">Featured</label>
                            <div class="wn-toggle-row">
                                <span class="wn-toggle-text">Show on homepage</span>
                                <label class="wn-switch">
                                    <input type="checkbox" name="featured" value="1">
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

                        {{-- Submit buttons --}}
                        <div class="wn-form-submit-btns">
                            <button type="submit" class="wn-save-btn w-100" style="justify-content:center;">
                                <span class="wn-btn-bg"></span>
                                <span class="wn-btn-content">
                                    <i class="bi bi-plus-circle-fill"></i>
                                    <span>Create Video</span>
                                </span>
                            </button>
                            <a href="{{ url('/admin/videos') }}" class="wn-reset-btn w-100" style="justify-content:center;text-decoration:none;">
                                <i class="bi bi-x-circle"></i>
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>

                    {{-- Poster upload --}}
                    <div class="wn-form-card">
                        <h3 class="wn-form-card-title">
                            <i class="bi bi-image-fill"></i> Poster Image
                        </h3>
                        <div class="wn-upload-zone" id="posterZone" onclick="document.getElementById('posterInput').click()">
                            <div class="wn-upload-preview" id="posterPreview" style="display:none;">
                                <img id="posterImg" src="" alt="Poster preview">
                                <button type="button" class="wn-upload-remove" onclick="removePoster(event)">✕</button>
                            </div>
                            <div class="wn-upload-placeholder" id="posterPlaceholder">
                                <i class="bi bi-cloud-upload"></i>
                                <p>Click to upload poster</p>
                                <span>JPG, PNG — Max 2MB</span>
                            </div>
                            <input type="file" id="posterInput" name="poster" accept="image/*"
                                   style="display:none;" onchange="previewPoster(this)">
                        </div>
                        <div class="wn-form-group" style="margin-top:12px;">
                            <label class="wn-form-label">Or paste image URL</label>
                            <input type="url" name="poster_url" class="wn-input"
                                   placeholder="https://..." value="{{ old('poster_url') }}">
                        </div>
                    </div>

                    {{-- Backdrop upload --}}
                    <div class="wn-form-card">
                        <h3 class="wn-form-card-title">
                            <i class="bi bi-panorama"></i> Backdrop Image
                        </h3>
                        <div class="wn-upload-zone wn-backdrop-zone" id="backdropZone" onclick="document.getElementById('backdropInput').click()">
                            <div class="wn-upload-preview" id="backdropPreview" style="display:none;">
                                <img id="backdropImg" src="" alt="Backdrop preview">
                                <button type="button" class="wn-upload-remove" onclick="removeBackdrop(event)">✕</button>
                            </div>
                            <div class="wn-upload-placeholder" id="backdropPlaceholder">
                                <i class="bi bi-cloud-upload"></i>
                                <p>Click to upload backdrop</p>
                                <span>JPG, PNG — 1920×1080 recommended</span>
                            </div>
                            <input type="file" id="backdropInput" name="backdrop" accept="image/*"
                                   style="display:none;" onchange="previewBackdrop(this)">
                        </div>
                    </div>

                </div>{{-- /sidebar --}}
            </div>{{-- /form layout --}}
        </form>
    </div>{{-- /container --}}
</div>{{-- /page --}}


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
.wn-av-back-btn { display:inline-flex; align-items:center; gap:8px; background:var(--wn-card); border:1px solid var(--wn-border); color:var(--wn-text); padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.88rem; transition:all 0.2s; }
.wn-av-back-btn:hover { border-color:var(--wn-red); color:var(--wn-white); }
.wn-av-container { padding-top:32px; }

/* Form layout */
.wn-form-layout { display:grid; grid-template-columns:1fr 320px; gap:24px; align-items:start; }
.wn-form-card { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:14px; padding:24px; margin-bottom:20px; animation:wn-fadein 0.4s ease both; }
.wn-form-card-title { font-size:0.95rem; font-weight:700; color:var(--wn-white); margin:0 0 20px; display:flex; align-items:center; gap:8px; }
.wn-form-card-title i { color:var(--wn-red); }
.wn-form-group { display:flex; flex-direction:column; gap:6px; margin-bottom:16px; }
.wn-form-group:last-child { margin-bottom:0; }
.wn-form-label { font-size:0.78rem; font-weight:600; color:var(--wn-muted); text-transform:uppercase; letter-spacing:0.06em; }
.wn-required { color:var(--wn-red); }
.wn-form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
.wn-textarea { resize:vertical; min-height:100px; }
.wn-field-hint { font-size:0.72rem; color:var(--wn-muted); }
.wn-field-error { font-size:0.75rem; color:var(--wn-red); }

/* Toggle switch */
.wn-toggle-row { display:flex; align-items:center; justify-content:space-between; }
.wn-toggle-text { font-size:0.85rem; color:var(--wn-text); }
.wn-switch { position:relative; width:40px; height:22px; flex-shrink:0; }
.wn-switch input { opacity:0; width:0; height:0; }
.wn-switch-slider { position:absolute; inset:0; background:var(--wn-border); border-radius:11px; cursor:pointer; transition:background 0.3s; }
.wn-switch-slider::before { content:''; position:absolute; width:16px; height:16px; left:3px; top:3px; background:white; border-radius:50%; transition:transform 0.3s; }
.wn-switch input:checked + .wn-switch-slider { background:var(--wn-red); }
.wn-switch input:checked + .wn-switch-slider::before { transform:translateX(18px); }

/* Submit buttons */
.wn-form-submit-btns { display:flex; flex-direction:column; gap:10px; margin-top:20px; }
.wn-save-btn { position:relative; overflow:hidden; border:none; border-radius:10px; padding:13px 24px; font-size:0.92rem; font-weight:700; cursor:pointer; background:linear-gradient(135deg,#e50914,#ff4d57); color:white; transition:transform 0.2s,box-shadow 0.2s; box-shadow:0 4px 20px rgba(229,9,20,0.4); display:flex; align-items:center; gap:8px; }
.wn-save-btn:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(229,9,20,0.55); }
.wn-btn-bg { position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,0.15),transparent); pointer-events:none; }
.wn-btn-content { position:relative; display:flex; align-items:center; gap:8px; }
.wn-reset-btn { display:inline-flex; align-items:center; gap:8px; padding:13px 24px; border-radius:10px; border:1.5px solid var(--wn-border); background:transparent; color:var(--wn-muted); font-size:0.88rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
.wn-reset-btn:hover { border-color:var(--wn-text); color:var(--wn-white); }

/* Upload zone */
.wn-upload-zone { border:2px dashed var(--wn-border); border-radius:10px; cursor:pointer; transition:border-color 0.2s,background 0.2s; overflow:hidden; min-height:140px; display:flex; align-items:center; justify-content:center; position:relative; }
.wn-upload-zone:hover { border-color:var(--wn-red); background:rgba(229,9,20,0.04); }
.wn-backdrop-zone { min-height:80px; }
.wn-upload-placeholder { text-align:center; padding:20px; }
.wn-upload-placeholder i { font-size:2rem; color:var(--wn-muted); display:block; margin-bottom:8px; }
.wn-upload-placeholder p { color:var(--wn-text); font-size:0.85rem; margin:0 0 4px; font-weight:600; }
.wn-upload-placeholder span { color:var(--wn-muted); font-size:0.75rem; }
.wn-upload-preview { width:100%; position:relative; }
.wn-upload-preview img { width:100%; display:block; max-height:200px; object-fit:cover; }
.wn-upload-remove { position:absolute; top:8px; right:8px; background:rgba(0,0,0,0.7); border:none; color:white; border-radius:50%; width:26px; height:26px; cursor:pointer; font-size:0.75rem; display:flex; align-items:center; justify-content:center; }

/* Sidebar sticky */
.wn-form-sidebar { position:sticky; top:80px; }

@keyframes wn-fadein { from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)} }
@media(max-width:992px) { .wn-form-layout{grid-template-columns:1fr} .wn-form-sidebar{position:static} }
@media(max-width:576px) { .wn-form-row-2{grid-template-columns:1fr} }
</style>
@endpush

@push('scripts')
<script>
/* ── Toggle series fields ── */
function toggleSeriesFields() {
    const type = document.getElementById('typeSelect').value;
    document.getElementById('seriesFields').style.display = type === 'series' ? 'block' : 'none';
}

/* ── Poster preview ── */
function previewPoster(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('posterImg').src = e.target.result;
            document.getElementById('posterPreview').style.display = 'block';
            document.getElementById('posterPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function removePoster(e) {
    e.stopPropagation();
    document.getElementById('posterImg').src = '';
    document.getElementById('posterPreview').style.display = 'none';
    document.getElementById('posterPlaceholder').style.display = 'block';
    document.getElementById('posterInput').value = '';
}

/* ── Backdrop preview ── */
function previewBackdrop(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('backdropImg').src = e.target.result;
            document.getElementById('backdropPreview').style.display = 'block';
            document.getElementById('backdropPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function removeBackdrop(e) {
    e.stopPropagation();
    document.getElementById('backdropImg').src = '';
    document.getElementById('backdropPreview').style.display = 'none';
    document.getElementById('backdropPlaceholder').style.display = 'block';
    document.getElementById('backdropInput').value = '';
}
</script>
@endpush

@endsection