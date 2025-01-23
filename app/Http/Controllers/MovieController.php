<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;

class MovieController extends Controller
{
    public function index(TmdbService $tmdb)
    {
        $popularMovies = $tmdb->popularMovies();

        // Get the results from the JSON
        $movies = $popularMovies['results'] ?? [];

        return view('movies.index', compact('movies'));
    }

    public function show(TmdbService $tmdb, $id)
    {
        $movie = $tmdb->movieDetails($id);

        // Convert the relative backdrop_path to the right one for TMDB
        // TODO: We will fix this later
        $movie['backdrop_path'] = 'https://image.tmdb.org/t/p/original'.$movie['backdrop_path'];
        $movie['poster_path'] = 'https://image.tmdb.org/t/p/w500'.$movie['poster_path'];

        $credits = $tmdb->movieCredits($id);

// Fix profile paths for cast
        if (!empty($credits['cast'])) {
            foreach ($credits['cast'] as $index => $castMember) {
                if (!empty($castMember['profile_path'])) {
                    $credits['cast'][$index]['profile_path'] = 'https://image.tmdb.org/t/p/w300'.$castMember['profile_path'];
                } else {
                    $credits['cast'][$index]['profile_path'] = 'https://ui-avatars.com/api/?name='
                        .urlencode(substr($castMember['name'], 0, 2))
                        .'&background=random&color=fff&size=300';
                }
            }
        }

// Fix profile paths for crew
        if (!empty($credits['crew'])) {
            foreach ($credits['crew'] as $index => $crewMember) {
                if (!empty($crewMember['profile_path'])) {
                    $credits['crew'][$index]['profile_path'] = 'https://image.tmdb.org/t/p/w300'.$crewMember['profile_path'];
                } else {
                    $credits['crew'][$index]['profile_path'] = 'https://ui-avatars.com/api/?name='
                        .urlencode(substr($crewMember['name'], 0, 2))
                        .'&background=random&color=fff&size=300';
                }
            }
        }


        return view('movies.show', compact('movie', 'credits'));
    }
}

https://ui-avatars.com/api/?background=random
