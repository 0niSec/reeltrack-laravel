<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReelController extends Controller
{
    public function store(Request $request)
    {
        redirect()->route('movie.show', $request->movie_id)->with('success', 'Reel added successfully.');
    }

    public function update(Request $request, $id)
    {
        return [
            'reel' => $request,
        ];
    }

}
