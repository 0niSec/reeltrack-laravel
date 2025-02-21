<?php

namespace App\Events;

use App\Contracts\Watchable;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class ActivityEvent
{
    use Dispatchable, SerializesModels;

    /**
     * @param  User  $user
     * @param  Watchable  $subject
     * @param  string  $action
     * @param  array  $metadata
     */
    public function __construct(
        public User $user,
        public Watchable $subject,
        public string $action,
        public array $metadata = []
    ) {
    }

    abstract public function getEventType(): string;
}
