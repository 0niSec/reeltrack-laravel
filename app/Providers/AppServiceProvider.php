<?php

namespace App\Providers;

use App\Models\Movie;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
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

        Route::bind('movie', function ($value) {
            $id = explode('-', $value)[0];
            $movie = Movie::findOrFail($id);

            return $id.'-'.str($movie->title)->slug();
        });

        // Rate Limit Login
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(10, 5)->by($request->username)->by($request->ip());
        });
    }
}
