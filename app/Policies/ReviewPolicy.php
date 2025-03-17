<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Review $review): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Review $review): bool
    {
    }

    public function destroy(User $user, Review $review): Response
    {
        return $user->id === $review->user->id ? Response::allow() : Response::denyAsNotFound();
    }

    public function restore(User $user, Review $review): bool
    {
    }

    public function forceDelete(User $user, Review $review): bool
    {
    }
}
