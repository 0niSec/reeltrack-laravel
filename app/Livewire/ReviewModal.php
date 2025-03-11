<?php

namespace App\Livewire;

use App\Models\Movie;
use App\Models\ReelEntry;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class ReviewModal extends Component
{

    public $showModal = false;
    public string $type = 'create';
    public string $dateType = 'specific_date';
    public string $watchDate;
    public string $estimatedYear;
    public bool $isRewatch = false;
    public float $rating = 0.0;
    public bool $isLiked = false;
    public string $reviewContent = '';
    public bool $containsSpoilers = false;

    public Movie $movie;

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;
        $this->watchDate = Carbon::today()->format('Y-m-d');
        $this->isLiked = $this->movie->isLiked();
    }

    #[On('liked-in-modal')]
    public function handleLikeUpdate(bool $value): void
    {
        $this->isLiked = $value;
    }

    #[On('rated-in-modal')]
    public function handleRatingUpdate(float $value): void
    {
        $this->rating = $value;
    }

    public function save()
    {
        $validated = $this->validate([
            'dateType' => 'required|in:specific_date,estimated_year,unknown',
            'watchDate' => 'required_if:date_type,specific_date|date|nullable',
            'estimatedYear' => 'required_if:date_type,estimated_year|integer|nullable',
            'isRewatch' => 'nullable|boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'isLiked' => 'nullable|boolean',
            'reviewContent' => 'nullable|string',
            'containsSpoilers' => 'nullable|boolean',
        ]);

        // Determine watch date based on date type
        $watchedAt = match ($validated['dateType']) {
            'specific_date' => $validated['watchDate'],
            'estimated_year' => $validated['estimatedYear'].'-01-01', // TODO: 1/1 cant be the date
            default => null
        };

        // Add the items to the database
        $reelEntry = ReelEntry::create([
            'user_id' => auth()->id(),
            'reelable_id' => $this->movie->id,
            'reelable_type' => Movie::class,
            'watched_at' => $watchedAt,
            'rating' => $validated['rating'],
            'is_liked' => $validated['isLiked'],
            'is_rewatch' => $validated['isRewatch'],
        ]);

        Log::debug('Reel Entry created:', [$reelEntry]);

        if (!empty($validated['reviewContent'])) {
            Review::create([
                'user_id' => auth()->id(),
                'reel_entry_id' => $reelEntry->id,
                'reviewable_id' => $this->movie->getKey(),
                'reviewable_type' => $this->movie->getMorphClass(),
                'content' => $validated['reviewContent'],
                'contains_spoilers' => $validated['containsSpoilers'],
            ]);
        }

        $this->showModal = false; // Close the modal after saving

        return redirect()
            ->route('movies.show', $this->movie)
            ->with('success', 'Movie added to your reel successfully');
    }

    public function render()
    {
        return view('livewire.review-modal');
    }
}
