<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RatingInput extends Component
{
    public Movie $movie;

    #[Validate('required|numeric|min:0|max:5')]
    public float $rating = 0.0;
    public float $hoverRating = 0.0;

// Helpers
    public function setRating(float $value): void
    {
        $this->validate();

        $this->movie->userInteractions()->updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            ['rating' => $value]
        );

        $this->rating = $value;
        $this->dispatch('movie-rated', $value);
    }

// End Helpers

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;

        $interaction = $this->movie
            ->userInteractions()
            ->where('user_id', auth()->id())
            ->first();

        $this->rating = $interaction?->rating ?? 0.0;
    }

    public function clearRating(): void
    {
        $this->movie->userInteractions()->updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            ['rating' => null]
        );

        $this->rating = 0.0;
    }

    public function hoverRating(float $value = 0.0): void
    {
        $this->hoverRating = $value;
    }

    public function render(): View
    {
        return view('livewire.rating-input');
    }
}
