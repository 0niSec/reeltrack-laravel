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

    private string $type;
    private string $id;

    public function __construct(
        // These can be used in `handle` and are created with the Job
        string $type,
        string $id
    ) {
        $this->type = $type;
        $this->id = $id;
    }

    /* @noinspection PhpUnused */
    public function uniqueId(): string
    {
        return $this->type.':'.$this->id;
    }

    public function uniqueFor(): int
    {
        return 120; // Lock for 120 seconds
    }

    /**
     * @param  TmdbApiService  $tmdb
     * @param  CreditsService  $creditsService
     * @return void
     */
    public function handle(TmdbApiService $tmdb, CreditsService $creditsService): void
    {
        // TODO: What happens if $id is invalid?
        $movieDetails = $tmdb->movieDetails($this->id);
        $credits = $tmdb->movieCredits($this->id);
        $genres = $movieDetails['genres'];

        // Create the movie record in the movies table
        // Use a DB::transaction due to the complexity, and we want to have Eloquent automatically rollback
        // if something goes wrong
        DB::transaction(function () use ($tmdb, $creditsService, $movieDetails, $credits, $genres) {
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

        Cache::forget('movie_import_'.$this->id);
    }
}
