<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LikeInputModal extends Component
{

    public Movie $movie;

    #[Validate('boolean')]
    public bool $isLiked = false;

    #[Validate('required|integer|min:1')]
    public int $movieId;

// Helpers
    #[On('movie-liked')]
    public function setLikeStatus(bool $isLiked): void
    {
        $this->isLiked = $isLiked;
    }
// End Helpers

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;
        $this->isLiked = $this->movie->isLiked();
    }

    public function toggleLike(): void
    {
        $this->validate();

        // Toggle the state
        $this->isLiked = !$this->isLiked;
    }

    public function render()
    {
        return view('livewire.like-input-modal');
    }
}
