<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LikeInputModal extends Component
{

    public Movie $movie;

    #[Validate('required|boolean')]
    public bool $isLiked;

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

        // Dispatch to the Review Modal for child -> parent communication
        $this->dispatch('liked-in-modal', $this->isLiked)->to(ReviewModal::class);
    }

    public function render()
    {
        return view('livewire.like-input-modal');
    }
}
