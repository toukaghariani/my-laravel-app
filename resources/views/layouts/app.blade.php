<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WolfNet - @yield('title', 'Watch Movies & Series')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- WolfNet Custom CSS -->
    <link href="{{ asset('css/wolfnet.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <!-- Admin Dashboard Button -->
<a href="{{ url('/admin') }}" class="wn-admin-fab" title="Admin Dashboard">
    <div class="wn-fab-glow"></div>
    <i class="bi bi-speedometer2 wn-fab-icon"></i>
    <span class="wn-fab-label">Admin</span>
</a>

<style>
.wn-admin-fab {
    position: fixed;
    bottom: 32px;
    right: 32px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #f5c518, #e6a800);
    color: #000;
    text-decoration: none;
    padding: 14px 22px 14px 18px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 0.88rem;
    letter-spacing: 0.03em;
    z-index: 999;
    box-shadow: 0 6px 30px rgba(245,197,24,0.45),
                0 2px 8px rgba(0,0,0,0.4);
    transition: transform 0.25s ease,
                box-shadow 0.25s ease,
                padding 0.25s ease;
    overflow: hidden;
}
.wn-admin-fab:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 14px 40px rgba(245,197,24,0.65),
                0 4px 16px rgba(0,0,0,0.5);
    color: #000;
}
.wn-admin-fab:active {
    transform: translateY(0) scale(0.97);
}

/* Animated glow pulse */
.wn-fab-glow {
    position: absolute;
    inset: 0;
    border-radius: 50px;
    background: linear-gradient(135deg,
        rgba(255,255,255,0.35) 0%,
        transparent 60%);
    pointer-events: none;
    animation: wn-fab-pulse 2.5s ease-in-out infinite;
}
@keyframes wn-fab-pulse {
    0%, 100% { opacity: 0.6; }
    50%       { opacity: 1; }
}

/* Icon spin on hover */
.wn-fab-icon {
    font-size: 1.15rem;
    position: relative;
    transition: transform 0.4s ease;
}
.wn-admin-fab:hover .wn-fab-icon {
    transform: rotate(20deg);
}

/* Label */
.wn-fab-label {
    position: relative;
    font-size: 0.85rem;
    font-weight: 800;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

/* Ripple ring around button */
.wn-admin-fab::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 54px;
    border: 2px solid rgba(245,197,24,0.4);
    animation: wn-fab-ring 2.5s ease-in-out infinite;
    pointer-events: none;
}
@keyframes wn-fab-ring {
    0%, 100% { opacity: 0; transform: scale(1); }
    50%       { opacity: 1; transform: scale(1.06); }
}
</style>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg wn-navbar fixed-top">
        <div class="container-fluid px-4">

            <!-- Logo -->
            <a class="navbar-brand wn-logo" href="{{ url('/') }}">
                WOLF<span>NET</span>
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="bi bi-list text-white fs-4"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">

                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-4">
                    <li class="nav-item">
                        <a class="nav-link wn-nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link wn-nav-link" href="{{ url('/movies') }}">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link wn-nav-link" href="{{ url('/series') }}">Series</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link wn-nav-link" href="{{ url('/favorites') }}">
                            <i class="bi bi-heart-fill text-danger"></i> Favorites
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link wn-nav-link" href="{{ url('/profile') }}">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link wn-nav-link" href="{{ url('/watchlist') }}">
                            <i class="bi bi-bookmark-fill"></i> Watchlist
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link wn-nav-link" href="{{ url('/history') }}">
                            <i class="bi bi-clock-history"></i> History
                        </a>
                    </li>
                </ul>

                <!-- Search bar -->
                <form class="d-flex me-3 wn-search-form" action="{{ url('/search') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control wn-search-input"
                               type="search" name="q"
                               placeholder="Search movies, series...">
                        <button class="btn wn-search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Auth buttons -->
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle wn-nav-link" href="#"
                               data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu wn-dropdown">
                                <li><a class="dropdown-item wn-dropdown-item" href="{{ url('/profile') }}">
                                    <i class="bi bi-person me-2"></i>Profile
                                </a></li>
                                <li><a class="dropdown-item wn-dropdown-item" href="{{ url('/watchlist') }}">
                                    <i class="bi bi-bookmark me-2"></i>Watchlist
                                </a></li>
                                <li><a class="dropdown-item wn-dropdown-item" href="{{ url('/history') }}">
                                    <i class="bi bi-clock-history me-2"></i>Watch History
                                </a></li>
                                <li><hr class="dropdown-divider wn-divider"></li>
                                <li>
                                    <form action="{{ url('/logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item wn-dropdown-item" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn wn-btn-outline" href="{{ url('/login') }}">Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn wn-btn-primary" href="{{ url('/register') }}">Get Started</a>
                        </li>
                    @endauth
                </ul>

            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main class="wn-main">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="wn-footer mt-5">
        <div class="container">
            <div class="row py-5">
                <div class="col-md-4 mb-4">
                    <h5 class="wn-logo mb-3">WOLF<span>NET</span></h5>
                    <p class="text-muted small">Your premium streaming platform for the best movies and series.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-white mb-3">Browse</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="wn-footer-link">Home</a></li>
                        <li><a href="{{ url('/movies') }}" class="wn-footer-link">Movies</a></li>
                        <li><a href="{{ url('/series') }}" class="wn-footer-link">Series</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="text-white mb-3">Account</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/login') }}" class="wn-footer-link">Sign In</a></li>
                        <li><a href="{{ url('/register') }}" class="wn-footer-link">Register</a></li>
                        <li><a href="{{ url('/premium') }}" class="wn-footer-link">Premium</a></li>
                        <li><a href="{{ url('/profile') }}" class="wn-footer-link">My Profile</a></li>
                        <li><a href="{{ url('/watchlist') }}" class="wn-footer-link">Watchlist</a></li>
                        <li><a href="{{ url('/history') }}" class="wn-footer-link">Watch History</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="text-white mb-3">WolfNet</h6>
                    <p class="text-muted small">Groupe 5 — Université 2025/2026</p>
                </div>
            </div>
            <hr class="wn-divider">
            <p class="text-center text-muted small py-3">© 2026 WolfNet. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>