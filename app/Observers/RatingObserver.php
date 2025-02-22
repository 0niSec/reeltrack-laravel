<?php

namespace App\Observers;

use App\Events\RatingEvent;
use App\Models\Activity;
use App\Models\Rating;

class RatingObserver
{
    public function created(Rating $rating): void
    {
        RatingEvent::dispatch($rating->user, $rating->rateable, $rating->rating);
    }

    public function updated(Rating $rating): void
    {
        // Delete the old activity
        Activity::query()
            ->where('user_id', $rating->user_id)
            ->where('subject_type', get_class($rating->rateable))
            ->where('subject_id', $rating->rateable_id)
            ->where('event_type', 'rating')
            ->delete();

        // Create a new activity through the event
        RatingEvent::dispatch($rating->user, $rating->rateable, $rating->rating);
    }

    public function deleted(Rating $rating): void
    {
        Activity::query()
            ->where('user_id', $rating->user_id)
            ->where('subject_type', get_class($rating->rateable))
            ->where('subject_id', $rating->rateable_id)
            ->where('event_type', 'rating')
            ->delete();
    }
}
