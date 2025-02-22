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

    public function scopePopular(Builder $query): void
    {
        $query->withCount([
            'likes' => function ($query) {
                $query->where('status', true);
            },
        ])
            ->orderBy('likes_count', 'desc')
            ->take(5);
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

    public function scopeWithStats(Builder $query): void
    {
        $query->withCount([
            'likes'
            => fn($query) => $query
                ->where('status', true),
            'ratings',
            'reviews',
            'watches',

        ]);
    }

    public function url(): string
    {
        return route('movies.show', $this);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function cast(): MorphMany
    {
        return $this->morphMany(Cast::class, 'castable');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function watches(): MorphMany
    {
        return $this->morphMany(Watch::class, 'watchable');
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


    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'runtime' => 'integer',
        ];
    }
}
