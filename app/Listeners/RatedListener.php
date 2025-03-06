<?php

namespace App\Listeners;

use App\Events\RatedEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Log;

class RatedListener
{
    public function __construct()
    {
    }

    public function handle(RatedEvent $event): void
    {
        Log::info('Rated event', [
            'user_id' => $event->user->id,
            'subjectable_type' => get_class($event->content),
            'subjectable_id' => $event->content->id,
            'action' => 'rated',
            'rating' => $event->rating,
        ]);

        // Create an Activity (assuming there is an Activity model configured)
        Activity::create([
            'user_id' => $event->user->id,
            'subjectable_type' => get_class($event->content),
            'subjectable_id' => $event->content->id,
            'action' => 'rated',
            'properties' => [
                'rating' => $event->rating,
            ],
        ]);
    }
}
