<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RatingInput extends Component
{

    #[Validate('required|numeric|min:0|max:5')]
    public float $rating = 0.0;
    public float $hoverRating = 0.0;

    public Movie $movie;

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;
        $this->rating = $movie->ratings()->where('user_id', auth()->id())->first()->rating ?? 0.0;
    }

    public function setRating(float $value): void
    {
        $this->validate();

        $this->rating = $value;

        // Update or create the rating record for the authenticated user
        $this->movie->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['rating' => $value]
        );
    }

    /**
     * Set or clear the "hover rating" from mouse events.
     */
    public function hoverRating(float $value = 0.0): void
    {
        $this->hoverRating = $value;
    }


    public function render(): View
    {
        return view('livewire.rating-input');
    }
}
