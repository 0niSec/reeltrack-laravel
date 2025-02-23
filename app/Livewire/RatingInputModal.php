<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RatingInputModal extends Component
{
    #[Validate('required|numeric|min:0|max:5')]
    public float $rating = 0.0;
    public float $hoverRating = 0.0;

    #[Validate('required|integer|min:1')]
    public int $movieId;

    public function mount(): void
    {
        $this->rating = $this->movie()
            ->ratings()
            ->where('user_id', auth()->id())
            ->value('rating') ?? 0.0;
    }

    #[Computed]
    public function movie(): Movie
    {
        return Movie::findOrFail($this->movieId);
    }

    #[On('movie-rated')]
    public function setRating(float $value): void
    {
        $this->validate();

        $this->rating = $value;
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
