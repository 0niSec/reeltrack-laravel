<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WatchInput extends Component
{

    #[Validate('required|boolean')]
    public bool $isWatched = false;

    #[Validate('required|integer|min:1')]
    public int $movieId;

    public function mount(): void
    {
        $this->isWatched = $this->movie()->isWatched();
    }


    #[Computed]
    public function movie(): Movie
    {
        return Movie::findOrFail($this->movieId);
    }

    public function toggleWatch(): void
    {
        $this->validate();
        $this->isWatched = !$this->isWatched;

        $this->movie()->reels()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['watch_date' => $this->isWatched ? now() : null]
        );
    }


    #[On('movie-rated')]
    public function setWatched(): void
    {
        if (!$this->isWatched) {
            $this->isWatched = true;

            $this->movie()->reels()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['watch_date' => now()]
            );
        }
    }


    public function render(): View
    {
        return view('livewire.watch-input');
    }
}
