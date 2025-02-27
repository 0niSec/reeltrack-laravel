<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Movie extends Model
{

    protected $fillable = [
        'title',
        'backdrop_path',
        'poster_path',
        'overview',
        'tagline',
        'runtime',
        'tmdb_id',
        'release_date',
        'ratings_count',
        'rating_average',
        'total_reviews',
        'total_ratings',
        'total_likes',
    ];

    // Relationships
    // End Relationships

    // Scopes
    public function scopeWithFullDetails($query)
    {
        return $query->with([
            'cast' => function ($query) {
                $query->orderBy('order', 'asc')
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
            ->withCount('reelEntries')
            ->withAvg('reelEntries as rating_avg', 'rating');
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

    public function getRouteKey(): string
    {
        return $this->id.'-'.str($this->title)->slug();
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

    public function cast(): MorphMany
    {
        return $this->morphMany(Cast::class, 'castable');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ReelEntry::class, 'reelable_id')
            ->whereNotNull('review_content')
            ->where('reelable_type', Movie::class)
            ->with('user')
            ->latest('watched_at');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(MovieGenre::class);
    }

    public function resolveRouteBinding($value, $field = null): Model|Movie|null
    {
        $id = explode('-', $value)[0];

        return $this->where('id', $id)->firstOrFail();
    }

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'runtime' => 'integer',
        ];
    }
}
