<?php

namespace App\Jobs;

use App\DataTransferObjects\MovieDetailsDTO;
use App\Models\Movie;
use App\Services\CreditsService;
use App\Services\ImageService;
use App\Services\TmdbApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportMovieJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $uniqueFor = 120;

    public function __construct(
        private readonly MovieDetailsDTO $movieDetails
    ) {
    }

    public function uniqueId(): string
    {
        return 'movie_import_'.$this->movieDetails->id;
    }

    public function handle(
        TmdbApiService $tmdb,
        CreditsService $creditsService,
        ImageService $imageService
    ): void {
        try {
            $credits = $tmdb->movieCredits($this->movieDetails->id);

            DB::transaction(function () use ($creditsService, $credits, $imageService) {
                // First create the movie without images
                $movie = Movie::create([
                    'title' => $this->movieDetails->title,
                    'overview' => $this->movieDetails->overview,
                    'budget' => $this->movieDetails->budget,
                    'revenue' => $this->movieDetails->revenue,
                    'original_title' => $this->movieDetails->original_title,
                    'original_language' => $this->movieDetails->original_language,
                    'status' => $this->movieDetails->status ?? 'Released',
                    'release_date' => $this->movieDetails->release_date,
                    'runtime' => $this->movieDetails->runtime,
                    'tagline' => $this->movieDetails->tagline,
                    'tmdb_id' => $this->movieDetails->id,
                    'poster_path' => null,
                    'backdrop_path' => null
                ]);

                // Now download images with the database ID
                $storagePaths = $imageService->downloadMovieImages(
                    $movie->id,
                    $this->movieDetails->poster_path,
                    $this->movieDetails->backdrop_path
                );

                // Update the movie with the image paths
                $movie->update([
                    'poster_path' => $storagePaths['poster_path'],
                    'backdrop_path' => $storagePaths['backdrop_path']
                ]);

                $this->syncGenres($movie);
                $creditsService->storeCastMembers($credits['cast'], $movie);
                $creditsService->storeCrewMembers($credits['crew'], $movie);
            });
        } catch (\Throwable $e) {
            Log::error('Failed to import movie', [
                'movie_id' => $this->movieDetails->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        } finally {
            Cache::forget($this->uniqueId());
        }
    }

    private function syncGenres(Movie $movie): void
    {
        foreach ($this->movieDetails->genres as $genre) {
            $movie->genres()->updateOrCreate([
                'name' => $genre['name'],
                'tmdb_id' => $genre['id'],
            ]);
        }
    }
}
