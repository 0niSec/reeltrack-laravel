<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Movie extends Model
{
    public function castMembers(): HasManyThrough
    {
        return $this->hasManyThrough(Person::class, MovieCastMember::class);
    }

    public function crewMembers(): HasManyThrough
    {
        return $this->hasManyThrough(Person::class, MovieCrewMember::class);
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
