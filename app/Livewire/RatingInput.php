<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class RatingInput extends Component
{
    #[Validate('required|numeric|min:0|max:5')]
    public float $rating = 0.0;
    public float $hoverRating = 0.0;

    #[Validate('required|integer|min:1')]
    public int $movieId;

    public function mount(): void
    {
        $this->rating = $this->movie()->getRating() ?? 0.0;
    }


    #[Computed]
    public function movie(): Movie
    {
        return Movie::findOrFail($this->movieId);
    }

    public function setRating(float $value): void
    {
        $this->validate();

        $this->movie()->reels()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['rating' => $value]
        );

        $this->rating = $value;
        $this->dispatch('movie-rated', $value);
    }


    /**
     * @throws Throwable
     */
    public function clearRating(): void
    {
        $this->movie()->reels()->updateOrCreate(
            ['user_id' => auth()->id()],
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
