@extends('layouts.app')

@section('title', 'Home - Watch Movies & Series')

@section('content')

    <!-- HERO SECTION -->
    <section class="wn-hero">
        <div class="wn-hero-overlay"></div>
        <div class="wn-hero-content container">
            <div class="row">
                <div class="col-lg-6">
                    <span class="wn-hero-badge">🔥 Trending Now</span>
                    <h1 class="wn-hero-title">Unlimited Movies & Series</h1>
                    <p class="wn-hero-desc">
                        Stream the latest movies, binge-watch top series, and discover
                        new favorites — all in one place.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ url('/register') }}" class="btn wn-btn-primary btn-lg">
                            <i class="bi bi-play-fill me-1"></i> Start Watching
                        </a>
                        <a href="{{ url('/movies') }}" class="btn wn-btn-outline btn-lg">
                            <i class="bi bi-grid me-1"></i> Browse All
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TRENDING MOVIES SECTION -->
    <section class="container py-5">

        <h2 class="wn-section-title">🎬 Trending Movies</h2>

        <div class="row g-3" id="trending-movies">
            <!-- Cards injected here by JS or Blade loop -->
            <!-- STATIC PLACEHOLDERS for now -->
            @for ($i = 1; $i <= 6; $i++)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="wn-card">
                    <img src="https://via.placeholder.com/300x450/1c1c1c/e50914?text=Movie+{{ $i }}"
                         alt="Movie {{ $i }}">
                    <div class="wn-card-body">
                        <p class="wn-card-title">Movie Title {{ $i }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="wn-card-meta">2024</span>
                            <span class="wn-rating">
                                <i class="bi bi-star-fill"></i> 7.{{ $i }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

    </section>

    <!-- POPULAR SERIES SECTION -->
    <section class="wn-section-dark py-5">
        <div class="container">

            <h2 class="wn-section-title">📺 Popular Series</h2>

            <div class="row g-3">
                @for ($i = 1; $i <= 6; $i++)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="wn-card">
                        <img src="https://via.placeholder.com/300x450/1c1c1c/808080?text=Series+{{ $i }}"
                             alt="Series {{ $i }}">
                        <div class="wn-card-body">
                            <p class="wn-card-title">Series Title {{ $i }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="wn-card-meta">2024</span>
                                <span class="wn-rating">
                                    <i class="bi bi-star-fill"></i> 8.{{ $i }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

        </div>
    </section>

    <!-- WHY WOLFNET SECTION -->
    <section class="container py-5">
        <h2 class="wn-section-title text-center border-0 ps-0">Why WolfNet?</h2>
        <div class="row g-4 mt-2 text-center">
            <div class="col-md-4">
                <div class="wn-feature-card">
                    <i class="bi bi-play-circle wn-feature-icon"></i>
                    <h5 class="text-white mt-3">HD Streaming</h5>
                    <p class="text-muted small">Watch in crystal clear HD quality on any device, anytime.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wn-feature-card">
                    <i class="bi bi-heart wn-feature-icon"></i>
                    <h5 class="text-white mt-3">My Favorites</h5>
                    <p class="text-muted small">Save your favorite movies and series to watch later.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="wn-feature-card">
                    <i class="bi bi-shield-check wn-feature-icon"></i>
                    <h5 class="text-white mt-3">Premium Access</h5>
                    <p class="text-muted small">Unlock exclusive content with our premium subscription.</p>
                </div>
            </div>
        </div>
    </section>

@endsection