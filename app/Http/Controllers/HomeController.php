<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use App\Models\UserInteraction;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(User $user)
    {
        $siteStats = [
            'total_movies' => Movie::count(),
            'total_users' => User::count(),
            'total_reviews' => Review::count(),
            'total_ratings' => UserInteraction::where('rating', '>', 0)->count(),
        ];

        // TODO: We can make this more complex as time goes on
        $trending = Movie::query()
            ->leftJoin('user_interactions', 'movies.id', '=', 'user_interactions.interactable_id')
            ->leftJoin('reviews', 'reviewable_id', '=', 'reviews.reviewable_id')
            ->select('movies.*',
                DB::raw('COUNT(CASE WHEN user_interactions.is_liked = true AND user_interactions.created_at >= NOW() - INTERVAL \'1 week\' THEN user_interactions.id END) as recent_likes'),
                DB::raw('AVG(CASE WHEN user_interactions.rating IS NOT NULL AND user_interactions.created_at >= NOW() - INTERVAL \'1 week\' THEN user_interactions.rating END) as recent_avg_rating'),
                DB::raw('COUNT(CASE WHEN reviews.created_at >= NOW() - INTERVAL \'1 week\' THEN reviews.id END) as recent_reviews'),
                DB::raw('movies.total_likes as total_likes')
            )
            ->groupBy('movies.id', 'movies.total_likes') // Include total_likes in groupBy
            ->orderByRaw('(COUNT(CASE WHEN user_interactions.is_liked = true AND user_interactions.created_at >= NOW() - INTERVAL \'1 week\' THEN user_interactions.id END) * 0.4) + (AVG(CASE WHEN user_interactions.rating IS NOT NULL AND user_interactions.created_at >= NOW() - INTERVAL \'1 week\' THEN user_interactions.rating END) * 0.3) + (COUNT(CASE WHEN reviews.created_at >= NOW() - INTERVAL \'1 week\' THEN reviews.id END) * 0.2) + (movies.total_likes * 0.1) DESC')
            ->take(5)
            ->get();


        return view('index', compact('user', 'siteStats', 'trending'));
    }
}
