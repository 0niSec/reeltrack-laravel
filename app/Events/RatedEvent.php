<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

class RatedEvent
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public Model $content,
        public int $rating
    ) {
    }
}
