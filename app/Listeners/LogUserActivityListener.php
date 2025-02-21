<?php

namespace App\Listeners;

use App\Events\ActivityEvent;
use App\Models\Activity;

class LogUserActivityListener
{
    public function __construct()
    {
    }

    public function handle(ActivityEvent $event): void
    {
        Activity::create([
            'user_id' => $event->user->id,
            'subject_id' => $event->subject->id,
            'subject_type' => get_class($event->subject),
            'event_type' => $event->getEventType(),
            'action' => $event->action,
            'metadata' => $event->metadata,
        ]);
    }
}
