<?php

namespace App\Http\Controllers;

use App\Events\ReviewEvent;
use App\Models\Movie;
use App\Models\ReelEntry;
use App\Models\Review;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    public function store(Request $request, Movie $movie)
    {
        $request->merge([
            'is_liked' => $request->boolean('is_liked'),
            'is_rewatch' => $request->boolean('is_rewatch'),
            'contains_spoilers' => $request->boolean('contains_spoilers'),
        ]);

        $validated = $request->validate([
            'date_type' => 'required|in:specific_date,estimated_year,unknown',
            'watch_date' => 'required_if:date_type,specific_date|date|nullable',
            'estimated_year' => 'required_if:date_type,estimated_year|integer|nullable',
            'is_rewatch' => 'nullable|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_liked' => 'boolean',
            'review_content' => 'nullable|string',
            'contains_spoilers' => 'nullable|boolean',
        ]);

        // Determine watch date based on date type
        $watchedAt = match ($validated['date_type']) {
            'specific_date' => $validated['watch_date'],
            'estimated_year' => $validated['estimated_year'].'-01-01', // TODO: 1/1 cant be the date
            default => null
        };

        $reelEntry = ReelEntry::create([
            'user_id' => auth()->id(),
            'reelable_id' => $movie->id,
            'reelable_type' => Movie::class,
            'watched_at' => $watchedAt,
            'rating' => $validated['rating'],
            'is_liked' => $validated['is_liked'],
            'is_rewatch' => $validated['is_rewatch'],
        ]);


        if (isset($validated['review_content'])) {
            Review::create([
                'user_id' => auth()->id(),
                'reel_entry_id' => $reelEntry->id,
                'reviewable_id' => $movie->id,
                'reviewable_type' => $movie->getMorphClass(),
                'content' => $validated['review_content'],
                'contains_spoilers' => $validated['contains_spoilers'],
            ]);
        }

        return redirect()
            ->route('movies.show', $movie)
            ->with('success', 'Movie added to your reel successfully');
    }
}
