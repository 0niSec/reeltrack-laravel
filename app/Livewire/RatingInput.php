<?php

namespace App\Livewire;

use App\Models\Activity;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Throwable;

class RatingInput extends Component
{
    #[Validate('required|numeric|min:0|max:5')]
    public float $rating = 0.0;
    public float $hoverRating = 0.0;

    #[Validate('required|integer|min:1')]
    public int $movieId;

    public function mount(): void
    {
        $this->rating = $this->movie()
            ->ratings()
            ->where('user_id', auth()->id())
            ->value('rating') ?? 0.0;
    }

    #[Computed]
    public function movie(): Movie
    {
        return Movie::findOrFail($this->movieId);
    }

    public function setRating(float $value): void
    {
        $this->validate();

        $this->movie()->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['rating' => $value]
        );

        $this->rating = $value;
    }

    /**
     * @throws Throwable
     */
    public function clearRating(): void
    {
        DB::transaction(function () {
            // Delete the rating from the database
            Rating::where('user_id', auth()->id())
                ->where('rateable_id', $this->movieId)
                ->where('rateable_type', Movie::class)
                ->delete();


            // Delete the activity log
            Activity::query()
                ->where('user_id', auth()->id())
                ->where('subject_type', Movie::class)
                ->where('subject_id', $this->movieId)
                ->where('event_type', 'rating')
                ->delete();

            $this->rating = 0.0;
        });
    }

    public function hoverRating(float $value = 0.0): void
    {
        $this->hoverRating = $value;
    }

    public function render(): View
    {
        return view('livewire.rating-input');
    }
}
