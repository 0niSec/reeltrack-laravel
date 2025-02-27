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
                ->withCount([
                    'userInteractions',
                    'userInteractions as likes_count' => fn($query) => $query->where('is_liked', true),
                    'userInteractions as ratings_count' => fn($query) => $query->whereNotNull('rating'),
                ])
                ->withAvg('userInteractions as ratings_avg_rating', 'rating')
                ->latest()
                ->take(5)
                ->get(),

            'popular' => Movie::select(['id', 'title', 'poster_path'])
                ->withCount([
                    'userInteractions',
                    'userInteractions as likes_count' => fn($query) => $query->where('is_liked', true),
                    'userInteractions as ratings_count' => fn($query) => $query->whereNotNull('rating'),
                ])
                ->withAvg('userInteractions as ratings_avg_rating', 'rating')
                ->orderByDesc('likes_count')
                ->orderByDesc('ratings_avg_rating')
                ->take(5)
                ->get(),

            'latestReviews' => Movie::select(['id', 'title', 'poster_path'])
                ->whereHas('reelEntries', fn($query) => $query->whereNotNull('review_content'))
                ->withCount('reelEntries as reviews_count')
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
            return Movie::withFullDetails()
                ->with([
                    'userInteractions' => fn($query) => $query->where('user_id', $userId),
                    'reelEntries' => fn($query) => $query
                        ->where('user_id', $userId)
                        ->latest('watched_at'),
                    'reviews' => fn($query) => $query->from('reel_entries')
                        ->whereNotNull('review_content')
                        ->where('reelable_type', Movie::class)
                        ->where('reelable_id', $movie->id)
                        ->with('user')
                        ->latest('watched_at'),
                ])
                ->findOrFail($movie->id);
        });

        // Move these calculations outside the cache block to get live data
        $cachedMovie->likes_count = $movie->userInteractions()
            ->where('is_liked', true)
            ->count();

        $cachedMovie->ratings_count = $movie->userInteractions()
            ->whereNotNull('rating')
            ->count();

        $cachedMovie->avg_rating = $movie->userInteractions()
            ->whereNotNull('rating')
            ->avg('rating');

        // Load reviews separately (not cached)
        $cachedMovie->reviews = $movie->reviews()
            ->whereNotNull('review_content')
            ->where('reelable_type', Movie::class)
            ->where('reelable_id', $movie->id)
            ->with('user')
            ->latest('watched_at')
            ->get();


        // User-specific interactions should also be live
        $cachedMovie->user_interaction = $userId ? $cachedMovie->userInteractions->first() : null;
        $cachedMovie->user_reel = $userId ? $cachedMovie->reelEntries->first() : null;

        return view('movies.show', ['movie' => $cachedMovie]);
    }
}
