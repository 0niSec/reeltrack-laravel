<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Contracts\View\View;

class MovieController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        // Get the newest movies from db
        $movies = Movie::latest()->take(5)->get();

        return view('movies.index', compact('movies'));
    }

    /**
     * @param  Movie  $movie
     * @return View
     */
    public function show(Movie $movie): View
    {
        // Eager load the relationships to reduce number of queries
        $movie->load('cast.person', 'crew.person', 'genres');

        // Return the view
        return view('movies.show', compact('movie'));
    }

    public function popular()
    {
        return [
            'success' => true,
        ];
    }
}
