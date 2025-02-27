<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WatchlistInput extends Component
{
    public Movie $movie;

    #[Validate('boolean')]
    public bool $isWatchlisted = false;

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;
        $this->isWatchlisted = $this->movie
            ->userInteractions()
            ->where('user_id', auth()->id())
            ->where('is_in_watchlist', true)
            ->exists();
    }

    public function toggleWatchlist(): void
    {
        $this->validate();

        $this->isWatchlisted = !$this->isWatchlisted;

        $this->movie->userInteractions()->updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            ['is_in_watchlist' => $this->isWatchlisted]
        );
    }

    public function render()
    {
        return view('livewire.watchlist-input');
    }
}
