<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class MovieController extends Controller
{
    /**
     * @return Factory|View|Application|\Illuminate\View\View
     */
    public function index()
    {
        // Get the newest movies from db
        $movies = Movie::orderBy('created_at', 'desc')->take(5)->get();
        return view('movies.index', compact('movies'));
    }

    /**
     * @param $movie_id
     * @return Factory|View|Application|\Illuminate\View\View
     */
    public function show($movie_id)
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
