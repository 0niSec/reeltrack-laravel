<?php

namespace App\Policies;

use App\Models\Reel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReelPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Reel $reel): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Reel $reel): bool
    {
    }

    public function delete(User $user, Reel $reel): bool
    {
    }

    public function restore(User $user, Reel $reel): bool
    {
    }

    public function forceDelete(User $user, Reel $reel): bool
    {
    }
}
