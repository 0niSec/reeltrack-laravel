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

    public function castAndCrew(Movie $movie): View
    {
        $movie->load('cast.person', 'crew.person');

        return view('movies.cast-and-crew', compact('movie'));
    }

    /**
     * @param  Movie  $movie
     * @return View
     */
    public function show(Movie $movie): View
    {
        $movie->load([
            'cast' => fn($query) => $query
                ->orderBy('order', 'asc')
                ->take(10)
                ->with('person'),
            'crew' => fn($query) => $query
                ->whereIn('department', ['Directing', 'Writing', 'Production'])
                ->orderBy('order', 'asc')
                ->take(10)
                ->with('person'),
            'genres',
            'reviews',
        ])
            ->loadCount([
                'ratings',
                'likes' => fn($query) => $query->where('status', true),
            ])
            ->loadAvg('ratings as avg_rating', 'rating');

//        $movie->loadCount([
//            'ratings',
//            'likes' => fn($query) => $query->where('status', true),
//        ])->loadAvg('ratings as avg_rating', 'rating')
//            ->load([
//                'cast' => fn($query) => $query->with('person')
//                    ->orderBy('order', 'asc')
//                    ->take(10),
//                'crew' => fn($query) => $query->with('person')
//                    ->whereIn('department', [
//                        'Directing',
//                        'Writing',
//                        'Production',
//                    ]),
//                'genres',
//                'reviews',
//            ]);

        // Return the view
        return view('movies.show', compact('movie'));
    }
}
