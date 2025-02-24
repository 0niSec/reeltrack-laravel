<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\TvSeries;
use App\Models\User;
use Illuminate\Support\Carbon;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        // Eager load relationships
        $user->load([
            'profile',
            'activities.subject',
        ]);

        // Get liked movies with eager loading
        $likedMovies = $user->reels()
            ->where('reelable_type', Movie::class)
            ->where('is_liked', true)
            ->with('reelable')
            ->get()
            ->pluck('reelable');

        // Get recently watched content
        $recentlyWatched = $user->reels()
            ->whereNotNull('watch_date')
            ->orderBy('watch_date', 'desc')
            ->with('reelable')
            ->take(5)
            ->get()
            ->pluck('reelable');

        // Get highly rated content
        $highlyRated = $user->reels()
            ->whereNotNull('rating')
            ->where('rating', '>=', 4)
            ->with('reelable')
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get()
            ->pluck('reelable');

        $stats = [
            'films_count' => $user->reels()
                ->where('reelable_type', Movie::class)
                ->whereNotNull('watch_date')
                ->count(),
            'tv_count' => $user->reels()
                ->where('reelable_type', TvSeries::class)
                ->whereNotNull('watch_date')
                ->count(),
            'this_year_count' => $user->reels()
                ->whereYear('watch_date', Carbon::now()->year)
                ->count(),
            'rated_count' => $user->reels()
                ->whereNotNull('rating')
                ->count(),
            'liked_count' => $user->reels()
                ->where('is_liked', true)
                ->count(),
        ];

        return view('users.profile.show', compact(
            'user',
            'stats',
            'likedMovies',
            'recentlyWatched',
            'highlyRated',
        ));
    }
}
