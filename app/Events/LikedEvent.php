<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

class LikedEvent
{
    use Dispatchable;

    public function __construct(
        public User $user,
        public Model $content,
        public bool $isLiked
    ) {
    }
}
