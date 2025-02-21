<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
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
        // If there's a watch record for this user, grab its "is_watched" value; otherwise default to false.
        $this->isWatched = (bool) ($this->movie()->watches()
            ->where('user_id', auth()->id())
            ->value('is_watched') ?? false
        );
    }

    #[Computed]
    public function movie(): Movie
    {
        return Movie::findOrFail($this->movieId);
    }

    public function toggleWatch(): void
    {
        $this->validate();

        // Toggle the state
        $this->isWatched = !$this->isWatched;

        $this->movie()->watches()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['is_watched' => $this->isWatched]
        );
    }


    public function render(): View
    {
        return view('livewire.watch-input');
    }
}
