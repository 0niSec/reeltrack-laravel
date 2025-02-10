<?php

namespace App\Models;

use App\Enums\Gender;
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

    protected function casts(): array
    {
        return [
            'birthday' => 'date',
            'deathday' => 'date',
            'gender' => Gender::class,
        ];
    }

}
