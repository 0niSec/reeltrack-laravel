<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LikeInput extends Component
{
    #[Validate('required|boolean')]
    public bool $liked = false;

    public Movie $movie;

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;
        $this->liked = $movie->likes()->where('user_id', auth()->id())->first()->status ?? false;
    }

    public function toggleLike(): void
    {
        $this->validate();

        $this->liked = !$this->liked;

        $like = $this->movie->likes()->firstOrNew([
            'user_id' => auth()->id(),
        ]);

        $like->status = $this->liked;
        $like->save();
    }

    public function updatedLiked()
    {
        $this->liked = !$this->liked;
        $this->dispatch('like-updated')->self();
    }

    public function render(): View
    {
        return view('livewire.like-input');
    }
}
