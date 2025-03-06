<?php

namespace App\Listeners;

use App\Events\LikedEvent;
use App\Models\Activity;

class LikedListener
{
    public function __construct()
    {
    }

    public function handle(LikedEvent $event): void
    {
        Activity::create([
            'user_id' => $event->user->id,
            'subjectable_type' => get_class($event->content),
            'subjectable_id' => $event->content->id,
            'action' => $event->isLiked ? 'liked' : 'unliked',
            'properties' => [
                'is_liked' => $event->isLiked,
            ],
        ]);
    }
}
