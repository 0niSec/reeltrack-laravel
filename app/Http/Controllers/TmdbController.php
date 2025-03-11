<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\MovieDetailsDTO;
use App\Jobs\ImportMovieJob;
use App\Services\TmdbApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class TmdbController extends Controller
{
    public function __construct(
        private readonly TmdbApiService $tmdb
    ) {
    }

    public function findOrCreate(string $type, string $id): RedirectResponse
    {
        if ($type !== 'movie') {
            return $this->errorResponse('Invalid type.');
        }

        $movieDetails = $this->tmdb->movieDetails($id);

        if (empty($movieDetails)) {
            return $this->errorResponse('Movie not found.');
        }

        $cacheKey = "movie_import_{$movieDetails['id']}";

        if (Cache::has($cacheKey)) {
            return $this->warningResponse('Movie import already in progress.');
        }

        try {
            $dto = MovieDetailsDTO::fromArray($movieDetails);
            Cache::put($cacheKey, true, 120);
            ImportMovieJob::dispatch($dto);

            return $this->successResponse('Movie added to queue.');
        } catch (\Throwable $e) {
            report($e);
            return $this->errorResponse('Failed to queue movie import.');
        }
    }

    private function errorResponse(string $message): RedirectResponse
    {
        return redirect()->route('movies.index')->with('error', $message);
    }

    private function warningResponse(string $message): RedirectResponse
    {
        return redirect()->route('movies.index')->with('warning', $message);
    }

    private function successResponse(string $message): RedirectResponse
    {
        return redirect()->route('movies.index')->with('success', $message);
    }
}
