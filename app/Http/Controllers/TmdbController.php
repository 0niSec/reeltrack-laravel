<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\CreditsService;
use App\Services\TmdbApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class TmdbController extends Controller
{
    /**
     * Finds an existing movie or TV series and lets the user know it already exists
     * or creates a new listing from the TMDb API
     * @param  TmdbApiService  $tmdb
     * @param  string  $type
     * @param  string  $id
     * @return RedirectResponse
     */
    public function findOrCreate(TmdbApiService $tmdb, CreditsService $creditsService, string $type, string $id):
    RedirectResponse {
        if ($type === 'movie') {
            // TODO: What happens if $id is invalid?
            $movieDetails = $tmdb->movieDetails($id);
            $genres = $movieDetails['genres'];
            $credits = $tmdb->movieCredits($id);

            // Create the movie record in the movies table
            // Use a DB::transaction due to the complexity, and we want to have Eloquent automatically rollback
            // if something goes wrong
            DB::transaction(function () use ($tmdb, $creditsService, $movieDetails, $genres, $credits) {
                $movie = Movie::firstOrCreate([
                    'tmdb_id' => $movieDetails['id'],
                ], [
                    'title' => $movieDetails['title'],
                    'overview' => $movieDetails['overview'],
                    'poster_path' => $tmdb->posterUrl($movieDetails['poster_path']),
                    'backdrop_path' => $tmdb->backdropUrl($movieDetails['backdrop_path']),
                    'release_date' => $movieDetails['release_date'],
                    'runtime' => $movieDetails['runtime'],
                    'tagline' => $movieDetails['tagline'],
                    'tmdb_id' => $movieDetails['id'],
                ]);

                // Loop over the genres array
                // and add the records to the genres table
                foreach ($genres as $genre) {
                    $movie->genres()->updateOrCreate([
                        'name' => $genre['name'],
                        'tmdb_id' => $genre['id'],
                    ]);
                }

                // Store the cast members and their related person data
                $creditsService->storeCastMembers($credits['cast'], $movie);

                // Store the crew members and their related person data
                $creditsService->storeCrewMembers($credits['crew'], $movie);
            });

            return redirect()->route('movies.show',
                Movie::with('cast.person', 'crew.person', 'genres')->where('tmdb_id', $movieDetails['id'])->first())
                ->with
                ('status',
                    'Movie added successfully.');
        }

        return redirect()->route('movies.index')->with('status', 'Movie not found.');
    }

}
