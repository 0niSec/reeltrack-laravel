<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\View\View;

class UserReviewController extends Controller
{
    public function index(User $user, Movie $movie): View
    {
        $reviews = $user->getReviewsFor($movie); // Loads the likes and comments too

        return view('users.reviews.index', compact('user', 'movie', 'reviews'));
    }


    public function show(User $user, Movie $movie, Review $review): View
    {
        // Custom scoping for show route
        abort_if($review->user_id !== $user->id, 404);

        $review->load('likes', 'reelEntry');
        $review->load([
            'comments' => function ($query) {
                $query->whereNull('parent_id')
                    ->orderBy('created_at', 'asc')
                    ->with([
                        'likes', 'replies' => function ($query) {
                            $query->orderBy('created_at', 'asc');
                        }
                    ]);
            }
        ]);

        return view('users.reviews.show', compact('user', 'movie', 'review'));
    }

    public function destroy(User $user, Movie $movie, Review $review)
    {
        abort_if($review->user_id !== $user->id, 404);

        $review->delete();

        return redirect()->route('reviews.index', [$user, $movie])->with('success', 'Review deleted');
    }
}
