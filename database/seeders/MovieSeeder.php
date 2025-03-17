<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Services\CreditsService;
use App\Services\ImageService;
use App\Services\TmdbApiService;
use GuzzleHttp\Promise\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MovieSeeder extends Seeder
{
    private TmdbApiService $tmdb;
    private ImageService $imageService;
    private CreditsService $creditsService;

    public function __construct()
    {
        $this->tmdb = new TmdbApiService();
        $this->imageService = new ImageService();
        $this->creditsService = new CreditsService();
    }

    public function run(): void
    {
        $this->debugStorageSetup();

        $movieIdList = [245891, 324552, 458156, 603692, 299536];

        // Fetch all movie details and credits concurrently
        $moviePromises = array_map(fn($id) => $this->fetchMovieDetailsAsync($id), $movieIdList);
        $movieResults = Utils::settle($moviePromises)->wait();

        $creditPromises = [];
        foreach ($movieResults as $id => $result) {
            if ($result['state'] === 'fulfilled' && !empty($result['value'])) {
                $movieDetails = $result['value'];

                Log::info('Movie details:', [
                    'id' => $movieDetails['id'],
                    'poster_path' => $movieDetails['poster_path'] ?? 'no poster',
                    'backdrop_path' => $movieDetails['backdrop_path'] ?? 'no backdrop'
                ]);

                $tmdbId = $movieDetails['id'];
                $creditPromises[$id] = $this->fetchCreditsAsync($tmdbId);
            }
        }

        $creditResults = Utils::settle($creditPromises)->wait();

        // Now process all data
        DB::transaction(function () use ($movieResults, $creditResults) {
            foreach ($movieResults as $id => $result) {
                if ($result['state'] !== 'fulfilled' || empty($result['value'])) {
                    continue;
                }

                $movieDetails = $result['value'];
                $credits = $creditResults[$id]['state'] === 'fulfilled' ? $creditResults[$id]['value'] : null;

                try {
                    // Download and store images
                    $storagePaths = $this->imageService->downloadMovieImages(
                        $movieDetails['id'],
                        $movieDetails['poster_path'] ?? null,
                        $movieDetails['backdrop_path'] ?? null
                    );

                    Log::info('Storage paths returned:', $storagePaths);

                    // Verify files exist after download
                    if ($storagePaths['poster_path']) {
                        $posterExists = Storage::disk('public')->exists(
                            str_replace('/storage/', '', $storagePaths['poster_path'])
                        );
                        Log::info("Poster file exists: ".($posterExists ? 'yes' : 'no'));
                    }

                    if ($storagePaths['backdrop_path']) {
                        $backdropExists = Storage::disk('public')->exists(
                            str_replace('/storage/', '', $storagePaths['backdrop_path'])
                        );
                        Log::info("Backdrop file exists: ".($backdropExists ? 'yes' : 'no'));
                    }


                    // Create movie with storage URLs
                    $movie = Movie::create([
                        'tmdb_id' => $movieDetails['id'],
                        'title' => $movieDetails['title'],
                        'overview' => $movieDetails['overview'],
                        'tagline' => $movieDetails['tagline'],
                        'budget' => $movieDetails['budget'],
                        'status' => $movieDetails['status'],
                        'original_title' => $movieDetails['original_title'],
                        'revenue' => $movieDetails['revenue'],
                        'original_language' => $movieDetails['original_language'],
                        'poster_path' => $storagePaths['poster_path'],
                        'backdrop_path' => $storagePaths['backdrop_path'],
                        'release_date' => $movieDetails['release_date'],
                        'runtime' => $movieDetails['runtime'],
                    ]);

                    // Store genres
                    if (!empty($movieDetails['genres'])) {
                        $genresData = array_map(function ($genre) {
                            return [
                                'tmdb_id' => $genre['id'],
                                'name' => $genre['name'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }, $movieDetails['genres']);

                        $movie->genres()->createMany($genresData);
                    }

                    // Store cast members using CreditsService
                    if ($credits && !empty($credits['cast'])) {
                        $castMembers = array_map(function ($castMember) {
                            return array_merge($castMember, ['id' => $castMember['id']]);
                        }, $credits['cast']);

                        $this->creditsService->storeCastMembers($castMembers, $movie);
                    }

                    // Store crew members
                    if ($credits && !empty($credits['crew'])) {
                        $crewMembers = array_map(function ($crewMember) {
                            return array_merge($crewMember, ['id' => $crewMember['id']]);
                        }, $credits['crew']);

                        $this->creditsService->storeCrewMembers($crewMembers, $movie);
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing movie: '.$e->getMessage());
                    throw $e;
                }
            }
        });
    }

    private function debugStorageSetup(): void
    {
        $publicPath = Storage::disk('public')->path('');
        $postersPath = Storage::disk('public')->path('posters');
        $backdropsPath = Storage::disk('public')->path('backdrops');

        Log::info('Storage paths:', [
            'public' => $publicPath,
            'posters' => $postersPath,
            'backdrops' => $backdropsPath,
        ]);

        // Create directories if they don't exist
        if (!Storage::disk('public')->exists('posters')) {
            Storage::disk('public')->makeDirectory('posters');
        }
        if (!Storage::disk('public')->exists('backdrops')) {
            Storage::disk('public')->makeDirectory('backdrops');
        }

        // Check permissions
        Log::info('Directory permissions:', [
            'public' => substr(sprintf('%o', fileperms($publicPath)), -4),
            'posters' => Storage::disk('public')->exists('posters')
                ? substr(sprintf('%o', fileperms($postersPath)), -4)
                : 'directory missing',
            'backdrops' => Storage::disk('public')->exists('backdrops')
                ? substr(sprintf('%o', fileperms($backdropsPath)), -4)
                : 'directory missing',
        ]);
    }


    private function fetchMovieDetailsAsync(int $id): \GuzzleHttp\Promise\PromiseInterface
    {
        return Http::async()
            ->withToken(config('services.tmdb.api_key'))
            ->get("https://api.themoviedb.org/3/movie/{$id}")
            ->then(fn($response) => $response->json());
    }

    private function fetchCreditsAsync(int $id): \GuzzleHttp\Promise\PromiseInterface
    {
        return Http::async()
            ->withToken(config('services.tmdb.api_key'))
            ->get("https://api.themoviedb.org/3/movie/{$id}/credits")
            ->then(fn($response) => $response->json());
    }
}
