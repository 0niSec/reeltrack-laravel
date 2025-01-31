<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validate the user
        $validatedAttributes = $request->validate([
            'username' => ['required', 'max:24', 'min:5'],
            'password' => ['required'],
        ]);

        // Attempt to log in
        if (!Auth::attempt($validatedAttributes, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'username' => 'The provided credentials do not match our records.',
                'password' => 'The provided credentials do not match our records.',
            ]);
        }

        // Regenerate session token
        $request->session()->regenerate();

        // Redirect back
        return redirect()->route('profile', ['id' => Auth::user()->id])->with('success', 'You have been logged in.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        // Following Laravel practices
        // https://laravel.com/docs/11.x/authentication#logging-out
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('status', 'You have been logged out.');
    }

}
