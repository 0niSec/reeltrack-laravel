<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    // Display the register form
    // Goes to store to perform the registration
    public function store(Request $request): RedirectResponse
    {
        // Validate the user
        $attrs = $request->validate([
            'username' => ['required', 'string', 'max:24', 'min:5', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::min(15), 'confirmed'], // Automatically looks for
            // password_confirmation
        ]);

        // Create the user
        $user = User::create($attrs);

        $user->profile()->create();

        //Reel the user in
        Auth::login($user);

        // Redirect
        return redirect()->route('welcome');
    }

    public function create()
    {
        return view('auth.register');
    }
}
