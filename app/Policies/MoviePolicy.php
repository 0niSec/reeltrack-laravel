<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoviePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Movie $movie): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Movie $movie): bool
    {
    }

    public function delete(User $user, Movie $movie): bool
    {
    }

    public function restore(User $user, Movie $movie): bool
    {
    }

    public function forceDelete(User $user, Movie $movie): bool
    {
    }
}
