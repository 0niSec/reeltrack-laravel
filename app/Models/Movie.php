<?php

namespace App\Models;

use App\Contracts\Watchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Movie extends Model implements Watchable
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

    public function getRouteKey(): string
    {
        return $this->id.'-'.str($this->title)->slug();
    }

    public function resolveRouteBinding($value, $field = null): Model|Movie|null
    {
        $id = explode('-', $value)[0];

        return $this->where('id', $id)->firstOrFail();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function scopeLatestReviews(Builder $query): void
    {
        $query->withCount('reviews')->latest()->take(10);
    }

    public function scopeWithReelStats($query)
    {
        return $query->withCount([
            'reels as likes_count' => function ($query) {
                $query->where('is_liked', true);
            },
            'reels as ratings_count' => function ($query) {
                $query->whereNotNull('rating');
            },
            'reels as watch_count' => function ($query) {
                $query->whereNotNull('watch_date');
            },
        ])->withAvg('reels as avg_rating', 'rating');
    }

    public function scopeWithReelReviewsCount($query)
    {
        return $query->withCount([
            'reels as reviews_count' => function ($query) {
                $query->whereHas('reviews');
            },
        ]);
    }

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
            'reels' => function ($query) {
                $query->with('reviews')
                    ->withCount('reviews');
            },
            'reels.user:id,username', // Add if needed for displaying review authors
        ])->withReelStats()
            ->withReelReviewsCount();
    }


    public function url(): string
    {
        return route('movies.show', $this);
    }

    public function cast(): MorphMany
    {
        return $this->morphMany(Cast::class, 'castable');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function watchlists(): MorphMany
    {
        return $this->morphMany(Watchlist::class, 'watchlistable');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(MovieGenre::class);
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function getRating(?User $user = null): ?float
    {
        return $this->getReel($user)?->rating;
    }

    public function getReel(?User $user = null): ?Reel
    {
        $user ??= auth()->user();

        return $this->reels()->where('user_id', $user->id)->first();
    }

    public function reels(): MorphMany
    {
        return $this->morphMany(Reel::class, 'reelable');
    }

    public function isLiked(?User $user = null): bool
    {
        return (bool) $this->getReel($user)?->is_liked;
    }

    public function isWatched(?User $user = null): bool
    {
        return $this->getReel($user)?->watch_date !== null;
    }


    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'runtime' => 'integer',
        ];
    }
}
