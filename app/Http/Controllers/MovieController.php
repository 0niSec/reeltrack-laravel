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
        $movies = Movie::orderBy('created_at', 'desc')->take(5)->get();

        return view('movies.index', compact('movies'));
    }

    /**
     * @param  string  $movie_id
     * @return View
     */
    public function show(string $movie_id): View
    {
        $movie = Movie::with('cast.person', 'crew.person', 'genres')->where('id', $movie_id)->first();

        return view('movies.show', compact('movie'));
    }

    public function popular()
    {
        return [
            'success' => true,
        ];
    }
}
