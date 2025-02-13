<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserSettingsController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        return view('settings.profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        dd($request->all());
    }
}
