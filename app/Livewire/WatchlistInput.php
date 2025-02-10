<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WatchlistInput extends Component
{
    #[Validate('required|boolean')]
    public bool $isWatchlisted = false;
    public int $movieId;

    public function mount(int $movieId): void
    {
        $this->movieId = $movieId;
        $movie = Movie::findOrFail($movieId);

        // If there's a watchlist record for this user, grab its "is_watchlisted" value; otherwise default to false.
        $this->isWatchlisted = (bool) ($movie->watchlists()
            ->where('user_id', auth()->id())
            ->value('is_watchlisted') ?? false
        );
    }

    public function toggleWatchlist(): void
    {
        $this->validate();

        // Toggle the state
        $this->isWatchlisted = !$this->isWatchlisted;

        // Do a minimal update on the watchlist relationship
        $movie = Movie::findOrFail($this->movieId);
        $movie->watchlists()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_watchlisted' => $this->isWatchlisted]
        );
    }

    public function updatedIsWatchlisted(): void
    {
        $this->isWatchlisted = !$this->isWatchlisted;
    }

    public function render()
    {
        return view('livewire.watchlist-input');
    }
}
