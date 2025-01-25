<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Movie extends Model
{
    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'runtime' => 'integer',
        ];
    }

    protected $fillable = [
        'title',
        'release_date',
        'runtime',
        'description',
        'poster_path',
        'backdrop_path',
        'trailer_path',
        'imdb_id',
        'tmdb_id',
    ];

    public function cast(): MorphMany
    {
        return $this->morphMany(Cast::class, 'castable');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(MovieReview::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(MovieRating::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(MovieLike::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(MovieGenre::class);
    }
}
