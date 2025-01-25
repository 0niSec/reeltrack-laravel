<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Crew extends Model
{

    protected $fillable = [
        'crewable_id',
        'crewable_type',
        'department',
        'job',
        'profile_path',
        'name',
        'person_id',
    ];

    public function crewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
