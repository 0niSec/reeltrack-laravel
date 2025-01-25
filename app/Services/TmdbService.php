<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Throwable;

class TmdbService
{
    private const BASE_URL = 'https://api.themoviedb.org/3/'; // ensure “/3/” is included
    private const IMAGE_BASE_URL = 'https://image.tmdb.org/t/p';

    protected Client $client;

    public function __construct()
    {
        $apiToken = config('services.tmdb.api_key'); // or config('services.tmdb.api_token') if you prefer

        $this->client = new Client([
            'base_uri' => self::BASE_URL,
            'headers' => [
                'Authorization' => 'Bearer '.$apiToken,
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function findMovie(int $tmdbId): array
    {
        return $this->get("movie/{$tmdbId}");
    }

    public function popularMovies(): array
    {
        return $this->get('movie/popular');
    }

    public function movieDetails(int $id): array
    {
        return $this->get("movie/{$id}");
    }

    public function movieCredits(int $id): array
    {
        return $this->get("movie/{$id}/credits");
    }

    public function personDetails(int $id): array
    {
        return $this->get("person/{$id}");
    }

    public function backdropUrl(?string $path, string $size = 'original'): ?string
    {
        if (!$path) {
            return null;
        }

        return self::IMAGE_BASE_URL."/{$size}{$path}";
    }

    public function posterUrl(?string $path, string $size = 'w500'): ?string
    {
        if (!$path) {
            return null;
        }

        return self::IMAGE_BASE_URL."/{$size}{$path}";
    }

    /**
     * Internal helper to perform GET requests.
     */
    private function get(string $path): array
    {
        try {
            $response = $this->client->get($path, [
                'query' => [
                    'language' => 'en-US',
                ],
            ]);

            $parsed = json_decode($response->getBody()->getContents(), true);
            return $parsed ?? [];
        } catch (Throwable $e) {
            Log::error('TMDB API Error: '.$e->getMessage());
            return [];
        }
    }
}
