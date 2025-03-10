<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\View\View;

class UserReviewsController extends Controller
{
    public function index(User $user, Movie $movie): View
    {
        $reviews = $user->getReviewsFor($movie);

        return view('users.reviews', compact('user', 'movie', 'reviews'));
    }


    public function show(User $user, Movie $movie, Review $review): View
    {
        return view('users.review', compact('user', $movie, 'review'));
    }
}
