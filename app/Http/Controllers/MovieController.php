<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\ReelEntry;
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
        $newestMovies = Movie::select(['id', 'slug', 'poster_path'])
            ->withCount([
                'userInteractions',
                'userInteractions as likes_count' => fn($query) => $query->where('is_liked', true),
                'userInteractions as ratings_count' => fn($query) => $query->whereNotNull('rating'),
            ])
            ->withAvg('userInteractions as ratings_avg_rating', 'rating')
            ->latest()
            ->take(5)
            ->get();

        $popularMovies = Movie::select(['id', 'slug', 'poster_path'])
            ->withCount([
                'userInteractions',
                'userInteractions as likes_count' => fn($query) => $query->where('is_liked', true),
                'userInteractions as ratings_count' => fn($query) => $query->whereNotNull('rating'),
            ])
            ->withAvg('userInteractions as ratings_avg_rating', 'rating')
            ->orderByDesc('likes_count')
            ->orderByDesc('ratings_avg_rating')
            ->take(5)
            ->get();

        $latestReviews = ReelEntry::select([
            'id', 'user_id', 'reelable_id', 'reelable_type',
            'rating', 'is_liked', 'watched_at', 'review_content',
        ])
            ->whereNotNull('review_content')
            ->where('reelable_type', Movie::class)
            ->with([
                'reelable:id,slug,poster_path',
                'user:id,username',
            ])
            ->latest('watched_at')
            ->take(5)
            ->get();

        $movies = [
            'newest' => $newestMovies,
            'popular' => $popularMovies,
            'latestReviews' => $latestReviews,
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

        // Load user-specific data separately, since it changes frequently and shouldn't be cached
        if ($userId) {
            $cachedMovie->load([
                'userInteractions' => fn($query) => $query->where('user_id', $userId),
                'reelEntries' => fn($query) => $query->where('user_id', $userId)->latest('watched_at'),
            ]);

            // Set user-specific properties using loaded relationships
            $cachedMovie->user_interaction = $cachedMovie->userInteractions->first();
            $cachedMovie->user_reel = $cachedMovie->reelEntries->first();
        } else {
            $cachedMovie->user_interaction = null;
            $cachedMovie->user_reel = null;
        }

        // Load all interactions and calculate stats from them (single query)
        $userInteractions = $movie->userInteractions()->get();

        // Use collection methods for calculations
        $cachedMovie->likes_count = $userInteractions->where('is_liked', true)->count();
        $cachedMovie->ratings_count = $userInteractions->whereNotNull('rating')->count();
        $cachedMovie->avg_rating = $userInteractions->whereNotNull('rating')->avg('rating');

        // Load reviews with related data in a single query
        $cachedMovie->reviews = $movie->reelEntries()
            ->with(['reviews.user', 'user'])
            ->whereHas('reviews')
            ->latest()
            ->get()
            ->flatMap(function ($reelEntry) {
                // Map reviews with their author data for the view
                return $reelEntry->reviews;
            })
            ->sortByDesc('created_at');


        return view('movies.show', ['movie' => $cachedMovie]);
    }
}
