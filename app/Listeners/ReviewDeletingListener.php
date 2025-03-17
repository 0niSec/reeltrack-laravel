<?php

namespace App\Listeners;

use App\Events\ReviewDeletingEvent;

class ReviewDeletingListener
{
    public function __construct()
    {
    }

    public function handle(ReviewDeletingEvent $event): void
    {
        $reelEntry = $event->review->reelEntry;

        // If there is an associated Reel Entry for the Review, delete it
        if ($reelEntry) {
            $reelEntry->delete();
        }
    }
}
