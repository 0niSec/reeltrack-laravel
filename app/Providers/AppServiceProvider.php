<?php

namespace App\Providers;

use App\Events\RatingEvent;
use App\Events\WatchlistEvent;
use App\Listeners\LogUserActivityListener;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prevent Lazy Loading globally
        Model::preventLazyLoading(!app()->isProduction());

        // Rate Limit Login
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(10, 5)->by($request->username)->by($request->ip());
        });

        // Event Registration
        Event::listen(
            WatchlistEvent::class,
            LogUserActivityListener::class,
        );

        Event::listen(
            RatingEvent::class,
            LogUserActivityListener::class,
        );
    }
}
