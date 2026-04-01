<?php

use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------
| PUBLIC ROUTES
|----------------------------------------------------------
*/

// Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// Login page (GET = show form)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Register page (GET = show form)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');


/*
|----------------------------------------------------------
| AUTH ROUTES (POST = form submission)
| TODO for Backend Dev: replace closures with controller methods
|----------------------------------------------------------
*/

// Login form submission
Route::post('/login', function () {
    // TODO: Backend dev → AuthController@login
})->name('login.submit');

// Register form submission
Route::post('/register', function () {
    // TODO: Backend dev → AuthController@register
})->name('register.submit');

// Logout
Route::post('/logout', function () {
    // TODO: Backend dev → AuthController@logout
})->name('logout');


/*
|----------------------------------------------------------
| BROWSE ROUTES
|----------------------------------------------------------
*/

Route::get('/movies', function () {
    return view('movies');
})->name('movies');

Route::get('/series', function () {
    return view('series');
})->name('series');

Route::get('/movie/{id}', function ($id) {
    return view('movie');
})->name('movie.show');

Route::get('/search', function () {
    return view('search');
})->name('search');


/*
|----------------------------------------------------------
| USER ROUTES
| TODO for Backend Dev: add auth middleware
|----------------------------------------------------------
*/

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');

Route::get('/watchlist', function () {
    return view('watchlist');
})->name('watchlist');

Route::get('/history', function () {
    return view('history');
})->name('history');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/premium', function () {
    return view('premium');
})->name('premium');


/*
|----------------------------------------------------------
| ADMIN ROUTES
| TODO for Backend Dev: add admin middleware
|----------------------------------------------------------
*/

Route::get('/admin', function () {
    return view('admin');
})->name('admin');



Route::get('/watch/{id}', function ($id) {
    return view('watch');
})->name('watch');

Route::get('/subscriptions/plans', function () {
    return view('subscriptions.plans');
})->name('subscriptions.plans');

Route::post('/watch/progress', function () {
    // TODO: Backend → WatchProgressController@store
})->name('watch.progress');

Route::get('/watch/progress/{id}', function ($id) {
    // TODO: Backend → WatchProgressController@get
})->name('watch.progress.get');

Route::get('/admin/videos', function () {
    return view('admin.videos.index');
})->name('admin.videos.index');

Route::get('/admin/videos/create', function () {
    return view('admin.videos.create');
})->name('admin.videos.create');

Route::get('/admin/videos/{id}/edit', function ($id) {
    return view('admin.videos.edit');
})->name('admin.videos.edit');

Route::get('/watch/{id}/stream', function ($id) {
    // TODO: Backend dev → fetch real stream URL from database
    // Example response:
    return response()->json([
        'url' => 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8', // test HLS stream
        'type' => 'hls',
        'quality' => '720p'
    ]);
})->name('watch.stream');