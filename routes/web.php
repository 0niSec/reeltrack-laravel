<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ReviewCommentController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TmdbController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserReviewController;
use App\Livewire\UserSettings;
use App\Livewire\UserSettingsAuth;
use Illuminate\Support\Facades\Route;

// Basic Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/welcome', 'welcome')->name('welcome');

// About Section
Route::prefix('about')->name('about.')->group(function () {
    Route::view('/faq', 'about.faq')->name('faq');
    Route::view('/creating-data', 'about.creating-data')->name('creating-data');
});
Route::permanentRedirect('/about', '/about/faq');

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('login', [SessionController::class, 'create'])->name('login');
    Route::post('login', [SessionController::class, 'store'])->middleware('throttle:login');
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});
Route::post('logout', [SessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// User Profiles
Route::name('users.')->group(function () {
    Route::get('{user}/profile', [UserProfileController::class, 'show'])
        ->whereAlphaNumeric('user')
        ->name('profile');

    Route::delete('{user}/profile', [UserProfileController::class, 'destroy'])
        ->name('profile.destroy')
        ->middleware(['auth'])
        ->can('delete', 'user.profile');
});

Route::redirect('/users/{user}', '/users/{user}/profile');


// Reviews
// Review creation handling is done in ReviewModal
Route::prefix('users/{user}/movies/{movie}')->name('reviews.')->group(function () {
    Route::get('reviews', [UserReviewController::class, 'index'])
        ->name('index');
    Route::get('reviews/{review}', [UserReviewController::class, 'show'])
        ->name('show');
    Route::delete('reviews/{review}', [UserReviewController::class, 'destroy'])
        ->name('destroy')
        ->middleware('auth')
        ->can('destroy', 'review');
});

// Comments
Route::prefix('users/{user}/reviews/{review}/comments')->name('comments.')->middleware('auth')->scopeBindings()->group(function (
) {
    Route::post('/', [ReviewCommentController::class, 'store'])->name('store');
    Route::delete('/{comment}', [ReviewCommentController::class, 'destroy'])->name('destroy');
});


// User Settings
Route::prefix('settings')->name('settings.')->middleware('auth')->group(function () {
    Route::get('/', UserSettings::class)->name('profile');
    Route::get('auth', UserSettingsAuth::class)->name('auth');
});


// Import Route
Route::get('/tmdb/{type}/{id}', [TmdbController::class, 'findOrCreate'])
    ->whereIn('type', ['movie', 'tv'])
    ->whereNumber('id')
    ->name('findOrCreate')
    ->middleware('auth');

// Movies
Route::name('movies.')->group(function () {
    Route::get('/movies', [MovieController::class, 'index'])->name('index');
    Route::get('/new', [MovieController::class, 'new'])->name('new');
    Route::get('/popular', [MovieController::class, 'popular'])->name('popular');
    Route::get('/{movie}', [MovieController::class, 'show'])->name('show');
    Route::get('/{movie}/cast-and-crew', [MovieController::class, 'castAndCrew'])->name('cast-and-crew');
});

