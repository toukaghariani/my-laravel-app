@extends('layouts.app')

@section('title', 'My Profile — WolfNet')

@section('content')

{{-- ============================================================
     USER PROFILE PAGE — WolfNet
     Backend TODO:
       - Route: GET /profile → ProfileController@show
       - Pass $user object with: name, email, avatar, created_at,
         subscription (free/premium), favorites_count,
         watch_history_count, watchlist_count
     ============================================================ --}}

<div class="wn-profile-page">

    {{-- ── PROFILE HERO ── --}}
    <div class="wn-profile-hero">
        <div class="wn-profile-hero-bg"></div>
        <div class="container wn-profile-hero-inner">

            {{-- Avatar --}}
            <div class="wn-avatar-wrap">
                {{-- TODO: <img src="{{ $user->avatar ?? asset('images/default-avatar.png') }}" alt="Avatar"> --}}
                <div class="wn-avatar-placeholder" id="avatarPlaceholder">
                    <span id="avatarInitial">U</span>
                </div>
                <button class="wn-avatar-edit-btn" onclick="document.getElementById('avatarInput').click()" title="Change avatar">
                    <i class="bi bi-camera-fill"></i>
                </button>
                <input type="file" id="avatarInput" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
            </div>

            {{-- Name + badge --}}
            <div class="wn-profile-identity">
                <h1 class="wn-profile-name" id="profileName">John Doe</h1>
                <p class="wn-profile-email" id="profileEmail">john@example.com</p>
                <div class="wn-profile-badges">
                    <span class="wn-sub-badge wn-sub-free" id="subBadge">
                        <i class="bi bi-person-fill"></i> Free Plan
                    </span>
                    <span class="wn-member-since">
                        <i class="bi bi-calendar3"></i> Member since Jan 2025
                    </span>
                </div>
            </div>

            {{-- Upgrade button --}}
            <a href="{{ url('/premium') }}" class="wn-upgrade-btn">
                ♛ Upgrade to Premium
            </a>

        </div>
    </div>

    {{-- ── STATS ROW ── --}}
    <div class="container">
        <div class="wn-stats-row">
            <div class="wn-stat-card">
                <span class="wn-stat-number">12</span>
                <span class="wn-stat-label">Favorites</span>
            </div>
            <div class="wn-stat-card">
                <span class="wn-stat-number">8</span>
                <span class="wn-stat-label">Watchlist</span>
            </div>
            <div class="wn-stat-card">
                <span class="wn-stat-number">34</span>
                <span class="wn-stat-label">Watched</span>
            </div>
        </div>
    </div>

    {{-- ── MAIN CONTENT ── --}}
    <div class="container wn-profile-content">
        <div class="wn-profile-grid">

            {{-- ══ LEFT: EDIT PROFILE FORM ══ --}}
            <div class="wn-profile-main">
                <div class="wn-profile-card">
                    <h2 class="wn-card-section-title">
                        <i class="bi bi-person-gear"></i> Edit Profile
                    </h2>

                    @if(session('success'))
                        <div class="wn-alert-success wn-alert-dismissible mb-4">
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()" class="wn-alert-close">✕</button>
                        </div>
                    @endif

                    <form id="profileForm" class="wn-profile-form">
                        @csrf

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">Full Name</label>
                                <input type="text" name="name" class="wn-input" value="John Doe" required>
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Email Address</label>
                                <input type="email" name="email" class="wn-input" value="john@example.com" required>
                            </div>
                        </div>

                        <div class="wn-form-group">
                            <label class="wn-form-label">Bio</label>
                            <textarea name="bio" class="wn-input wn-textarea" rows="3"
                                      placeholder="Tell us something about yourself..."></textarea>
                        </div>

                        <div class="wn-form-divider"><span>Change Password</span></div>

                        <div class="wn-form-row-2">
                            <div class="wn-form-group">
                                <label class="wn-form-label">New Password</label>
                                <input type="password" name="password" class="wn-input"
                                       placeholder="Leave blank to keep current">
                            </div>
                            <div class="wn-form-group">
                                <label class="wn-form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="wn-input"
                                       placeholder="Repeat new password">
                            </div>
                        </div>
<div class="wn-form-actions">
    <button type="submit" id="saveBtn" class="wn-save-btn">
        <span class="wn-btn-bg"></span>
        <span class="wn-btn-content">
            <i class="bi bi-check-circle-fill"></i>
            <span id="saveBtnText">Save Changes</span>
        </span>
    </button>
    <button type="reset" class="wn-reset-btn">
        <i class="bi bi-arrow-counterclockwise"></i>
        <span>Reset</span>
    </button>
</div>
                    </form>
                </div>

                {{-- Danger Zone --}}
                <div class="wn-profile-card wn-danger-card">
                    <h2 class="wn-card-section-title wn-danger-title">
                        <i class="bi bi-exclamation-triangle-fill"></i> Danger Zone
                    </h2>
                    <p class="wn-danger-text">Deleting your account is permanent and cannot be undone.</p>
                    <button class="wn-danger-btn" onclick="confirmDelete()">
                        <i class="bi bi-trash3-fill me-1"></i> Delete My Account
                    </button>
                </div>
            </div>

            {{-- ══ RIGHT: SIDEBAR ══ --}}
            <div class="wn-profile-sidebar">

                {{-- Subscription --}}
                <div class="wn-profile-card wn-sub-card">
                    <h3 class="wn-card-section-title">
                        <i class="bi bi-shield-fill-check"></i> Subscription
                    </h3>
                    <div class="wn-sub-info">
                        <div class="wn-sub-plan-display">
                            <span class="wn-sub-plan-name">Free Plan</span>
                            <span class="wn-sub-plan-price">0 TND / month</span>
                        </div>
                        <p class="wn-sub-desc">Upgrade to unlock HD streaming, exclusive content and more.</p>
                        <a href="{{ url('/premium') }}" class="wn-plan-btn wn-plan-btn-primary" style="font-size:0.85rem;padding:10px;">
                            ♛ Upgrade Now
                        </a>
                    </div>
                </div>

                {{-- Quick links --}}
                <div class="wn-profile-card">
                    <h3 class="wn-card-section-title">
                        <i class="bi bi-collection-play"></i> My Content
                    </h3>
                    <div class="wn-quick-links">
                        <a href="{{ url('/favorites') }}" class="wn-quick-link">
                            <i class="bi bi-heart-fill"></i>
                            <span>My Favorites</span>
                            <span class="wn-quick-count">12</span>
                            <i class="bi bi-chevron-right wn-quick-arrow"></i>
                        </a>
                        <a href="{{ url('/watchlist') }}" class="wn-quick-link">
                            <i class="bi bi-bookmark-fill"></i>
                            <span>My Watchlist</span>
                            <span class="wn-quick-count">8</span>
                            <i class="bi bi-chevron-right wn-quick-arrow"></i>
                        </a>
                        <a href="{{ url('/history') }}" class="wn-quick-link">
                            <i class="bi bi-clock-history"></i>
                            <span>Watch History</span>
                            <span class="wn-quick-count">34</span>
                            <i class="bi bi-chevron-right wn-quick-arrow"></i>
                        </a>
                    </div>
                </div>

                {{-- Logout --}}
               <form action="{{ url('/logout') }}" method="POST">
    @csrf
    <button type="submit" class="wn-signout-btn">
        <i class="bi bi-box-arrow-right"></i>
        <span>Sign Out</span>
    </button>
</form>

            </div>
        </div>
    </div>

    {{-- DELETE CONFIRM MODAL --}}
    <div class="wn-modal-backdrop" id="deleteModal" style="display:none;" onclick="closeDeleteModal(event)">
        <div class="wn-modal-box" style="max-width:420px; text-align:center;">
            <div style="font-size:2.5rem; margin-bottom:16px;">⚠️</div>
            <h3 class="wn-modal-title">Delete Account?</h3>
            <p style="color:#b0b0b0; font-size:0.9rem; margin: 12px 0 28px;">
                This will permanently delete your account, favorites, and all data. This cannot be undone.
            </p>
            <div style="display:flex; gap:12px; justify-content:center;">
                <button onclick="hideDeleteModal()" class="wn-plan-btn wn-plan-btn-outline" style="max-width:140px;">Cancel</button>
                <button class="wn-plan-btn wn-plan-btn-primary" style="max-width:180px; background:#dc2626; border-color:#dc2626;">Yes, Delete</button>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* ── Sign Out Button ── */
.wn-signout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 13px;
    border-radius: 10px;
    border: 1.5px solid #3a1010;
    background: transparent;
    color: #ff6b6b;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    letter-spacing: 0.02em;
}
.wn-signout-btn:hover {
    background: rgba(220,38,38,0.12);
    border-color: #dc2626;
    color: #ff4444;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220,38,38,0.2);
}
.wn-signout-btn:active { transform: translateY(0); }
.wn-signout-btn i {
    font-size: 1.05rem;
    transition: transform 0.3s ease;
}
.wn-signout-btn:hover i {
    transform: translateX(4px);
}
    /* ── Save Button ── */
.wn-save-btn {
    position: relative;
    overflow: hidden;
    border: none;
    border-radius: 10px;
    padding: 13px 32px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    background: linear-gradient(135deg, #e50914, #ff4d57);
    color: white;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 4px 20px rgba(229,9,20,0.4);
}
.wn-save-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(229,9,20,0.55);
}
.wn-save-btn:active { transform: translateY(0); }
.wn-btn-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
    pointer-events: none;
}
.wn-btn-content {
    position: relative;
    display: flex;
    align-items: center;
    gap: 8px;
}
.wn-save-btn i { font-size: 1rem; }

/* ── Reset Button ── */
.wn-reset-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 24px;
    border-radius: 10px;
    border: 1.5px solid var(--wn-border);
    background: transparent;
    color: var(--wn-muted);
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.wn-reset-btn:hover {
    border-color: var(--wn-text);
    color: var(--wn-white);
    background: rgba(255,255,255,0.05);
    transform: translateY(-2px);
}
.wn-reset-btn i {
    transition: transform 0.4s ease;
}
.wn-reset-btn:hover i {
    transform: rotate(-180deg);
}
.wn-profile-page { min-height:100vh; background:var(--wn-dark); padding-bottom:80px; }
.wn-profile-hero { position:relative; padding:100px 0 0; overflow:hidden; }
.wn-profile-hero-bg { position:absolute; inset:0; background:radial-gradient(ellipse at 50% 0%, rgba(229,9,20,0.12) 0%, transparent 65%), linear-gradient(180deg, #0a0a0a 0%, var(--wn-dark) 100%); }
.wn-profile-hero-inner { position:relative; display:flex; align-items:center; gap:32px; padding-bottom:40px; flex-wrap:wrap; }
.wn-avatar-wrap { position:relative; flex-shrink:0; }
.wn-avatar-placeholder { width:96px; height:96px; border-radius:50%; background:linear-gradient(135deg, var(--wn-red), #8b0000); display:flex; align-items:center; justify-content:center; font-size:2.2rem; font-weight:800; color:white; border:3px solid var(--wn-border); overflow:hidden; }
.wn-avatar-edit-btn { position:absolute; bottom:0; right:0; background:var(--wn-red); border:2px solid var(--wn-dark); color:white; border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:0.7rem; transition:background 0.2s; }
.wn-avatar-edit-btn:hover { background:var(--wn-red-dark); }
.wn-profile-identity { flex:1; min-width:200px; }
.wn-profile-name { font-size:clamp(1.5rem, 3vw, 2.2rem); font-weight:800; color:var(--wn-white); margin:0 0 4px; letter-spacing:-0.02em; }
.wn-profile-email { color:var(--wn-muted); font-size:0.9rem; margin:0 0 12px; }
.wn-profile-badges { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.wn-sub-badge { font-size:0.75rem; font-weight:700; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; }
.wn-sub-free { background:rgba(255,255,255,0.08); color:var(--wn-muted); border:1px solid var(--wn-border); }
.wn-sub-premium { background:rgba(245,197,24,0.15); color:#f5c518; border:1px solid rgba(245,197,24,0.3); }
.wn-member-since { color:var(--wn-muted); font-size:0.78rem; display:flex; align-items:center; gap:5px; }
.wn-upgrade-btn { background:linear-gradient(135deg, #f5c518, #e6a800); color:#000; font-weight:800; font-size:0.85rem; padding:10px 22px; border-radius:8px; text-decoration:none; white-space:nowrap; transition:opacity 0.2s, transform 0.15s; align-self:center; }
.wn-upgrade-btn:hover { opacity:0.9; transform:translateY(-2px); color:#000; }
.wn-stats-row { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin:0 0 40px; border-top:1px solid var(--wn-border); padding-top:28px; }
.wn-stat-card { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:12px; padding:20px; text-align:center; transition:border-color 0.2s, transform 0.2s; }
.wn-stat-card:hover { border-color:var(--wn-red); transform:translateY(-3px); }
.wn-stat-number { display:block; font-size:2rem; font-weight:800; color:var(--wn-white); line-height:1; margin-bottom:6px; }
.wn-stat-label { font-size:0.8rem; color:var(--wn-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.06em; }
.wn-profile-grid { display:grid; grid-template-columns:1fr 320px; gap:24px; align-items:start; }
.wn-profile-card { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:14px; padding:28px; margin-bottom:20px; animation:wn-fadein 0.4s ease both; }
.wn-card-section-title { font-size:1rem; font-weight:700; color:var(--wn-white); margin:0 0 22px; display:flex; align-items:center; gap:8px; }
.wn-card-section-title i { color:var(--wn-red); }
.wn-profile-form { display:flex; flex-direction:column; gap:18px; }
.wn-form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.wn-form-group { display:flex; flex-direction:column; gap:6px; }
.wn-form-label { font-size:0.78rem; font-weight:600; color:var(--wn-muted); text-transform:uppercase; letter-spacing:0.06em; }
.wn-textarea { resize:vertical; min-height:90px; }
.wn-form-divider { display:flex; align-items:center; gap:12px; color:var(--wn-muted); font-size:0.8rem; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; }
.wn-form-divider::before, .wn-form-divider::after { content:''; flex:1; height:1px; background:var(--wn-border); }
.wn-form-actions { display:flex; gap:12px; }
.wn-alert-dismissible { display:flex; align-items:center; justify-content:space-between; border-radius:8px; padding:12px 16px; font-size:0.88rem; }
.wn-alert-close { background:none; border:none; color:inherit; opacity:0.7; cursor:pointer; }
.wn-danger-card { border-color:rgba(220,38,38,0.3); background:rgba(220,38,38,0.04); }
.wn-danger-title { color:#ff6b6b !important; }
.wn-danger-title i { color:#ff6b6b !important; }
.wn-danger-text { color:#b0b0b0; font-size:0.88rem; margin-bottom:16px; }
.wn-danger-btn { background:transparent; border:1px solid rgba(220,38,38,0.4); color:#ff6b6b; padding:9px 20px; border-radius:8px; font-size:0.88rem; font-weight:600; cursor:pointer; transition:background 0.2s; }
.wn-danger-btn:hover { background:rgba(220,38,38,0.1); }
.wn-profile-sidebar { position:sticky; top:90px; }
.wn-sub-info { display:flex; flex-direction:column; gap:12px; }
.wn-sub-plan-display { display:flex; justify-content:space-between; align-items:center; }
.wn-sub-plan-name { font-weight:700; color:var(--wn-white); }
.wn-sub-plan-price { font-size:0.82rem; color:var(--wn-muted); }
.wn-sub-desc { color:#b0b0b0; font-size:0.85rem; margin:0; }
.wn-quick-links { display:flex; flex-direction:column; gap:4px; }
.wn-quick-link { display:flex; align-items:center; gap:12px; padding:11px 12px; border-radius:8px; text-decoration:none; color:var(--wn-text); font-size:0.88rem; transition:background 0.2s; }
.wn-quick-link:hover { background:rgba(229,9,20,0.08); color:var(--wn-white); }
.wn-quick-link i:first-child { color:var(--wn-red); width:16px; }
.wn-quick-link span:first-of-type { flex:1; }
.wn-quick-count { background:var(--wn-border); color:var(--wn-muted); font-size:0.72rem; font-weight:700; padding:2px 8px; border-radius:10px; }
.wn-quick-arrow { color:var(--wn-border); font-size:0.75rem; }
.wn-modal-backdrop { position:fixed; inset:0; background:rgba(0,0,0,0.85); z-index:1050; display:flex; align-items:center; justify-content:center; padding:20px; animation:wn-fadein 0.2s ease; }
.wn-modal-box { background:var(--wn-card); border:1px solid var(--wn-border); border-radius:16px; padding:40px 36px; width:100%; position:relative; animation:wn-slideup 0.3s ease; }
.wn-modal-title { font-size:1.3rem; font-weight:700; color:var(--wn-white); margin:0; }
@keyframes wn-fadein { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
@keyframes wn-slideup { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
@media (max-width:992px) { .wn-profile-grid { grid-template-columns:1fr; } .wn-profile-sidebar { position:static; } }
@media (max-width:576px) { .wn-profile-hero-inner { flex-direction:column; align-items:center; text-align:center; } .wn-profile-badges { justify-content:center; } .wn-form-row-2 { grid-template-columns:1fr; } .wn-upgrade-btn { width:100%; text-align:center; } }
</style>
@endpush

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPlaceholder').innerHTML =
                '<img src="' + e.target.result + '" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">';
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
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault(); // TODO: remove when backend is ready
    const btn = this.querySelector('[type="submit"]');
    btn.innerHTML = '⏳ Saving...';
    btn.disabled = true;
    setTimeout(function() {
        btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Save Changes';
        btn.disabled = false;
        const alert = document.createElement('div');
        alert.className = 'wn-alert-success';
        alert.style.cssText = 'position:fixed;top:80px;left:50%;transform:translateX(-50%);z-index:9999;min-width:320px;display:flex;align-items:center;gap:10px;padding:14px 20px;border-radius:8px;';
        alert.innerHTML = '<i class="bi bi-check-circle-fill"></i> Profile updated successfully! <button onclick="this.parentElement.remove()" style="background:none;border:none;color:inherit;margin-left:auto;cursor:pointer;">✕</button>';
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 4000);
    }, 1200);
});
</script>
@endpush

@endsection