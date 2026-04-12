<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchHistoryController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;

// PUBLIC (no authentication required)

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/browse', [ContentController::class, 'index'])->name('content.index');
Route::get('/content/{content}', [ContentController::class, 'show'])->name('content.show');
Route::get('/plans', [SubscriptionController::class, 'plans'])->name('subscriptions.plans');

// Flouci callbacks — outside auth middleware (session may not persist through redirect)
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');

// AUTH (any logged-in user)

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Breeze default profile (temporary — remove when UserController views are ready!!)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // WolfNet user profile
    Route::get('/user/profile', [UserController::class, 'show'])->name('user.profile');
    Route::patch('/user/profile', [UserController::class, 'update'])->name('user.update');

    // Streaming
    Route::get('/watch/{content}', [StreamController::class, 'stream'])->name('stream.play');
    Route::post('/stream/progress', [StreamController::class, 'progress'])->name('stream.progress');

    // Watchlist
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/watchlist/{content}/add', [WatchlistController::class, 'add'])->name('watchlist.add');
    Route::delete('/watchlist/{content}/remove', [WatchlistController::class, 'remove'])->name('watchlist.remove');

    // Watch history
    Route::get('/history', [WatchHistoryController::class, 'history'])->name('watchhistory.index');
    Route::post('/history/record', [WatchHistoryController::class, 'record'])->name('watchhistory.record');

    // Subscriptions
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');

    // Payments
    Route::post('/payment/checkout/{plan}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

});

// ADMIN (auth + isAdmin() enforced inside each controller)

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User management
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::post('/users/{user}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
    Route::post('/users/{user}/reactivate', [AdminController::class, 'reactivateUser'])->name('users.reactivate');

    // Content management
    Route::get('/content', [ContentController::class, 'adminIndex'])->name('content.index');
    Route::get('/content/create', [ContentController::class, 'create'])->name('content.create');
    Route::post('/content', [ContentController::class, 'store'])->name('content.store');
    Route::get('/content/{content}/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/{content}', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{content}', [ContentController::class, 'destroy'])->name('content.destroy');

    // Subscription plan management
    Route::get('/plans', [SubscriptionPlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [SubscriptionPlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [SubscriptionPlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [SubscriptionPlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [SubscriptionPlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [SubscriptionPlanController::class, 'destroy'])->name('plans.destroy');

    // Overviews
    Route::get('/subscriptions', [SubscriptionController::class, 'adminIndex'])->name('subscriptions.index');
    Route::get('/payments', [PaymentController::class, 'adminIndex'])->name('payments.index');

});

require __DIR__ . '/auth.php';