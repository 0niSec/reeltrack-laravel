<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;

class UserReviewController extends Controller
{
    public function show(User $user, Movie $movie)
    {
        return [
            'user' => $user,
            'movie' => $movie,
            'reviews' => $user->getReviewsFor($movie),
        ];
    }
}
