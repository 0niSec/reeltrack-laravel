<?php

namespace App\Livewire;

use App\Models\Movie;
use Carbon\Carbon;
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
        dd($validated);

        $this->showModal = false; // Close the modal after saving

        return redirect()
            ->route('movies.show', $movie)
            ->with('success', 'Movie added to your reel successfully');
    }

    public function render()
    {
        return view('livewire.review-modal');
    }
}
