<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class WatchedDate extends Component
{

    public Movie $movie;
    public bool $isRewatch = false;
    public bool $hasWatchedDate;
    public ?string $dateType = null;
    public ?string $watchedDate = null;
    public ?string $beforeYear = null;
    public ?string $specificYear = null;


    public function mount(Movie $movie): void
    {
        $this->movie = $movie;
        $this->watchedDate = now()->format('Y-m-d');
        $this->hasWatchedDate = true;

        // Check if user has already watched this movie
        if (auth()->check()) {
            $hasWatched = $this->movie->reviews()
                ->where('user_id', auth()->id())
                ->exists();

            $this->isRewatch = $hasWatched;
        }
    }

    public function render(): View
    {
        return view('livewire.watched-date');
    }
}
