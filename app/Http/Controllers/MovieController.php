<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        // Get the newest movies from db
        $movies = [
            'newest' => Movie::select(['id', 'title', 'poster_path'])
                ->withReelStats()
                ->latest()
                ->take(5)
                ->get(),

            'popular' => Movie::select(['id', 'title', 'poster_path'])
                ->withReelStats()
                ->orderByDesc('likes_count')
                ->orderByDesc('avg_rating')
                ->take(5)
                ->get(),

            'latestReviews' => Movie::select(['id', 'title', 'poster_path'])
                ->whereHas('reels.reviews')
                ->withCount([
                    'reels' => function ($query) {
                        $query->whereHas('reviews');
                    },
                ])
                ->latest()
                ->take(10)
                ->get(),
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
        $userId = auth()->id();
        $cacheKey = 'movie_details_'.$movie->id;


        $cachedMovie = Cache::remember($cacheKey, 3600, function () use ($movie, $userId) {
            $movie = Movie::withFullDetails()->findOrFail($movie->id);

            // Add computed properties to the model instance
            $movie->likes_count = $movie->reels->where('is_liked', true)->count();
            $movie->ratings_count = $movie->reels->whereNotNull('rating')->count();
            $movie->avg_rating = $movie->reels->avg('rating');
            $movie->user_reel = $userId ? $movie->reels->firstWhere('user_id', $userId) : null;
            $movie->reviews = $movie->reels->pluck('reviews')->filter();

            return $movie;
        });


        // Return the view
        return view('movies.show', ['movie' => $cachedMovie]);
    }
}
