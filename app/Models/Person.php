<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    public function movieCastRoles(): HasMany
    {
        return $this->hasMany(MovieCastMember::class);
    }

    public function movieCrewRoles(): HasMany
    {
        return $this->hasMany(MovieCrewMember::class);
    }
}
