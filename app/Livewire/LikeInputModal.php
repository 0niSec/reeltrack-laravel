<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LikeInputModal extends Component
{

    #[Validate('required|boolean')]
    public bool $isLiked = false;

    #[Validate('required|integer|min:1')]
    public int $movieId;

    public function mount(): void
    {
        $this->isLiked = $this->movie()->isLiked();
    }

    #[Computed]
    public function movie(): Movie
    {
        return Movie::findOrFail($this->movieId);
    }

    public function toggleLike(): void
    {
        $this->validate();

        // Toggle the state
        $this->isLiked = !$this->isLiked;
    }

    #[On('movie-liked')]
    public function setLikeStatus(bool $isLiked): void
    {
        $this->isLiked = $isLiked;
    }

    public function render()
    {
        return view('livewire.like-input-modal');
    }
}
