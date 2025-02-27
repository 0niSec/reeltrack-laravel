<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\ReelEntry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'estimated_year' => $validated['estimated_year'].'-01-01',
            default => null
        };

        // Create or update the reel entry
        try {
            $reelEntry = ReelEntry::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'reelable_type' => Movie::class,
                    'reelable_id' => $movie->id,
                ],
                [
                    'watched_at' => $watchedAt,
                    'is_rewatch' => $validated['is_rewatch'] ?? false,
                    'rating' => $validated['rating'] ?? null,
                    'is_liked' => $validated['is_liked'],
                    'review_content' => $validated['review_content'] ?? null,
                    'contains_spoilers' => $validated['contains_spoilers'] ?? false,
                ]
            );
        } catch (Exception $e) {
            Log::error('Error creating reel entry: '.$e);

            return redirect()->back()->with('error', 'Error creating reel entry');
        }

        return redirect()
            ->route('movies.show', $movie)
            ->with('success', 'Movie added to your reel successfully');
    }
}
