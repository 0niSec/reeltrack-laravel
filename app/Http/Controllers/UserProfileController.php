<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        // Eager load relationships on User
        // Get all the content they've liked, reviewed and watched
        $user->load([
            'profile',
            'likes.likeable',
            'reviews.reviewable',
            'watches.watchable',
        ]);

        return view('users.profile.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load('profile');

        return view('users.profile.settings.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        //
    }
}
