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
        ]);

        // Get liked movies with eager loading
        $likedMovies = $user->userInteractions()
            ->with('interactable')
            ->where('is_liked', true)
            ->where('interactable_type', Movie::class)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->pluck('interactable');

        // Get recently watched content
        $recentlyWatched = $user->reelEntries()
            ->whereNotNull('watch_date')
            ->orderBy('watch_date', 'desc')
            ->with('reelable')
            ->take(5)
            ->get()
            ->pluck('reelable');

        // Get highly rated content
        $highlyRated = $user->reelEntries()
            ->whereNotNull('rating')
            ->where('rating', '>=', 4)
            ->with('reelable')
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get()
            ->pluck('reelable');

        $stats = [
            'films_count' => $user->reelEntries()
                ->where('reelable_type', Movie::class)
                ->whereNotNull('watch_date')
                ->count(),
            'tv_count' => $user->reelEntries()
                ->where('reelable_type', TvSeries::class)
                ->whereNotNull('watch_date')
                ->count(),
            'this_year_count' => $user->reelEntries()
                ->whereYear('watched_at', Carbon::now()->year)
                ->count(),
            'rated_count' => $user->reelEntries()
                ->whereNotNull('rating')
                ->count(),
            'liked_count' => $user->reelEntries()
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
