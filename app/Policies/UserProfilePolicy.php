<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserProfilePolicy
{
    use HandlesAuthorization;


    /**
     * Determine if the given user profile can be edited by the user.
     *
     * @param  User  $user  The user attempting to edit the profile.
     * @param  UserProfile  $userProfile  The user profile to be edited.
     * @return bool True if the user owns the profile, false otherwise.
     * @see https://laravel.com/docs/11.x/authorization#writing-policies
     */
    public function edit(User $user, UserProfile $userProfile): bool
    {
        return $userProfile->user->is($user);
    }

    public function delete(User $user, UserProfile $userProfile): bool
    {
        return $userProfile->user->is($user);
    }


}
