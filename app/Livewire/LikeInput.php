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
        // If there's a like record for this user, grab its "status" value; otherwise default to false.
        $like = $this->movie()->likes()
            ->where('user_id', auth()->id())
            ->first();

        $this->isLiked = $like ? $like->status : false;
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

        $this->movie()->likes()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['status' => $this->isLiked]
        );
    }


    public function render(): View
    {
        return view('livewire.like-input');
    }
}
