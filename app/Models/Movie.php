<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function cast(): MorphMany
    {
        return $this->morphMany(Cast::class, 'castable');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
    }

    public function rateable(): MorphMany
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function reviewable(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function likeable(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(MovieGenre::class);
    }

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'runtime' => 'integer',
        ];
    }
}
