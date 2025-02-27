<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;

class ReviewController extends Controller
{
    public function show(User $user, Movie $movie)
    {
        return [
            'user' => $user,
            'movie' => $movie,
            'reviews' => $user->reelEntries()
                ->where('reelable_type', Movie::class)
                ->where('reelable_id', $movie->id)
                ->whereNotNull('review_content')
                ->get(),
        ];
    }
}
