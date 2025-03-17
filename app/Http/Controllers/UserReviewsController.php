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
        $reviews = $user->getReviewsFor($movie); // Loads the likes and comments too

        return view('users.reviews.index', compact('user', 'movie', 'reviews'));
    }


    public function show(User $user, Movie $movie, Review $review): View
    {
        $review->load('likes', 'comments', 'reelEntry');
        return view('users.reviews.show', compact('user', 'movie', 'review'));
    }

    public function destroy(User $user, Movie $movie, Review $review)
    {
        $review->delete();

        return redirect()->route('user.reviews', [$user, $movie])->with('success', 'Review deleted');
    }
}
