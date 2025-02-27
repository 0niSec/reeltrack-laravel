<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LikeInput extends Component
{
    public Movie $movie;

    #[Validate('required|boolean')]
    public bool $isLiked = false;

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;
        $this->isLiked = $this->movie
            ->userInteractions()
            ->where('user_id', auth()->id())
            ->where('is_liked', true)
            ->exists();
    }

    public function toggleLike(): void
    {
        $this->validate();
        $this->isLiked = !$this->isLiked;

        $this->movie->userInteractions()->updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            ['is_liked' => $this->isLiked]
        );

        $this->dispatch('movie-liked', isLiked: $this->isLiked);
    }

    public function render(): View
    {
        return view('livewire.like-input');
    }
}
