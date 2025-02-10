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

        $movie = Movie::with([
            'cast' => fn($query) => $query
                ->orderBy('order', 'asc')
                ->with(['person:id,name,profile_path'])->take(10),
            'crew' => fn($query) => $query
                ->whereIn('department', ['Directing', 'Writing', 'Production'])
                ->orderBy('order', 'asc')
                ->with(['person:id,name,profile_path'])->take(10),
            'genres',
            'reviews',
            'likes' => fn($query) => $query->where('user_id', $userId)->select('id'), // Only get the ID for efficiency
            'ratings' => fn($query) => $query->where('user_id', $userId)->select('rateable_id', 'user_id', 'rating'),
            // Only get necessary columns
            'watchlists' => fn($query) => $query->where('user_id', $userId),
        ])
            ->withCount([
                'likes' => fn($query) => $query->where('status', '=', true), // Total likes (no need for filtering here)
                'ratings', // Total ratings (no need for filtering here)
            ])
            ->withAvg('ratings as avg_rating', 'rating') // Average rating
            ->findOrFail($movie->id);

        // Return the view
        return view('movies.show', compact('movie'));
    }
}
