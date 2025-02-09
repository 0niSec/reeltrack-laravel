<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Auth\Access\HandlesAuthorization;

class WatchlistPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Watchlist $watchlist): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Watchlist $watchlist): bool
    {
    }

    public function delete(User $user, Watchlist $watchlist): bool
    {
    }

    public function restore(User $user, Watchlist $watchlist): bool
    {
    }

    public function forceDelete(User $user, Watchlist $watchlist): bool
    {
    }
}
