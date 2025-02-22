<?php

namespace App\Events;

use App\Contracts\Watchable;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class RatingEvent extends ActivityEvent
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public Watchable $subject,
        public int $rating,
    ) {
        parent::__construct(
            user: $user,
            subject: $subject,
            action: $this->rating > 0 ? 'rated' : 'unrated',
            metadata: [
                'rating' => $rating,
                'title' => $subject->getTitle(),
                'timestamp' => now()->toDateTimeString(),
            ]
        );
    }

    public function getEventType(): string
    {
        return 'rating';
    }
}
