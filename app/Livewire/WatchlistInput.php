<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WatchlistInput extends Component
{
    #[Validate('required|boolean')]
    public bool $isWatchlisted = false;
    public Movie $movie;

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;

        $this->isWatchlisted = $movie->watchlists()->where('user_id', auth()->id())->first()->is_watchlisted ?? false;
    }

    public function toggleWatchlist(): void
    {
        $this->validate();

        // Toggle the state
        $this->isWatchlisted = !$this->isWatchlisted;

        // Update or create the watch record for the authenticated user
        $this->movie->watchlists()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_watchlisted' => $this->isWatchlisted]
        );
    }

    public function render()
    {
        return view('livewire.watchlist-input');
    }
}
