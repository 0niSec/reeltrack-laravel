<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Throwable;

class TmdbApiService
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

            $contents = $response->getBody()->getContents();
            Log::info('TMDB API Raw Response', [
                'path' => $path,
                'raw_response' => $contents,
                'status_code' => $response->getStatusCode()
            ]);

            $parsed = json_decode($contents, true);

            if ($parsed === null) {
                Log::error('TMDB API JSON Parse Error', [
                    'json_error' => json_last_error_msg(),
                    'raw_content' => $contents
                ]);
            }

            return $parsed ?? [];
        } catch (Throwable $e) {
            Log::error('TMDB API Error', [
                'path' => $path,
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'stack_trace' => $e->getTraceAsString()
            ]);

            return [];
        }
    }

    public function popularMovies(): array
    {
        return $this->get('movie/popular');
    }

    public function movieDetails(int $id): array
    {
        $response = $this->get("movie/{$id}");

        Log::debug('TMDB movieDetails response:', [
            'original_language' => $response['original_language'] ?? 'not set',
            'all_keys' => array_keys($response)
        ]);

        return $response;
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
}
