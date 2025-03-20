<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Movie extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'backdrop_path',
        'poster_path',
        'overview',
        'tagline',
        'runtime',
        'budget',
        'original_language',
        'original_title',
        'revenue',
        'tmdb_id',
        'release_date',
        'status',
        'ratings_count',
        'rating_average',
        'total_reviews',
        'total_ratings',
        'total_likes',
    ];

    protected $casts = [
        'release_date' => 'date',
        'runtime' => 'integer',
    ];

    // Relationships
    // End Relationships

    // Scopes

    public static function getGenreSpotlights(): Collection
    {
        $targetGenres = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Romance', 'Science Fiction', 'Thriller'
        ];
        $spotlights = new Collection();
        $usedMovieIds = [];

        foreach ($targetGenres as $genre) {
            // Find the most popular movie for this genre that hasn't been used yet
            $movie = self::whereHas('genres', function ($query) use ($genre) {
                $query->where('name', $genre);
            })
                ->whereNotIn('id', $usedMovieIds)
                ->where('poster_path', '!=', '')
                ->withAvg('reelEntries as avg_rating', 'rating')
                ->withCount('reelEntries as watch_count')
                ->orderByRaw('avg_rating DESC NULLS LAST')
                ->orderBy('watch_count', 'desc')
                ->first();

            if ($movie) {
                $movie->genre = $genre;
                $spotlights->push($movie);
                $usedMovieIds[] = $movie->id;

                // Only collect the first 2-4 genres that have movies
                if ($spotlights->count() >= 4) {
                    break;
                }
            }
        }

        return $spotlights;
    }

    /**
     * Boot the model and register a saving event to set the slug attribute
     * based on the model's title property using Str::slug.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }

    public function scopeWithFullDetails($query)
    {
        return $query->with([
            'cast' => function ($query) {
                $query->orderBy('order')
                    ->with(['person:id,name,profile_path'])
                    ->take(10);
            },
            'crew' => function ($query) {
                $query->whereIn('job', [
                    'Director',
                    'Writer',
                    'Producer',
                    'Executive Producer',
                ])
                    ->orderBy('job')
                    ->with(['person:id,name,profile_path']);
            },
            'genres',
        ])
            ->withAvg('reelEntries as rating_avg', 'rating');
    }

    public function scopePopular(Builder $query)
    {
        return $query->withCount([
            'userInteractions',
            'userInteractions as watched_count' => fn($query) => $query->where('is_watched', true),
            'userInteractions as likes_count' => fn($query) => $query->where('is_liked', true),
            'userInteractions as ratings_count' => fn($query) => $query->whereNotNull('rating'),
        ])
            ->withAvg('userInteractions as ratings_avg_rating', 'rating')
            ->orderByDesc('likes_count')
            ->orderByDesc('ratings_avg_rating');
    }
    // End Scopes

    // Helpers

    public function scopeNewest($query)
    {
        return $query->latest();
    }

    public function scopeLatestReviews($query)
    {
        return $query->whereHas('reviews', function ($query) {
            $query->whereNotNull('content');
        })
            ->with([
                'reviews' => function ($query) {
                    $query->latest()->take(1) // Only the latest review for that movie
                    ->with([
                        'user', 'reelEntry'
                    ]); // Get the user and reel entry for tracking likes and ratings on review
                },
            ])
            ->orderBy(function ($query) {
                $query->select('created_at')
                    ->from('reviews')
                    ->whereColumn('reviewable_id', 'movies.id')
                    ->whereNotNull('content')
                    ->orderByDesc('created_at')
                    ->limit(1);
            }, 'desc');

    }

    public function getRating(?User $user = null): ?float
    {
        $user ??= auth()->user();

        // Check latest reel entry first
        $latestReel = $this->reelEntries()
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if ($latestReel) {
            return $latestReel->rating;
        }

        // Fall back to user interactions
        return $this->userInteractions()
            ->where('user_id', $user->id)
            ->value('rating');
    }

    public function reelEntries(): MorphMany
    {
        return $this->morphMany(ReelEntry::class, 'reelable');
    }

    public function userInteractions(): MorphMany
    {
        return $this->morphMany(UserInteraction::class, 'interactable');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isInWatchlist(?User $user = null): bool
    {
        $user ??= auth()->user();

        return (bool) $this->userInteractions()
            ->where('user_id', $user->id)
            ->value('is_in_watchlist');
    }

    public function isLiked(?User $user = null): bool
    {
        $user ??= auth()->user();

        // Check latest reel entry first
        $latestReel = $this->reelEntries()
            ->where('user_id', $user->id)
            ->latest()
            ->first();

        if ($latestReel) {
            return (bool) $latestReel->is_liked;
        }

        // Fall back to user interactions
        return (bool) $this->userInteractions()
            ->where('user_id', $user->id)
            ->value('is_liked');
    }

    // End Helpers

    public function isWatched(?User $user = null): bool
    {
        $user ??= auth()->user();

        // Check if any reel entries exist
        $hasReelEntry = $this->reelEntries()
            ->where('user_id', $user->id)
            ->exists();

        if ($hasReelEntry) {
            return true;
        }

        // Fall back to user interactions
        return (bool) $this->userInteractions()
            ->where('user_id', $user->id)
            ->value('is_watched');
    }

    public function cast(): MorphMany
    {
        return $this->morphMany(Cast::class, 'castable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(MovieGenre::class);
    }
}
