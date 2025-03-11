<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['timeout' => 60]);
    }

    public function downloadMovieImages(string $tmdbId, ?string $posterPath, ?string $backdropPath): array
    {
        $promises = [];
        $storagePaths = [
            'poster_path' => null,
            'backdrop_path' => null
        ];

        if ($posterPath) {
            $localPath = "posters/movie_$tmdbId.jpg";
            $promises['poster'] = $this->downloadImageAsync(
                "https://image.tmdb.org/t/p/w500$posterPath",
                $localPath
            );
            $storagePaths['poster_path'] = Storage::url($localPath);
        }

        if ($backdropPath) {
            $localPath = "backdrops/movie_$tmdbId.jpg";
            $promises['backdrop'] = $this->downloadImageAsync(
                "https://image.tmdb.org/t/p/original{$backdropPath}",
                $localPath
            );
            $storagePaths['backdrop_path'] = Storage::url($localPath);
        }

        // Wait for all downloads to complete
        if (!empty($promises)) {
            \GuzzleHttp\Promise\Utils::settle($promises)->wait();
        }

        return $storagePaths;
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
}
