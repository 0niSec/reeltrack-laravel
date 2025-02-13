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
            'reviews.reviewable',
        ]);

        return view('users.profile.show', compact('user'));
    }


    public function destroy(Request $request, User $user)
    {
        dd($request->all());
    }
}
