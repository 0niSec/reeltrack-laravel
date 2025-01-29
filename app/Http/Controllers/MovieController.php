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
     * @param  string  $movie_id
     * @return View
     */
    public function show(string $movie_id): View
    {
        // TODO: Handle where the ID doesn't exist
        $movie = Movie::with('cast.person', 'crew.person', 'genres')->where('id', $movie_id)->first();

        if (!$movie) {
            abort(404);
        }

        return view('movies.show', compact('movie'));
    }

    public function popular()
    {
        return [
            'success' => true,
        ];
    }
}
