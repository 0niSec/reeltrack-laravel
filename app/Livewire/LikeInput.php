<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LikeInput extends Component
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
        $this->isLiked = !$this->isLiked;

        $this->movie()->reels()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_liked' => $this->isLiked]
        );

        $this->dispatch('movie-liked', $this->isLiked);
    }


    public function render(): View
    {
        return view('livewire.like-input');
    }
}
