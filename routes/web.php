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
});

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
| PROTECTED ROUTES (require login)
| TODO for Backend Dev: add auth middleware
|----------------------------------------------------------
*/

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');

Route::get('/premium', function () {
    return view('premium');
})->name('premium');

Route::get('/search', function () {
    return view('search');
})->name('search');