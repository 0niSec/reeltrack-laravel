<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
