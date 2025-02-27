<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WatchInput extends Component
{
    public Movie $movie;

    #[Validate('required|boolean')]
    public bool $isWatched = false;

    public bool $hasUserReviews = false;
    public int $totalReviews = 0;

// Helpers
    #[On('movie-rated')]
    public function setWatched(): void
    {
        if (!$this->isWatched) {
            $this->isWatched = true;
            $this->movie->userInteractions()->updateOrCreate(
                [
                    'user_id' => auth()->id(),
                ],
                ['is_watched' => true]
            );
        }
    }

// End Helpers

    public function mount(Movie $movie): void
    {
        $this->movie = $movie;

        $this->isWatched = $this->movie
            ->userInteractions()
            ->where('user_id', auth()->id())
            ->where('is_watched', true)
            ->exists();

        $this->checkUserReviews();
        $this->totalReviews = $this->getTotalReviews();
    }

    private function checkUserReviews(): void
    {
        $this->hasUserReviews = $this->movie
            ->reelEntries()
            ->where('user_id', auth()->id())
            ->whereNotNull('review_content')
            ->exists();
    }

    private function getTotalReviews(): int
    {
        return $this->movie
            ->reelEntries()
            ->whereNotNull('review_content')
            ->count();
    }

    public function toggleWatch(): void
    {
        $this->validate();
        $this->isWatched = !$this->isWatched;

        // Only update user_interactions - this is a quick action
        $this->movie->userInteractions()->updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            ['is_watched' => $this->isWatched]
        );
    }

    public function render(): View
    {
        return view('livewire.watch-input');
    }
}
