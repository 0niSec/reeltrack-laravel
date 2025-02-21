<?php

namespace App\Events;

use App\Contracts\Watchable;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class WatchlistEvent extends ActivityEvent
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public Watchable $subject,
        public bool $isWatchlisted,
    ) {
        parent::__construct(
            user: $user,
            subject: $subject,
            action: $isWatchlisted ? 'added' : 'removed',
            metadata: [
                'title' => $subject->getTitle(),
                'timestamp' => now()->toDateTimeString(),
            ]
        );
    }

    public function getEventType(): string
    {
        return 'watchlist';
    }
}
