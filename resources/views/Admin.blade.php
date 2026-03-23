@extends('layouts.app')

@section('title', 'Admin Dashboard — WolfNet')

@section('content')

{{-- ============================================================
     ADMIN DASHBOARD — WolfNet
     Backend TODO:
       - Route: GET /admin → AdminController@index
       - Middleware: admin only (role check)
       - Pass: $stats, $recentUsers, $recentMovies, $recentPayments
     ============================================================ --}}

<div class="wn-admin-page">

    {{-- ── SIDEBAR ── --}}
    <aside class="wn-admin-sidebar" id="adminSidebar">
        <div class="wn-admin-logo">
            <span class="wn-logo">WOLF<span>NET</span></span>
            <span class="wn-admin-tag">ADMIN</span>
        </div>

        <nav class="wn-admin-nav">
            <a href="#overview" class="wn-admin-nav-link active" onclick="showSection('overview', this)">
                <i class="bi bi-grid-1x2-fill"></i> <span>Overview</span>
            </a>
            <a href="#users" class="wn-admin-nav-link" onclick="showSection('users', this)">
                <i class="bi bi-people-fill"></i> <span>Users</span>
                <span class="wn-nav-badge">24</span>
            </a>
            <a href="#movies" class="wn-admin-nav-link" onclick="showSection('movies', this)">
                <i class="bi bi-film"></i> <span>Movies</span>
            </a>
            <a href="#payments" class="wn-admin-nav-link" onclick="showSection('payments', this)">
                <i class="bi bi-credit-card-fill"></i> <span>Payments</span>
                <span class="wn-nav-badge wn-badge-green">5</span>
            </a>
            <a href="#analytics" class="wn-admin-nav-link" onclick="showSection('analytics', this)">
                <i class="bi bi-bar-chart-fill"></i> <span>Analytics</span>
            </a>

            <div class="wn-admin-nav-divider"></div>

            <a href="{{ url('/') }}" class="wn-admin-nav-link">
                <i class="bi bi-house-fill"></i> <span>Back to Site</span>
            </a>
            <a href="{{ url('/logout') }}" class="wn-admin-nav-link wn-nav-logout"
               onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
            </a>
            <form id="logoutForm" action="{{ url('/logout') }}" method="POST" style="display:none;">@csrf</form>
        </nav>
    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <div class="wn-admin-main">

        {{-- ── TOP BAR ── --}}
        <div class="wn-admin-topbar">
            <div class="wn-admin-topbar-left">
                <button class="wn-sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h2 class="wn-admin-page-title" id="adminPageTitle">Overview</h2>
            </div>
            <div class="wn-admin-topbar-right">
                <div class="wn-admin-search">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="wn-admin-avatar">A</div>
            </div>
        </div>

        {{-- ════════════════════════════════════
             SECTION: OVERVIEW
        ════════════════════════════════════ --}}
        <div class="wn-admin-section active" id="section-overview">

            {{-- Stats cards --}}
            <div class="wn-stats-grid">
                <div class="wn-stat-box wn-stat-red">
                    <div class="wn-stat-box-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="wn-stat-box-info">
                        <span class="wn-stat-box-num" data-target="1284">0</span>
                        <span class="wn-stat-box-label">Total Users</span>
                    </div>
                    <div class="wn-stat-box-trend wn-trend-up">↑ 12% this month</div>
                </div>
                <div class="wn-stat-box wn-stat-blue">
                    <div class="wn-stat-box-icon"><i class="bi bi-film"></i></div>
                    <div class="wn-stat-box-info">
                        <span class="wn-stat-box-num" data-target="347">0</span>
                        <span class="wn-stat-box-label">Total Movies</span>
                    </div>
                    <div class="wn-stat-box-trend wn-trend-up">↑ 8 added this week</div>
                </div>
                <div class="wn-stat-box wn-stat-green">
                    <div class="wn-stat-box-icon"><i class="bi bi-currency-dollar"></i></div>
                    <div class="wn-stat-box-info">
                        <span class="wn-stat-box-num" data-target="4820" data-suffix=" TND">0</span>
                        <span class="wn-stat-box-label">Monthly Revenue</span>
                    </div>
                    <div class="wn-stat-box-trend wn-trend-up">↑ 23% vs last month</div>
                </div>
                <div class="wn-stat-box wn-stat-yellow">
                    <div class="wn-stat-box-icon"><i class="bi bi-shield-fill-check"></i></div>
                    <div class="wn-stat-box-info">
                        <span class="wn-stat-box-num" data-target="321">0</span>
                        <span class="wn-stat-box-label">Premium Users</span>
                    </div>
                    <div class="wn-stat-box-trend wn-trend-up">↑ 5 new today</div>
                </div>
            </div>

            {{-- Charts row --}}
            <div class="wn-charts-row">

                {{-- Revenue chart --}}
                <div class="wn-admin-card wn-chart-card">
                    <div class="wn-admin-card-header">
                        <h3>Revenue Overview</h3>
                        <div class="wn-chart-tabs">
                            <button class="wn-chart-tab active">7D</button>
                            <button class="wn-chart-tab">30D</button>
                            <button class="wn-chart-tab">90D</button>
                        </div>
                    </div>
                    <div class="wn-bar-chart" id="revenueChart">
                        {{-- Bars generated by JS --}}
                    </div>
                    <div class="wn-chart-labels" id="chartLabels"></div>
                </div>

                {{-- User distribution --}}
                <div class="wn-admin-card wn-donut-card">
                    <div class="wn-admin-card-header">
                        <h3>User Plans</h3>
                    </div>
                    <div class="wn-donut-wrap">
                        <svg viewBox="0 0 120 120" class="wn-donut-svg">
                            <circle cx="60" cy="60" r="45" fill="none" stroke="var(--wn-border)" stroke-width="18"/>
                            <circle cx="60" cy="60" r="45" fill="none" stroke="var(--wn-red)" stroke-width="18"
                                    stroke-dasharray="127 155" stroke-dashoffset="0" transform="rotate(-90 60 60)"
                                    class="wn-donut-seg"/>
                            <circle cx="60" cy="60" r="45" fill="none" stroke="#3b82f6" stroke-width="18"
                                    stroke-dasharray="155 127" stroke-dashoffset="-127" transform="rotate(-90 60 60)"
                                    class="wn-donut-seg"/>
                        </svg>
                        <div class="wn-donut-center">
                            <span class="wn-donut-total">1,284</span>
                            <span class="wn-donut-label">users</span>
                        </div>
                    </div>
                    <div class="wn-donut-legend">
                        <div class="wn-legend-item">
                            <span class="wn-legend-dot" style="background:var(--wn-red)"></span>
                            <span>Premium</span>
                            <strong>321 (25%)</strong>
                        </div>
                        <div class="wn-legend-item">
                            <span class="wn-legend-dot" style="background:#3b82f6"></span>
                            <span>Free</span>
                            <strong>963 (75%)</strong>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Recent activity --}}
            <div class="wn-admin-card">
                <div class="wn-admin-card-header">
                    <h3>Recent Users</h3>
                    <button class="wn-view-all-btn" onclick="showSection('users', document.querySelector('[onclick*=users]'))">View All</button>
                </div>
                <div class="wn-admin-table-wrap">
                    <table class="wn-admin-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Plan</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><div class="wn-table-user"><div class="wn-table-avatar" style="background:#e50914">J</div>John Doe</div></td>
                                <td>john@example.com</td>
                                <td><span class="wn-plan-chip wn-chip-premium">Premium</span></td>
                                <td>Jan 2025</td>
                                <td><div class="wn-table-actions">
                                    <button class="wn-tbl-btn wn-tbl-edit" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="wn-tbl-btn wn-tbl-del" title="Delete"><i class="bi bi-trash3-fill"></i></button>
                                </div></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><div class="wn-table-user"><div class="wn-table-avatar" style="background:#3b82f6">S</div>Sara Ben Ali</div></td>
                                <td>sara@example.com</td>
                                <td><span class="wn-plan-chip wn-chip-free">Free</span></td>
                                <td>Feb 2025</td>
                                <td><div class="wn-table-actions">
                                    <button class="wn-tbl-btn wn-tbl-edit" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="wn-tbl-btn wn-tbl-del" title="Delete"><i class="bi bi-trash3-fill"></i></button>
                                </div></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><div class="wn-table-user"><div class="wn-table-avatar" style="background:#22c55e">M</div>Mohamed Trabelsi</div></td>
                                <td>med@example.com</td>
                                <td><span class="wn-plan-chip wn-chip-premium">Premium</span></td>
                                <td>Mar 2025</td>
                                <td><div class="wn-table-actions">
                                    <button class="wn-tbl-btn wn-tbl-edit" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="wn-tbl-btn wn-tbl-del" title="Delete"><i class="bi bi-trash3-fill"></i></button>
                                </div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- /overview --}}

        {{-- ════════════════════════════════════
             SECTION: USERS
        ════════════════════════════════════ --}}
        <div class="wn-admin-section" id="section-users">
            <div class="wn-admin-card">
                <div class="wn-admin-card-header">
                    <h3>All Users</h3>
                    <div class="wn-header-actions">
                        <input type="text" class="wn-admin-search-input" placeholder="Search users..." oninput="filterTable(this, 'usersTable')">
                        <select class="wn-fav-select" onchange="filterByPlan(this.value)">
                            <option value="all">All Plans</option>
                            <option value="premium">Premium</option>
                            <option value="free">Free</option>
                        </select>
                    </div>
                </div>
                <div class="wn-admin-table-wrap">
                    <table class="wn-admin-table" id="usersTable">
                        <thead>
                            <tr><th>#</th><th>Name</th><th>Email</th><th>Plan</th><th>Favorites</th><th>Joined</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                            @php $users = [
                                ['id'=>1,'name'=>'John Doe','email'=>'john@example.com','plan'=>'premium','favs'=>12,'joined'=>'Jan 2025','color'=>'#e50914'],
                                ['id'=>2,'name'=>'Sara Ben Ali','email'=>'sara@example.com','plan'=>'free','favs'=>4,'joined'=>'Feb 2025','color'=>'#3b82f6'],
                                ['id'=>3,'name'=>'Mohamed Trabelsi','email'=>'med@example.com','plan'=>'premium','favs'=>23,'joined'=>'Mar 2025','color'=>'#22c55e'],
                                ['id'=>4,'name'=>'Leila Mansouri','email'=>'leila@example.com','plan'=>'free','favs'=>7,'joined'=>'Mar 2025','color'=>'#f59e0b'],
                                ['id'=>5,'name'=>'Karim Bouaziz','email'=>'karim@example.com','plan'=>'premium','favs'=>31,'joined'=>'Mar 2025','color'=>'#8b5cf6'],
                            ]; @endphp
                            @foreach($users as $u)
                            <tr data-plan="{{ $u['plan'] }}">
                                <td>{{ $u['id'] }}</td>
                                <td><div class="wn-table-user"><div class="wn-table-avatar" style="background:{{ $u['color'] }}">{{ strtoupper(substr($u['name'],0,1)) }}</div>{{ $u['name'] }}</div></td>
                                <td>{{ $u['email'] }}</td>
                                <td><span class="wn-plan-chip wn-chip-{{ $u['plan'] }}">{{ ucfirst($u['plan']) }}</span></td>
                                <td>{{ $u['favs'] }}</td>
                                <td>{{ $u['joined'] }}</td>
                                <td><div class="wn-table-actions">
                                    <button class="wn-tbl-btn wn-tbl-edit" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="wn-tbl-btn wn-tbl-del" title="Delete" onclick="deleteRow(this)"><i class="bi bi-trash3-fill"></i></button>
                                </div></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════
             SECTION: MOVIES
        ════════════════════════════════════ --}}
        <div class="wn-admin-section" id="section-movies">
            <div class="wn-admin-card">
                <div class="wn-admin-card-header">
                    <h3>Movies & Series</h3>
                    <div class="wn-header-actions">
                        <input type="text" class="wn-admin-search-input" placeholder="Search titles..." oninput="filterTable(this, 'moviesTable')">
                        <button class="wn-add-btn" onclick="showAddMovieModal()">
                            <i class="bi bi-plus-lg"></i> Add Movie
                        </button>
                    </div>
                </div>
                <div class="wn-admin-table-wrap">
                    <table class="wn-admin-table" id="moviesTable">
                        <thead>
                            <tr><th>#</th><th>Title</th><th>Type</th><th>Year</th><th>Genre</th><th>Rating</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                            @php $movies = [
                                ['id'=>1,'title'=>'Inception','type'=>'movie','year'=>2010,'genre'=>'Sci-Fi','rating'=>8.8],
                                ['id'=>2,'title'=>'The Dark Knight','type'=>'movie','year'=>2008,'genre'=>'Action','rating'=>9.0],
                                ['id'=>3,'title'=>'Breaking Bad','type'=>'series','year'=>2008,'genre'=>'Crime','rating'=>9.5],
                                ['id'=>4,'title'=>'Interstellar','type'=>'movie','year'=>2014,'genre'=>'Drama','rating'=>8.6],
                                ['id'=>5,'title'=>'The Office','type'=>'series','year'=>2005,'genre'=>'Comedy','rating'=>8.9],
                            ]; @endphp
                            @foreach($movies as $m)
                            <tr>
                                <td>{{ $m['id'] }}</td>
                                <td><strong style="color:var(--wn-white)">{{ $m['title'] }}</strong></td>
                                <td><span class="wn-plan-chip {{ $m['type'] === 'movie' ? 'wn-chip-movie' : 'wn-chip-series' }}">
                                    {{ $m['type'] === 'movie' ? '🎬 Movie' : '📺 Series' }}
                                </span></td>
                                <td>{{ $m['year'] }}</td>
                                <td>{{ $m['genre'] }}</td>
                                <td><span style="color:#f5c518;font-weight:700">⭐ {{ $m['rating'] }}</span></td>
                                <td><div class="wn-table-actions">
                                    <button class="wn-tbl-btn wn-tbl-edit" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="wn-tbl-btn wn-tbl-del" title="Delete" onclick="deleteRow(this)"><i class="bi bi-trash3-fill"></i></button>
                                </div></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════
             SECTION: PAYMENTS
        ════════════════════════════════════ --}}
        <div class="wn-admin-section" id="section-payments">
            <div class="wn-admin-card">
                <div class="wn-admin-card-header">
                    <h3>Payment Transactions</h3>
                    <input type="text" class="wn-admin-search-input" placeholder="Search payments...">
                </div>
                <div class="wn-admin-table-wrap">
                    <table class="wn-admin-table">
                        <thead>
                            <tr><th>#</th><th>User</th><th>Plan</th><th>Amount</th><th>Date</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @php $payments = [
                                ['id'=>1,'user'=>'John Doe','plan'=>'Premium','amount'=>'15 TND','date'=>'Mar 23, 2026','status'=>'success'],
                                ['id'=>2,'user'=>'Karim Bouaziz','plan'=>'Ultimate','amount'=>'25 TND','date'=>'Mar 22, 2026','status'=>'success'],
                                ['id'=>3,'user'=>'Sara Ben Ali','plan'=>'Premium','amount'=>'15 TND','date'=>'Mar 21, 2026','status'=>'failed'],
                                ['id'=>4,'user'=>'Mohamed Trabelsi','plan'=>'Premium','amount'=>'15 TND','date'=>'Mar 20, 2026','status'=>'success'],
                                ['id'=>5,'user'=>'Leila Mansouri','plan'=>'Ultimate','amount'=>'25 TND','date'=>'Mar 19, 2026','status'=>'pending'],
                            ]; @endphp
                            @foreach($payments as $p)
                            <tr>
                                <td>{{ $p['id'] }}</td>
                                <td><strong style="color:var(--wn-white)">{{ $p['user'] }}</strong></td>
                                <td>{{ $p['plan'] }}</td>
                                <td><strong style="color:#22c55e">{{ $p['amount'] }}</strong></td>
                                <td>{{ $p['date'] }}</td>
                                <td>
                                    @if($p['status'] === 'success')
                                        <span class="wn-status-chip wn-status-success">✓ Success</span>
                                    @elseif($p['status'] === 'failed')
                                        <span class="wn-status-chip wn-status-failed">✕ Failed</span>
                                    @else
                                        <span class="wn-status-chip wn-status-pending">⏳ Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════
             SECTION: ANALYTICS
        ════════════════════════════════════ --}}
        <div class="wn-admin-section" id="section-analytics">
            <div class="wn-charts-row">
                <div class="wn-admin-card wn-chart-card">
                    <div class="wn-admin-card-header"><h3>New Signups (Last 7 Days)</h3></div>
                    <div class="wn-bar-chart" id="signupsChart"></div>
                    <div class="wn-chart-labels" id="signupsLabels"></div>
                </div>
                <div class="wn-admin-card">
                    <div class="wn-admin-card-header"><h3>Top Watched Movies</h3></div>
                    <div class="wn-top-list">
                        @php $topMovies = [
                            ['title'=>'The Dark Knight','views'=>1240,'pct'=>100],
                            ['title'=>'Inception','views'=>980,'pct'=>79],
                            ['title'=>'Breaking Bad','views'=>870,'pct'=>70],
                            ['title'=>'Interstellar','views'=>650,'pct'=>52],
                            ['title'=>'Pulp Fiction','views'=>430,'pct'=>35],
                        ]; @endphp
                        @foreach($topMovies as $i => $movie)
                        <div class="wn-top-item">
                            <span class="wn-top-rank">{{ $i + 1 }}</span>
                            <div class="wn-top-info">
                                <span class="wn-top-title">{{ $movie['title'] }}</span>
                                <div class="wn-hist-progress-bar" style="margin-top:6px;">
                                    <div class="wn-hist-progress-fill" style="width:{{ $movie['pct'] }}%"></div>
                                </div>
                            </div>
                            <span class="wn-top-views">{{ number_format($movie['views']) }} views</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /admin-main --}}
</div>{{-- /admin-page --}}

{{-- ADD MOVIE MODAL --}}
<div class="wn-modal-backdrop" id="addMovieModal" style="display:none;" onclick="closeAddMovieModal(event)">
    <div class="wn-modal-box" style="max-width:500px;">
        <button class="wn-modal-close-btn" onclick="hideAddMovieModal()">✕</button>
        <h3 class="wn-modal-title" style="margin-bottom:20px;">➕ Add New Movie</h3>
        <form class="wn-profile-form">
            @csrf
            <div class="wn-form-row-2">
                <div class="wn-form-group">
                    <label class="wn-form-label">Title</label>
                    <input type="text" class="wn-input" placeholder="Movie title" required>
                </div>
                <div class="wn-form-group">
                    <label class="wn-form-label">Type</label>
                    <select class="wn-input">
                        <option>Movie</option>
                        <option>Series</option>
                    </select>
                </div>
            </div>
            <div class="wn-form-row-2">
                <div class="wn-form-group">
                    <label class="wn-form-label">Year</label>
                    <input type="number" class="wn-input" placeholder="2024">
                </div>
                <div class="wn-form-group">
                    <label class="wn-form-label">Genre</label>
                    <input type="text" class="wn-input" placeholder="Action, Drama...">
                </div>
            </div>
            <div class="wn-form-group">
                <label class="wn-form-label">Description</label>
                <textarea class="wn-input" rows="3" placeholder="Movie description..."></textarea>
            </div>
            <div class="wn-form-group">
                <label class="wn-form-label">Poster URL</label>
                <input type="text" class="wn-input" placeholder="https://...">
            </div>
            <div class="wn-form-actions" style="margin-top:8px;">
                <button type="submit" class="wn-save-btn" style="flex:1;">
                    <span class="wn-btn-content"><i class="bi bi-plus-lg"></i> Add Movie</span>
                </button>
                <button type="button" class="wn-reset-btn" onclick="hideAddMovieModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>


@push('styles')
<style>
/* ── Reset main padding for admin ── */
.wn-main { padding-top: 0 !important; }

/* ── Page layout ── */
.wn-admin-page {
    display: flex;
    min-height: 100vh;
    background: #0d0d0d;
    padding-top: 0;
}

/* ── SIDEBAR ── */
.wn-admin-sidebar {
    width: 240px;
    flex-shrink: 0;
    background: #111;
    border-right: 1px solid var(--wn-border);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0;
    height: 100vh;
    z-index: 200;
    transition: transform 0.3s ease;
    overflow-y: auto;
}
.wn-admin-logo {
    padding: 24px 20px 20px;
    border-bottom: 1px solid var(--wn-border);
    display: flex;
    align-items: center;
    gap: 10px;
}
.wn-admin-tag {
    background: var(--wn-red);
    color: white;
    font-size: 0.6rem;
    font-weight: 800;
    padding: 2px 7px;
    border-radius: 4px;
    letter-spacing: 0.1em;
}
.wn-admin-nav {
    padding: 16px 12px;
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex: 1;
}
.wn-admin-nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    color: var(--wn-muted);
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
    cursor: pointer;
}
.wn-admin-nav-link:hover { background: rgba(255,255,255,0.06); color: var(--wn-white); }
.wn-admin-nav-link.active { background: rgba(229,9,20,0.12); color: var(--wn-red); font-weight: 700; }
.wn-admin-nav-link i { width: 18px; text-align: center; font-size: 0.95rem; }
.wn-nav-badge {
    margin-left: auto;
    background: var(--wn-red);
    color: white;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
}
.wn-badge-green { background: #22c55e; }
.wn-admin-nav-divider { height: 1px; background: var(--wn-border); margin: 12px 0; }
.wn-nav-logout { color: #ff6b6b !important; margin-top: auto; }
.wn-nav-logout:hover { background: rgba(220,38,38,0.1) !important; }

/* ── MAIN ── */
.wn-admin-main {
    flex: 1;
    margin-left: 240px;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* ── TOP BAR ── */
.wn-admin-topbar {
    position: sticky;
    top: 0;
    background: rgba(13,13,13,0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--wn-border);
    padding: 16px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 100;
}
.wn-admin-topbar-left { display: flex; align-items: center; gap: 16px; }
.wn-sidebar-toggle {
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    color: var(--wn-text);
    border-radius: 6px;
    padding: 6px 10px;
    cursor: pointer;
    font-size: 1.1rem;
    display: none;
}
.wn-admin-page-title { font-size: 1.1rem; font-weight: 700; color: var(--wn-white); margin: 0; }
.wn-admin-topbar-right { display: flex; align-items: center; gap: 12px; }
.wn-admin-search {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    border-radius: 8px;
    padding: 7px 14px;
    color: var(--wn-muted);
}
.wn-admin-search input {
    background: transparent;
    border: none;
    outline: none;
    color: var(--wn-text);
    font-size: 0.85rem;
    width: 160px;
}
.wn-admin-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--wn-red), #8b0000);
    display: flex; align-items: center; justify-content: center;
    color: white; font-weight: 800; font-size: 0.9rem;
}

/* ── SECTIONS ── */
.wn-admin-section { display: none; padding: 28px; flex-direction: column; gap: 24px; }
.wn-admin-section.active { display: flex; }

/* ── STATS GRID ── */
.wn-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
.wn-stat-box {
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    position: relative;
    overflow: hidden;
    animation: wn-fadein 0.4s ease both;
}
.wn-stat-box::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}
.wn-stat-red::before { background: var(--wn-red); }
.wn-stat-blue::before { background: #3b82f6; }
.wn-stat-green::before { background: #22c55e; }
.wn-stat-yellow::before { background: #f5c518; }
.wn-stat-box-icon { font-size: 1.4rem; color: var(--wn-muted); }
.wn-stat-red .wn-stat-box-icon { color: var(--wn-red); }
.wn-stat-blue .wn-stat-box-icon { color: #3b82f6; }
.wn-stat-green .wn-stat-box-icon { color: #22c55e; }
.wn-stat-yellow .wn-stat-box-icon { color: #f5c518; }
.wn-stat-box-info { display: flex; flex-direction: column; }
.wn-stat-box-num { font-size: 1.8rem; font-weight: 800; color: var(--wn-white); line-height: 1; }
.wn-stat-box-label { font-size: 0.78rem; color: var(--wn-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; margin-top: 4px; }
.wn-stat-box-trend { font-size: 0.75rem; font-weight: 600; }
.wn-trend-up { color: #22c55e; }
.wn-trend-down { color: var(--wn-red); }

/* ── CHARTS ROW ── */
.wn-charts-row { display: grid; grid-template-columns: 1fr 280px; gap: 20px; }

/* ── ADMIN CARD ── */
.wn-admin-card {
    background: var(--wn-card);
    border: 1px solid var(--wn-border);
    border-radius: 14px;
    padding: 24px;
    animation: wn-fadein 0.4s ease both;
}
.wn-admin-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}
.wn-admin-card-header h3 { font-size: 1rem; font-weight: 700; color: var(--wn-white); margin: 0; }
.wn-header-actions { display: flex; gap: 10px; align-items: center; }
.wn-view-all-btn {
    background: transparent;
    border: 1px solid var(--wn-border);
    color: var(--wn-muted);
    padding: 5px 14px;
    border-radius: 6px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s;
}
.wn-view-all-btn:hover { border-color: var(--wn-red); color: var(--wn-red); }
.wn-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--wn-red);
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    cursor: pointer;
    transition: opacity 0.2s;
}
.wn-add-btn:hover { opacity: 0.85; }

/* ── BAR CHART ── */
.wn-chart-card { display: flex; flex-direction: column; }
.wn-bar-chart {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    height: 140px;
    padding-bottom: 8px;
}
.wn-bar {
    flex: 1;
    border-radius: 4px 4px 0 0;
    background: linear-gradient(180deg, var(--wn-red), rgba(229,9,20,0.4));
    transition: opacity 0.2s;
    cursor: pointer;
    min-width: 20px;
    animation: wn-bar-grow 0.6s ease both;
}
.wn-bar:hover { opacity: 0.8; }
.wn-bar.wn-bar-blue { background: linear-gradient(180deg, #3b82f6, rgba(59,130,246,0.4)); }
.wn-chart-labels { display: flex; gap: 8px; margin-top: 8px; }
.wn-chart-label { flex: 1; text-align: center; font-size: 0.7rem; color: var(--wn-muted); }
.wn-chart-tabs { display: flex; gap: 4px; }
.wn-chart-tab { background: transparent; border: 1px solid var(--wn-border); color: var(--wn-muted); padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; cursor: pointer; transition: all 0.2s; }
.wn-chart-tab.active { background: var(--wn-red); border-color: var(--wn-red); color: white; }

/* ── DONUT ── */
.wn-donut-card { display: flex; flex-direction: column; }
.wn-donut-wrap { position: relative; display: flex; align-items: center; justify-content: center; margin: 10px 0; }
.wn-donut-svg { width: 140px; height: 140px; }
.wn-donut-seg { transition: stroke-dasharray 1s ease; }
.wn-donut-center { position: absolute; text-align: center; }
.wn-donut-total { display: block; font-size: 1.3rem; font-weight: 800; color: var(--wn-white); }
.wn-donut-label { font-size: 0.72rem; color: var(--wn-muted); }
.wn-donut-legend { display: flex; flex-direction: column; gap: 8px; }
.wn-legend-item { display: flex; align-items: center; gap: 8px; font-size: 0.82rem; color: var(--wn-text); }
.wn-legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.wn-legend-item strong { margin-left: auto; color: var(--wn-white); }

/* ── TABLE ── */
.wn-admin-table-wrap { overflow-x: auto; }
.wn-admin-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
.wn-admin-table th { text-align: left; padding: 10px 14px; color: var(--wn-muted); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; border-bottom: 1px solid var(--wn-border); }
.wn-admin-table td { padding: 12px 14px; border-bottom: 1px solid rgba(42,42,42,0.5); color: var(--wn-text); vertical-align: middle; }
.wn-admin-table tr:hover td { background: rgba(255,255,255,0.02); }
.wn-admin-table tr:last-child td { border-bottom: none; }
.wn-table-user { display: flex; align-items: center; gap: 10px; }
.wn-table-avatar { width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; color: white; flex-shrink: 0; }
.wn-table-actions { display: flex; gap: 6px; }
.wn-tbl-btn { background: var(--wn-border); border: none; border-radius: 6px; padding: 6px 8px; cursor: pointer; font-size: 0.75rem; transition: all 0.2s; }
.wn-tbl-edit { color: #3b82f6; }
.wn-tbl-edit:hover { background: rgba(59,130,246,0.15); }
.wn-tbl-del { color: #ff6b6b; }
.wn-tbl-del:hover { background: rgba(220,38,38,0.15); }

/* ── CHIPS ── */
.wn-plan-chip { font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 10px; }
.wn-chip-premium { background: rgba(245,197,24,0.15); color: #f5c518; }
.wn-chip-free { background: rgba(255,255,255,0.08); color: var(--wn-muted); }
.wn-chip-movie { background: rgba(229,9,20,0.15); color: #ff6b6b; }
.wn-chip-series { background: rgba(59,130,246,0.15); color: #93c5fd; }
.wn-status-chip { font-size: 0.72rem; font-weight: 700; padding: 3px 10px; border-radius: 10px; }
.wn-status-success { background: rgba(34,197,94,0.15); color: #22c55e; }
.wn-status-failed { background: rgba(220,38,38,0.15); color: #ff6b6b; }
.wn-status-pending { background: rgba(245,197,24,0.15); color: #f5c518; }

/* ── Search input ── */
.wn-admin-search-input { background: #1a1a1a; border: 1px solid var(--wn-border); color: var(--wn-text); padding: 7px 14px; border-radius: 6px; font-size: 0.82rem; outline: none; transition: border-color 0.2s; }
.wn-admin-search-input:focus { border-color: var(--wn-red); }

/* ── Top list ── */
.wn-top-list { display: flex; flex-direction: column; gap: 14px; }
.wn-top-item { display: flex; align-items: center; gap: 12px; }
.wn-top-rank { width: 22px; height: 22px; border-radius: 50%; background: var(--wn-border); color: var(--wn-muted); font-size: 0.72rem; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.wn-top-info { flex: 1; min-width: 0; }
.wn-top-title { font-size: 0.85rem; color: var(--wn-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
.wn-top-views { font-size: 0.75rem; color: var(--wn-muted); white-space: nowrap; }
.wn-hist-progress-bar { height: 4px; background: var(--wn-border); border-radius: 2px; overflow: hidden; }
.wn-hist-progress-fill { height: 100%; background: linear-gradient(90deg, var(--wn-red), #ff4d57); border-radius: 2px; }

/* ── Modal ── */
.wn-modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.85); z-index: 1050; display: flex; align-items: center; justify-content: center; padding: 20px; }
.wn-modal-box { background: #1a1a1a; border: 1px solid var(--wn-border); border-radius: 16px; padding: 36px; width: 100%; position: relative; }
.wn-modal-title { font-size: 1.2rem; font-weight: 700; color: var(--wn-white); }
.wn-modal-close-btn { position: absolute; top: 14px; right: 14px; background: var(--wn-border); border: none; color: var(--wn-muted); border-radius: 50%; width: 30px; height: 30px; cursor: pointer; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s, color 0.2s; }
.wn-modal-close-btn:hover { background: var(--wn-red); color: white; }
.wn-form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.wn-form-group { display: flex; flex-direction: column; gap: 6px; }
.wn-form-label { font-size: 0.75rem; font-weight: 600; color: var(--wn-muted); text-transform: uppercase; letter-spacing: 0.06em; }
.wn-profile-form { display: flex; flex-direction: column; gap: 14px; }
.wn-form-actions { display: flex; gap: 10px; }

/* ── Keyframes ── */
@keyframes wn-fadein { from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)} }
@keyframes wn-bar-grow { from{height:0}to{height:100%} }

/* ── Responsive ── */
@media (max-width: 1100px) { .wn-stats-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 900px) {
    .wn-admin-sidebar { transform: translateX(-100%); }
    .wn-admin-sidebar.open { transform: translateX(0); }
    .wn-admin-main { margin-left: 0; }
    .wn-sidebar-toggle { display: block; }
    .wn-charts-row { grid-template-columns: 1fr; }
}
@media (max-width: 600px) { .wn-stats-grid { grid-template-columns: 1fr 1fr; } }
</style>
@endpush

@push('scripts')
<script>
/* ── Section navigation ── */
function showSection(name, el) {
    document.querySelectorAll('.wn-admin-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.wn-admin-nav-link').forEach(l => l.classList.remove('active'));
    document.getElementById('section-' + name).classList.add('active');
    if (el) el.classList.add('active');
    const titles = { overview:'Overview', users:'Users', movies:'Movies & Series', payments:'Payments', analytics:'Analytics' };
    document.getElementById('adminPageTitle').textContent = titles[name] || name;
    return false;
}

/* ── Sidebar toggle (mobile) ── */
function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('open');
}

/* ── Animated counters ── */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.wn-stat-box-num').forEach(function(el) {
        const target = parseInt(el.dataset.target);
        const suffix = el.dataset.suffix || '';
        let current = 0;
        const step = target / 50;
        const timer = setInterval(function() {
            current = Math.min(current + step, target);
            el.textContent = Math.floor(current).toLocaleString() + suffix;
            if (current >= target) clearInterval(timer);
        }, 30);
    });

    /* Revenue chart */
    buildChart('revenueChart', 'chartLabels',
        [820, 640, 990, 1200, 780, 1100, 1340],
        ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], false);

    /* Signups chart */
    buildChart('signupsChart', 'signupsLabels',
        [12, 8, 19, 24, 15, 21, 30],
        ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], true);
});

function buildChart(chartId, labelsId, data, labels, blue) {
    const chart = document.getElementById(chartId);
    const labelsEl = document.getElementById(labelsId);
    if (!chart || !labelsEl) return;
    const max = Math.max(...data);
    chart.innerHTML = '';
    labelsEl.innerHTML = '';
    data.forEach(function(val, i) {
        const bar = document.createElement('div');
        bar.className = 'wn-bar' + (blue ? ' wn-bar-blue' : '');
        bar.style.height = (val / max * 100) + '%';
        bar.title = labels[i] + ': ' + val;
        chart.appendChild(bar);
        const lbl = document.createElement('div');
        lbl.className = 'wn-chart-label';
        lbl.textContent = labels[i];
        labelsEl.appendChild(lbl);
    });
}

/* ── Filter table by search ── */
function filterTable(input, tableId) {
    const q = input.value.toLowerCase();
    document.querySelectorAll('#' + tableId + ' tbody tr').forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

/* ── Filter users by plan ── */
function filterByPlan(plan) {
    document.querySelectorAll('#usersTable tbody tr').forEach(function(row) {
        row.style.display = (plan === 'all' || row.dataset.plan === plan) ? '' : 'none';
    });
}

/* ── Delete row ── */
function deleteRow(btn) {
    if (confirm('Are you sure you want to delete this item?')) {
        btn.closest('tr').remove();
    }
}

/* ── Add movie modal ── */
function showAddMovieModal() {
    document.getElementById('addMovieModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function hideAddMovieModal() {
    document.getElementById('addMovieModal').style.display = 'none';
    document.body.style.overflow = '';
}
function closeAddMovieModal(e) {
    if (e.target === document.getElementById('addMovieModal')) hideAddMovieModal();
}
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') hideAddMovieModal(); });

/* ── Chart tabs ── */
document.querySelectorAll('.wn-chart-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.wn-chart-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
@endpush

@endsection