<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

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

Route::get('/movies', [MovieController::class, 'index']);

Route::get('/search/{id}', function ($id) {
    return array(
        'success' => true,
        'data' => $id,
    );
});
