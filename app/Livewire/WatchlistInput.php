<?php

namespace App\Livewire;

use App\Models\Activity;
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
        $this->isWatchlisted = $this->movie()
            ->watchlists()
            ->where('user_id', auth()->id())
            ->exists();
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

        if ($this->isWatchlisted) {
            $this->movie()->watchlists()->create(['user_id' => auth()->id(), 'is_watchlisted' => true]);
        } else {
            $this->movie()->watchlists()->where('user_id', auth()->id())->delete();

            // Delete the activity log
            Activity::query()
                ->where('user_id', auth()->id())
                ->where('subject_type', Movie::class)
                ->where('subject_id', $this->movieId)
                ->where('event_type', 'watchlist')
                ->delete();
        }
    }

    public function render()
    {
        return view('livewire.watchlist-input');
    }
}
