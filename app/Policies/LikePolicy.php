<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Like $like): bool
    {
    }

    public function create(User $user): bool
    {
        return $user->is(auth()->user());
    }

    /*
     * Determine if the given like can be updated by the user
     */
    public function update(User $user, Like $like): bool
    {
        return $user->is($like->user);
    }

    public function delete(User $user, Like $like): bool
    {
    }

    public function restore(User $user, Like $like): bool
    {
    }

    public function forceDelete(User $user, Like $like): bool
    {
    }
}
