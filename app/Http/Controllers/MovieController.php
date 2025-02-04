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
        $movies = [
            'newest' => Movie::withStats()->latest()->take(5)->get(),
            'popular' => Movie::withStats()->popular()->get(),
            'latestReviews' => Movie::latestReviews()->get(),
        ];

        return view('movies.index', compact('movies'));
    }

    public function popular()
    {
        return [
            'success' => true,
        ];
    }

    /**
     * @param  Movie  $movie
     * @return View
     */
    public function show(Movie $movie): View
    {
        $movie->loadCount([
            'ratings',
            'likes' => fn($query) => $query->where('status', true),
        ])->loadAvg('ratings', 'rating')
            ->load([
                'cast' => fn($query) => $query->with('person')
                    ->orderBy('order', 'asc')
                    ->take(10),
                'crew' => fn($query) => $query->with('person')
                    ->whereIn('department', [
                        'Directing',
                        'Writing',
                        'Production',
                    ]),
                'genres',
                'reviews',
            ]);

        // Return the view
        return view('movies.show', compact('movie'));
    }
}
