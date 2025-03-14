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
        // Use eager loading with select and only retrieve necessary fields
        $movies = [
            'newest' => Movie::newest()->take(6)->get(),
            'popular' => Movie::popular()->take(6)->get(),
            'latestReviews' => Movie::latestReviews()->take(6)->get(),
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
        // Eager load with specific fields to reduce data transfer
        $movie->load([
            'cast.person:id,name,profile_path',
            'crew.person:id,name,profile_path',
        ]);

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

        // Cache only the base movie details that don't change frequently
        $cachedMovie = Cache::remember($cacheKey, 3600, function () use ($movie) {
            return Movie::withFullDetails()
                ->findOrFail($movie->id);
        });

        // For authenticated users, load their specific interactions
        if ($userId) {
            // Load both user-specific interactions in a single query with conditional selects
            $userSpecificData = $movie->userInteractions()
                ->where('user_id', $userId)
                ->first();

            $userReelEntry = $movie->reelEntries()
                ->where('user_id', $userId)
                ->latest('watched_at')
                ->first();

            $cachedMovie->user_interaction = $userSpecificData;
            $cachedMovie->user_reel = $userReelEntry;
        } else {
            $cachedMovie->user_interaction = null;
            $cachedMovie->user_reel = null;
        }


        // Use Query Builder to calculate stats directly in the database
        $interactionStats = $movie->userInteractions()
            ->selectRaw('
            SUM(CASE WHEN is_liked = true THEN 1 ELSE 0 END) as likes_count,
            COUNT(CASE WHEN rating IS NOT NULL THEN 1 ELSE NULL END) as ratings_count,
            AVG(CASE WHEN rating IS NOT NULL THEN rating ELSE NULL END) as avg_rating
        ')
            ->first();

        $cachedMovie->likes_count = $interactionStats->likes_count ?? 0;
        $cachedMovie->ratings_count = $interactionStats->ratings_count ?? 0;
        $cachedMovie->avg_rating = $interactionStats->avg_rating ?? 0;


        $reviews = $movie->reviews()->with(['user', 'reelEntry'])->latest()->paginate(5);


        return view('movies.show')->with(['movie' => $cachedMovie, 'reviews' => $reviews]);
    }
}
