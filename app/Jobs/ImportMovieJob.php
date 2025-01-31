<?php

namespace App\Jobs;

use App\Models\Movie;
use App\Services\CreditsService;
use App\Services\TmdbApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

// FIXME: Something in here is causing the entire application to lock up while a job is queued

class ImportMovieJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $movieDetails;
    private string $id;

    public function __construct(
        // These can be used in `handle` and are created with the Job
        array $movieDetails
    ) {
        $this->movieDetails = $movieDetails;
        $this->id = (string) $movieDetails['id'];
    }

    /**
     * Get the unique ID for the job.
     * @see https://laravel.com/docs/11.x/queues#unique-jobs
     * @noinspection PhpUnused
     */
    public function uniqueId(): string
    {
        return 'movie_import_'.$this->id;
    }

    public function uniqueFor(): int
    {
        return 120; // Unique for 2 minutes while processing
    }

    /**
     * @param  TmdbApiService  $tmdb
     * @param  CreditsService  $creditsService
     * @return void
     */
    public function handle(TmdbApiService $tmdb, CreditsService $creditsService): void
    {
        $credits = $tmdb->movieCredits($this->id);
        $genres = $this->movieDetails['genres'];

        // Create the movie record in the movies table
        // Use a DB::transaction due to the complexity, and we want to have Eloquent automatically rollback
        // if something goes wrong
        DB::transaction(function () use ($tmdb, $creditsService, $credits, $genres) {
            $movie = Movie::firstOrCreate([
                'tmdb_id' => $this->id,
            ], [
                'title' => $this->movieDetails['title'],
                'overview' => $this->movieDetails['overview'],
                'poster_path' => $tmdb->posterUrl($this->movieDetails['poster_path']),
                'backdrop_path' => $tmdb->backdropUrl($this->movieDetails['backdrop_path']),
                'release_date' => $this->movieDetails['release_date'],
                'runtime' => $this->movieDetails['runtime'],
                'tagline' => $this->movieDetails['tagline'],
                'tmdb_id' => $this->id,
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
        Cache::forget('movie_import_'.$this->id);
    }
}
