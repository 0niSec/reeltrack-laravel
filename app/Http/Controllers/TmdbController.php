<?php

namespace App\Http\Controllers;

use App\Jobs\ImportMovieJob;
use App\Services\TmdbApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class TmdbController extends Controller
{
    /**
     * Finds or creates a movie record from the TMDb API.
     *
     * This method queues an ImportMovieJob to fetch extended details and store them
     * in the database in the background.
     *
     * The method will redirect the user to the `/movies` page.
     *
     * @param  TmdbApiService  $tmdb
     * @param  string  $type
     * @param  string  $id
     * @return RedirectResponse
     * @uses ImportMovieJob
     */
    public function findOrCreate(TmdbApiService $tmdb, string $type, string $id):
    RedirectResponse {
        // Check if the type is 'movie'
        if ($type === 'movie') {
            // Validate that the given ID is actually valid
            $movieDetails = $tmdb->movieDetails($id);
            if (!$movieDetails) {
                // If the ID is invalid, don't enqueue the job
                return redirect()->route('movies.index')->with('error', 'Movie not found.');
            }

            $lock = Cache::has('movie_import_'.$movieDetails['id']);

            if ($lock) {
                return redirect()->route('movies.index')->with('warning',
                    'There is a job already queued for import for that ID. Please wait and it should be available shortly.');
            } else {
                Cache::put('movie_import_'.$movieDetails['id'], true, 120);
                // Dispatch the job
                ImportMovieJob::dispatch($movieDetails);

                // Redirect success
                return redirect()->route('movies.index')->with('status', 'Movie added to queue.');
            }
        } else {
            return redirect()->route('movies.index')->with('error', 'Invalid type.');
        }
    }
}
