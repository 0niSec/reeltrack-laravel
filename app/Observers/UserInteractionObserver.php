<?php

namespace App\Observers;

use App\Events\RatedEvent;
use App\Models\UserInteraction;

class UserInteractionObserver
{

    public function created(UserInteraction $userInteraction): void
    {
        if ($userInteraction->rating) {
            event(new RatedEvent(
                $userInteraction->user,
                $userInteraction->interactable,
                $userInteraction->rating
            ));
        }
        /* TODO: Watchlist Event */
    }

    public function updated(UserInteraction $userInteraction): void
    {
        $changes = $userInteraction->getDirty();

        // Handle watched status
        if (isset($changes['rating'])) {
            event(new RatedEvent(
                $userInteraction->user,
                $userInteraction->interactable,
                $userInteraction->rating
            ));
        }
    }
}
