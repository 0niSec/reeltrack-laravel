<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;

class MovieController extends Controller
{
    public function index(TmdbService $tmdb)
    {
        $popularMovies = $tmdb->popularMovies();

        // Get the results from the JSON
        $movies = $popularMovies['results'] ?? [];

        return view('movies.index', compact('movies'));
    }
}
