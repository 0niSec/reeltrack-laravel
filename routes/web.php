<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReelController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TmdbController;
use App\Http\Controllers\TvSeriesController;
use App\Http\Controllers\UserProfileController;
use App\Livewire\UserSettings;
use App\Livewire\UserSettingsAuth;
use Illuminate\Support\Facades\Route;

//*************************************************************************************************************//
// INDEX
Route::get('/', function () {
    return view('index', ['user' => auth()->user()]);
})->name('index');
//*************************************************************************************************************//

// WELCOME
Route::view('/welcome', 'welcome')->name('welcome');

//*************************************************************************************************************//
// ABOUT GROUP
Route::prefix('about')->group(function () {
    Route::view('/faq', 'about.faq')->name('about.faq');
    Route::view('/creating-data', 'about.creating-data')->name('about.creating-data');
});

// Redirect /about to faq
Route::permanentRedirect('/about', '/about/faq');
//*************************************************************************************************************//

//*************************************************************************************************************//
// AUTH
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->middleware('throttle:login');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
//*************************************************************************************************************//

//*************************************************************************************************************//
// PROFILES
Route::get('/users/{user:username}/profile', [UserProfileController::class, 'show'])
    ->whereAlphaNumeric('user:username')
    ->name('profile');

Route::post('/users/{user:username}/profile/delete',
    [UserProfileController::class, 'destroy'])
    ->name('profile.delete')
    ->whereAlphaNumeric('user:username')
    ->middleware('auth')
    ->can('delete',
        'user.profile');


//*************************************************************************************************************//

Route::middleware(['auth'])->prefix('settings')->name('settings.')->group(function () {
    Route::get('/', UserSettings::class)->name('profile');
    Route::get('/auth', UserSettingsAuth::class)->name('auth');

    // Add more settings routes as needed
    // Route::get('/notifications', Livewire\Settings\Notifications::class)->name('notifications');
    // Route::get('/privacy', Livewire\Settings\Privacy::class)->name('privacy');
});


//*************************************************************************************************************//
// TMDB IMPORT ROUTE SINGLETON
Route::get('/tmdb/{type}/{id}', [TmdbController::class, 'findOrCreate'])
    ->whereIn('type', ['movie', 'tv'])
    ->whereNumber('id')
    ->name('findOrCreate')
    ->middleware('auth');
//*************************************************************************************************************//

//*************************************************************************************************************//
// MOVIES
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
//*************************************************************************************************************//

//*************************************************************************************************************//
// TV TODO: These are placeholders
Route::resource('series', TvSeriesController::class)->only([
    'index', 'show', 'create', 'store', 'edit', 'update', 'destroy',
]);
//*************************************************************************************************************//
