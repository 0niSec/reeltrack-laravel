<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RatingInputModal extends Component
{
    public Movie $movie;

    #[Validate('required|numeric|min:0|max:5')]
    public float $rating = 0.0;
    public float $hoverRating = 0.0;

    #[Validate('required|integer|min:1')]
    public int $movieId;

// Helpers
    #[On('movie-rated')]
    public function setRating(float $value): void
    {
        $this->validate();
        $this->rating = $value;
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

    public function hoverRating(float $value = 0.0): void
    {
        $this->hoverRating = $value;
    }

    public function clearRating(): void
    {
        $this->rating = 0.0;
    }

    public function render()
    {
        return view('livewire.rating-input-modal');
    }
}
