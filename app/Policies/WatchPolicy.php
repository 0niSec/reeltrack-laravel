<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Watch;
use Illuminate\Auth\Access\HandlesAuthorization;

class WatchPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Watch $watch): bool
    {
    }

    public function create(User $user): bool
    {
        return $user->is(auth()->user());
    }

    public function update(User $user, Watch $watch): bool
    {
        return $user->is($watch->user);
    }

    public function delete(User $user, Watch $watch): bool
    {
    }

    public function restore(User $user, Watch $watch): bool
    {
    }

    public function forceDelete(User $user, Watch $watch): bool
    {
    }
}
