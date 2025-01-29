<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MovieGenre extends Model
{
    protected $fillable = ['name', 'tmdb_id'];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
