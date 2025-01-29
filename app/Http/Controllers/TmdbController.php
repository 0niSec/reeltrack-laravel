<?php

namespace App\Http\Controllers;

use App\Jobs\ImportMovieJob;
use App\Services\TmdbApiService;
use Cache;
use Illuminate\Http\RedirectResponse;

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
     * @param  string  $type
     * @param  string  $id
     * @return RedirectResponse
     * @uses ImportMovieJob
     *
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

            $lock = Cache::lock('movie_import_lock'.$id, 10); // Lock for 10 seconds

            if ($lock->get()) {
                // Check if the job requested is already in the jobs queue to be run
                if (Cache::has('movie_import_'.$id)) {
                    $lock->release();

                    return redirect()->route('movies.index')->with('warning',
                        'Movie import job already in progress with this job ID. Please wait for the import to complete.');
                }

                Cache::put('movie_import_'.$id, true, 600); // Cache for 10 minutes

                // Dispatch the job
                ImportMovieJob::dispatch($type, $id);

                // Release the lock
                $lock->release();

                // Return a quick response
                return redirect()->route('movies.index')->with('status', 'Movie added to queue. Check back shortly!');
            } else {
                // If the lock cannot be acquired, return a warning
                return redirect()->route('movies.index')->with('error',
                    'Unable to process request. Please try again later.');
            }
        }
    }
}
