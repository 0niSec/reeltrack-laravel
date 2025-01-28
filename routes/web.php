<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\TvSeriesController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('index');
});

Route::view('/welcome', 'welcome')->name('welcome');

// About
Route::prefix('about')->group(function () {
    Route::view('/faq', 'about.faq')->name('about.faq');
    Route::view('/creating-data', 'about.creating-data')->name('about.creating-data');
});

// Redirect /about to faq
Route::redirect('/about', '/about/faq');

// AUTH
Route::get('/login', function () {
    return [
        'success' => true,
    ];
})->name('login');

Route::get('/register', function () {
    return [
        'success' => true,
    ];
})->name('register');

Route::get('/logout', function () {
    return [];
})->name('logout');

Route::get('/profile', function () {
    return [
        'success' => true,
    ];
})->name('profile');
// END AUTH

Route::get('/search', function () {
    return array(
        'success' => true,
    );
})->name('search');

Route::get('/movies/popular', [MovieController::class, 'popular'])->name('movies.popular');
Route::get('/movies/new', [MovieController::class, 'new'])->name('movies.new');

Route::resource('movies', MovieController::class)->only([
    'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
]);

Route::resource('series', TvSeriesController::class)->only([
    'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
]);


Route::get('/search/{id}', function ($id) {
    return array(
        'success' => true,
        'data' => $id,
    );
});
