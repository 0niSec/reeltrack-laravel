<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
            'userInteractions as likes_count' => fn($query) => $query->where('is_liked', true),
            'userInteractions as ratings_count' => fn($query) => $query->whereNotNull('rating'),
        ])
            ->withAvg('userInteractions as ratings_avg_rating', 'rating')
            ->orderByDesc('likes_count')
            ->orderByDesc('ratings_avg_rating');
    }

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
                    ->with('user');
                },
            ])
            ->latest();
    }
    // End Scopes

    // Helpers
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
    // End Helpers

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
