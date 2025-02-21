<?php

namespace App\Livewire;

use App\Models\Movie;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WatchlistInput extends Component
{
    #[Validate('required|boolean')]
    public bool $isWatchlisted = false;

    #[Validate('required|integer|min:1')]
    public int $movieId;

    public function mount(): void
    {
        // If there's a watchlist record for this user, grab its "is_watchlisted" value; otherwise default to false.
        $this->isWatchlisted = (bool) ($this->movie()->watchlists()
            ->where('user_id', auth()->id())
            ->value('is_watchlisted') ?? false
        );
    }

    #[Computed]
    public function movie(): Movie
    {
        return Movie::findOrFail($this->movieId);
    }

    public function toggleWatchlist(): void
    {
        $this->validate();

        // Toggle the state
        $this->isWatchlisted = !$this->isWatchlisted;

        $this->movie()->watchlists()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_watchlisted' => $this->isWatchlisted]
        );
    }

    public function render()
    {
        return view('livewire.watchlist-input');
    }
}
