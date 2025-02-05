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
        $this->isWatched = $movie->watches()
            ->where('user_id', auth()->id())
            ->first()
            ?->is_watched ?? false;
    }

    public function toggleWatch(): void
    {
        $this->validate();

        // Toggle the state
        $this->isWatched = !$this->isWatched;

        // Update or create the watch record for the authenticated user
        $watch = $this->movie->watches()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_watched' => $this->isWatched]
        );

        $this->authorize('update', $watch);
    }

    public function render(): View
    {
        return view('livewire.watch-input');
    }
}
