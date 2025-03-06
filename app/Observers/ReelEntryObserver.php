<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\ReelEntry;

class ReelEntryObserver
{
    public function created(ReelEntry $entry): void
    {
        // Create a comprehensive activity when a full reel entry is made
        $properties = array_filter([
            'watched_at' => $entry->watched_at,
            'rating' => $entry->rating,
            'is_liked' => $entry->is_liked,
            'review_content' => $entry->review_content,
        ]);

        if (!empty($properties)) {
            Activity::create([
                'user_id' => $entry->user_id,
                'subjectable_type' => $entry->reelable_type,
                'subjectable_id' => $entry->reelable_id,
                'action' => 'reeled',
                'properties' => $properties,
            ]);
        }
    }

    public function updated(ReelEntry $reelEntry): void
    {
    }

    public function deleted(ReelEntry $reelEntry): void
    {
    }
}
