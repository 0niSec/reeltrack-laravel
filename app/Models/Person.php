<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $fillable = [
        'name',
        'tmdb_id',
        'biography',
        'profile_path',
        'birthday',
        'deathday',
        'place_of_birth',
        'gender',
    ];

    public function movieCastRoles(): HasMany
    {
        return $this->hasMany(MovieCastMember::class);
    }

    public function movieCrewRoles(): HasMany
    {
        return $this->hasMany(MovieCrewMember::class);
    }
}
