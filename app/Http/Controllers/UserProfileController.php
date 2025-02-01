<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load('profile');

        return view('users.profile.show', compact('user'));
    }

    public function edit(User $user)
    {
        // TODO: Add Guard so only current logged in user can edit their own profile
        return [
            'user' => $user,
        ];
    }
}
