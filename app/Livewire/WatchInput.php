<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WatchInput extends Component
{

    #[Validate('required|boolean')]
    public bool $isWatched = false;

    public Movie $movie;

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;

        // If there's a watch record for this user, grab its "is_watched" value; otherwise default to false.
        $this->isWatched = (bool) ($movie->watches()
            ->where('user_id', auth()->id())
            ->value('is_watched') ?? false
        );
    }

    public function toggleWatch(): void
    {
        $this->validate();

        // Toggle the state
        $this->isWatched = !$this->isWatched;

        // Do a minimal update on the watchlist relationship
        $this->movie->watches()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_watched' => $this->isWatched]
        );
    }


    public function render(): View
    {
        return view('livewire.watch-input');
    }
}
