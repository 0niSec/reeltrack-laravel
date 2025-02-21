<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Services\CreditsService;
use App\Services\TmdbApiService;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MovieSeeder extends Seeder
{
    private TmdbApiService $tmdb;
    private Client $client;
    private CreditsService $creditsService;


    public function __construct()
    {
        $this->tmdb = new TmdbApiService();
        $this->client = new Client(['timeout' => 60]);
        $this->creditsService = new CreditsService();
    }

    public function run(): void
    {
        $randomIds = [120, 121, 122, 49051, 122917, 57158, 245891, 603692, 324552, 458156];

        // Fetch all movie details and credits concurrently
        $moviePromises = array_map(fn($id) => $this->fetchMovieDetailsAsync($id), $randomIds);
        $movieResults = Utils::settle($moviePromises)->wait();

        $creditPromises = [];
        foreach ($movieResults as $id => $result) {
            if ($result['state'] === 'fulfilled' && !empty($result['value'])) {
                $movieDetails = $result['value'];
                $tmdbId = $movieDetails['id']; // Get the actual TMDB ID from the movie details
                $creditPromises[$id] = $this->fetchCreditsAsync($tmdbId); // Pass the TMDB ID instead of the array index
            }
        }

        $creditResults = Utils::settle($creditPromises)->wait();

        // Download all images first
        $imagePromises = [];
        $storagePaths = [];

        foreach ($movieResults as $id => $result) {
            if ($result['state'] !== 'fulfilled' || empty($result['value'])) {
                continue;
            }

            $movieDetails = $result['value'];

            if (!empty($movieDetails['backdrop_path'])) {
                $backdropPath = "backdrops/movie_{$id}.jpg";
                $imagePromises["backdrop_{$id}"] = $this->downloadImageAsync(
                    $this->tmdb->backdropUrl($movieDetails['backdrop_path']),
                    $backdropPath
                );
                $storagePaths[$id]['backdrop_path'] = Storage::url($backdropPath);
            }

            if (!empty($movieDetails['poster_path'])) {
                $posterPath = "posters/movie_{$id}.jpg";
                $imagePromises["poster_{$id}"] = $this->downloadImageAsync(
                    $this->tmdb->posterUrl($movieDetails['poster_path']),
                    $posterPath
                );
                $storagePaths[$id]['poster_path'] = Storage::url($posterPath);
            }
        }

        // Wait for all images to download
        if (!empty($imagePromises)) {
            Utils::settle($imagePromises)->wait();
        }

        // Now process all data with correct storage URLs
        DB::transaction(function () use ($movieResults, $creditResults, $storagePaths) {
            foreach ($movieResults as $id => $result) {
                if ($result['state'] !== 'fulfilled' || empty($result['value'])) {
                    continue;
                }

                $movieDetails = $result['value'];
                $credits = $creditResults[$id]['state'] === 'fulfilled' ? $creditResults[$id]['value'] : null;


                // Create movie with pre-calculated storage URLs
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
                    'poster_path' => $storagePaths[$id]['poster_path'] ?? null,
                    'backdrop_path' => $storagePaths[$id]['backdrop_path'] ?? null,
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

                // Wait for all image downloads to complete
                if (!empty($imagePromises)) {
                    Utils::settle($imagePromises)->wait();
                }

                // Store cast members using CreditsService
                if ($credits && !empty($credits['cast'])) {
                    // Map the TMDB ID to each cast member
                    $castMembers = array_map(function ($castMember) {
                        return array_merge($castMember, ['id' => $castMember['id']]); // Ensure TMDB ID is included
                    }, $credits['cast']);

                    $this->creditsService->storeCastMembers($castMembers, $movie);
                }


                // Store crew members if credits were fetched successfully
                if ($credits && !empty($credits['crew'])) {
                    // Map the TMDB ID to each crew member
                    $crewMembers = array_map(function ($crewMember) {
                        return array_merge($crewMember, ['id' => $crewMember['id']]); // Ensure TMDB ID is included
                    }, $credits['crew']);

                    $this->creditsService->storeCrewMembers($crewMembers, $movie);
                }
            }
        });
    }

    private function fetchMovieDetailsAsync(int $id): PromiseInterface
    {
        return Http::async()
            ->withToken(config('services.tmdb.api_key'))
            ->get("https://api.themoviedb.org/3/movie/{$id}")
            ->then(fn($response) => $response->json());
    }

    private function fetchCreditsAsync(int $id): PromiseInterface
    {
        return Http::async()
            ->withToken(config('services.tmdb.api_key'))
            ->get("https://api.themoviedb.org/3/movie/{$id}/credits")
            ->then(fn($response) => $response->json());
    }

    private function downloadImageAsync(string $url, string $path): PromiseInterface
    {
        return $this->client->getAsync($url)->then(
            function ($response) use ($path) {
                Storage::disk('public')->put($path, $response->getBody());

                return $path;
            }
        );
    }

    private function processCredits(Movie $movie, array $credits): void
    {
        if (!empty($credits['cast'])) {
            $castData = array_map(fn($member) => [
                'name' => $member['name'],
                'character' => $member['character'] ?? null,
                'order' => $member['order'] ?? null,
                'castable_type' => Movie::class,
                'castable_id' => $movie->id,
            ], $credits['cast']);

            $movie->cast()->createMany($castData);
        }

        if (!empty($credits['crew'])) {
            $crewData = array_map(fn($member) => [
                'name' => $member['name'],
                'job' => $member['job'],
                'department' => $member['department'],
                'crewable_type' => Movie::class,
                'crewable_id' => $movie->id,
            ], $credits['crew']);

            $movie->crew()->createMany($crewData);
        }
    }
}
