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
            'newest' => Movie::select(['id', 'title', 'poster_path']) // Select only needed columns
            ->withStats()
                ->latest()
                ->take(5)
                ->get(),

            'popular' => Movie::select(['id', 'title', 'poster_path']) // Select only needed columns
            ->withStats()
                ->popular()
                ->get(),

            'latestReviews' => Movie::select(['id', 'title', 'poster_path']) // Select only needed columns
            ->withCount('reviews') // Keep withCount
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


        $cachedMovie = Cache::remember($cacheKey, 3600, function () use ($movie) {
            return Movie::with([
                'cast' => function ($query) {
                    $query->orderBy('order', 'asc')
                        ->with(['person:id,name,profile_path'])
                        ->take(10);
                },
                'crew' => function ($query) {
                    $query->whereIn('job', [
                        'Director',
                        'Writer',
                        'Producer',
                        'Executive Producer',
                    ])
                        ->orderBy('job')
                        ->with(['person:id,name,profile_path']);
                },


                'genres',

            ])
                ->findOrFail($movie->id);
        });

        // Retrieve likes, ratings, and watchlists separately
        $movieFresh = Movie::where('id', $movie->id)
            ->with([
                'likes' => fn($query) => $query
                    ->where('user_id', $userId)
                    ->select('id'),
                'ratings' => fn($query) => $query
                    ->where('user_id', $userId)
                    ->select('rateable_id', 'user_id', 'rating'),
                'watchlists' => fn($query) => $query->where('user_id', $userId),
                'reviews',
            ])
            ->withCount([
                'likes' => fn($query) => $query->where('status', true),
                'ratings',
            ])
            ->withAvg('ratings as avg_rating', 'rating')
            ->firstOrFail();

        $cachedMovie->setRelation('likes', $movieFresh->likes);
        $cachedMovie->setRelation('ratings', $movieFresh->ratings);
        $cachedMovie->setRelation('watchlists', $movieFresh->watchlists);
        $cachedMovie->likes_count = $movieFresh->likes_count;
        $cachedMovie->ratings_count = $movieFresh->ratings_count;
        $cachedMovie->avg_rating = $movieFresh->avg_rating;


        // Return the view
        return view('movies.show', ['movie' => $cachedMovie]);
    }
}
