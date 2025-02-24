<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\Reel;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

use function Laravel\Prompts\error;

class ReelController extends Controller
{

    public function store(Request $request, Movie $movie): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'rating' => 'nullable|integer|between:1,5',
            'like' => 'nullable|boolean',
            'watched_date' => 'required|date',
            'containsSpoilers' => 'nullable|boolean',
            'is_rewatch' => 'nullable|boolean',
        ]);

        try {
            DB::transaction(function () use ($movie, $validated) {
                // Initialize variables
                $review = null;
                $rating = null;
                $like = null;

                // Create Review if content exists
                if (!empty($validated['content'])) {
                    $review = Review::create([
                        'user_id' => auth()->id(),
                        'content' => $validated['content'],
                        'contains_spoilers' => $validated['containsSpoilers'] ?? false,
                        'reviewable_id' => $movie->id,
                        'reviewable_type' => Movie::class,
                    ]);
                }

                // Create Rating if rating value exists
                if (isset($validated['rating'])) {
                    $rating = Rating::create([
                        'rating' => $validated['rating'],
                        'user_id' => auth()->id(),
                        'rateable_id' => $movie->id,
                        'rateable_type' => Movie::class,
                    ]);
                }

                if (isset($validated['like'])) {
                    $like = Like::create([
                        'user_id' => auth()->id(),
                        'likeable_id' => $movie->id,
                        'likeable_type' => Movie::class,
                        'is_liked' => $validated['like'],
                    ]);
                }

                // Create the Reel with optional relationships
                Reel::create([
                    'user_id' => auth()->id(),
                    'rating_id' => $rating?->id,
                    'review_id' => $review?->id,
                    'like_id' => $like->id,
                    'watched_date' => $validated['watched_date'],
                    'is_rewatch' => $validated['is_rewatch'] ?? false,
                    'reelable_type' => Movie::class,
                    'reelable_id' => $movie->id,
                ]);
            });
        } catch (Throwable $e) {
            error('Failed to create reel: '.$e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to create Reel. Please try again.');
        }

        return redirect()->route('movies.show', $movie)
            ->with('success', 'Movie added to your reels!');
    }

    public function update(Request $request, $id)
    {
        return [
            'reel' => $request,
        ];
    }

}
