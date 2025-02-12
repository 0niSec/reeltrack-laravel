<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReelController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TmdbController;
use App\Http\Controllers\TvSeriesController;
use App\Http\Controllers\UserProfileController;
use App\Livewire\MovieShow;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('index');
})->name('index');

Route::view('/welcome', 'welcome')->name('welcome');

// About
Route::prefix('about')->group(function () {
    Route::view('/faq', 'about.faq')->name('about.faq');
    Route::view('/creating-data', 'about.creating-data')->name('about.creating-data');
});

// Redirect /about to faq
Route::redirect('/about', '/about/faq');

// AUTH
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->middleware('throttle:login');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
// END AUTH

//**************************************//
// User Profiles //

Route::get('/users/{user:username}/profile', [UserProfileController::class, 'show'])
    ->whereAlphaNumeric('user:username')
    ->name('profile');

Route::get('/users/{user:username}/profile/settings', [UserProfileController::class, 'edit'])
    ->name('profile.settings.edit')
    ->middleware('auth')
    ->can('edit', 'user.profile');

Route::post('/users/{user:username}/profile/delete',
    [UserProfileController::class, 'destroy'])
    ->name('profile.delete')
    ->middleware('auth')
    ->can('delete',
        'user.profile');

Route::patch('/users/{user:username}/profile/settings',
    [UserProfileController::class, 'update'])
    ->name('profile.settings.update')
    ->middleware('auth')
    ->can('edit',
        'user.profile');

//*************************************//

Route::get('/tmdb/{type}/{id}', [TmdbController::class, 'findOrCreate'])
    ->whereIn('type', ['movie', 'tv'])
    ->whereNumber('id')
    ->name('findOrCreate')
    ->middleware('auth');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{movie}/cast-and-crew', [MovieController::class, 'castAndCrew'])->name('movies.cast-and-crew');
Route::post('/movies/{movie}/reel', [ReelController::class, 'store'])
    ->name('movies.reel.store')
    ->middleware('auth')
    ->can('create', 'reel');
Route::patch('/movies/{movie}/reel/{reel}/edit', [ReelController::class, 'update'])
    ->name('movies.reel.edit')
    ->middleware('auth')
    ->can('update', 'reel');
Route::get('/movies/popular', [MovieController::class, 'popular'])->name('movies.popular');
Route::get('/movies/new', [MovieController::class, 'new'])->name('movies.new');


Route::resource('series', TvSeriesController::class)->only([
    'index', 'show', 'create', 'store', 'edit', 'update', 'destroy',
]);
