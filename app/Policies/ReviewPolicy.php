<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user, Review $review): Response
    {
        return $user->id === $review->user->id ? Response::allow() : Response::denyAsNotFound();
    }

}
