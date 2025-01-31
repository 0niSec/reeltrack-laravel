<?php


use App\Jobs\ImportMovieJob;
use App\Services\TmdbApiService;

test('cannot import duplicate movies', function () {
    Queue::fake([
        ImportMovieJob::class,
    ]);

    // Retrieve the array details from your service
    $movieDetails = (new TmdbApiService())->movieDetails(912649);


    ImportMovieJob::dispatch($movieDetails);
    ImportMovieJob::dispatch($movieDetails);

    Queue::assertPushed(ImportMovieJob::class, 1);
});
