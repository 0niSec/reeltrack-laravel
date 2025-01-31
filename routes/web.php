<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TmdbController;
use App\Http\Controllers\TvSeriesController;
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
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);


Route::get('/users/profile/{id}', function ($id) {
    return [
        'success' => true,
        'id' => $id,
    ];
})->name('profile');
// END AUTH

Route::get('/search', function () {
    return array(
        'success' => true,
    );
})->name('search');

Route::get('/tmdb/{type}/{id}', [TmdbController::class, 'findOrCreate'])
    ->whereIn('type', ['movie', 'tv'])->whereNumber('id')
    ->name('findOrCreate');

Route::get('/movies/popular', [MovieController::class, 'popular'])->name('movies.popular');
Route::get('/movies/new', [MovieController::class, 'new'])->name('movies.new');

Route::resource('movies', MovieController::class)->only([
    'index', 'show', 'create', 'store', 'edit', 'update', 'destroy',
])->whereNumber('id');

Route::resource('series', TvSeriesController::class)->only([
    'index', 'show', 'create', 'store', 'edit', 'update', 'destroy',
]);


Route::get('/search/{id}', function ($id) {
    return array(
        'success' => true,
        'data' => $id,
    );
});
