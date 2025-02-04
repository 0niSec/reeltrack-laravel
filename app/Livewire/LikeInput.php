<?php

namespace App\Livewire;

use App\Models\Like;
use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

// FIXME: On fresh account - checking this doesn't update the Component, but adds it to the db still

class LikeInput extends Component
{
    #[Validate('required|boolean')]
    public bool $liked = false;

    public Movie $movie;

    public function mount(Movie $movie)
    {
        $record = $movie->likes()->where('user_id', auth()->user()->id)->first();

        $this->liked = $record ? $record->status : false;
    }

    public function toggleLike(): void
    {
        $this->validate();

        // Check if a record for the user exists
        $existingLike = $this->movie
            ->likes()
            ->where('user_id', auth()->user()->id)
            ->first();


        // If it exists, toggle the status
        // Else, create it
        if ($existingLike) {
            // Authorize the action before continuing
            $this->authorize('update', $existingLike);

            $existingLike->update(['status' => !$existingLike->status]);

            // Set the property so we can affect the DOM
            $this->liked = !$this->liked;
        } else {
            $this->authorize('create', Like::class);

            // Create a new record
            $this->movie->likes()->create([
                'user_id' => auth()->user()->id,
                'status' => true,
            ]);

            $this->liked = true;
        }
    }

    public function render(): View
    {
        return view('livewire.like-input');
    }
}
