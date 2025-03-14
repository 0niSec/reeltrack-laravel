<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    private Client $client;
    private const TMDB_IMAGE_BASE_URL = 'https://image.tmdb.org/t/p/';

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 60,
        ]);
    }

    public function downloadMovieImages(string $tmdbId, ?string $posterPath, ?string $backdropPath): array
    {
        $promises = [];
        $storagePaths = [
            'poster_path' => null,
            'backdrop_path' => null
        ];

        try {
            if ($posterPath) {
                $localPath = "posters/movie_{$tmdbId}.jpg";
                $fullUrl = self::TMDB_IMAGE_BASE_URL."w500{$posterPath}";
                Log::info("Downloading poster from: {$fullUrl}");

                $promises['poster'] = $this->downloadImageAsync($fullUrl, $localPath);
                $storagePaths['poster_path'] = "/storage/{$localPath}";
            }

            if ($backdropPath) {
                $localPath = "backdrops/movie_{$tmdbId}.jpg";
                $fullUrl = self::TMDB_IMAGE_BASE_URL."original{$backdropPath}";
                Log::info("Downloading backdrop from: {$fullUrl}");

                $promises['backdrop'] = $this->downloadImageAsync($fullUrl, $localPath);
                $storagePaths['backdrop_path'] = "/storage/{$localPath}";
            }

            // Wait for all downloads to complete
            if (!empty($promises)) {
                $results = \GuzzleHttp\Promise\Utils::settle($promises)->wait();

                // Check results
                foreach ($results as $type => $result) {
                    if ($result['state'] === 'fulfilled') {
                        Log::info("Successfully downloaded {$type} image");
                    } else {
                        Log::error("Failed to download {$type} image: ".$result['reason']);
                        // Reset the storage path if download failed
                        $storagePaths["{$type}_path"] = null;
                    }
                }
            }

        } catch (\Exception $e) {
            Log::error("Error downloading images: ".$e->getMessage());
        }

        return $storagePaths;
    }

    private function downloadImageAsync(string $url, string $path): PromiseInterface
    {
        return $this->client->getAsync($url)->then(
            function ($response) use ($path) {
                $imageContent = $response->getBody()->getContents();
                if (empty($imageContent)) {
                    throw new \Exception("Downloaded image content is empty");
                }

                $success = Storage::disk('public')->put($path, $imageContent);
                if (!$success) {
                    throw new \Exception("Failed to save image to storage");
                }

                Log::info("Successfully saved image to: {$path}");
                return $path;
            },
            function ($exception) use ($url) {
                Log::error("Failed to download image from {$url}: ".$exception->getMessage());
                throw $exception;
            }
        );
    }
}
