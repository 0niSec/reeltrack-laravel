<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Cast extends Model
{

    protected $fillable = [
        'character',
        'castable_id',
        'castable_type',
        'name',
        'gender',
        'profile_path',
        'order',
        'person_id',
    ];

    public function castable(): MorphTo
    {
        return $this->morphTo();
    }

    // Quick way to link to Person model
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
