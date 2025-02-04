<?php

namespace App\Livewire;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class WatchInput extends Component
{

    #[Validate('required|boolean')]
    public bool $is_watched = false;

    public function mount(Movie $movie): void
    {
        $this->is_watched = $movie->watches()->where('user_id', auth()->id())->exists();
    }

    public function render(): View
    {
        return view('livewire.watch-input');
    }
}
