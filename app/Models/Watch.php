<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Watch extends Model
{
    protected $fillable = [
        'watched_date',
        'is_watched',
        'watchable_id',
        'watchable_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function watchable(): MorphTo
    {
        return $this->morphTo();
    }

    public function reel(): BelongsTo
    {
        return $this->belongsTo(Reel::class);
    }

    protected function casts(): array
    {
        return [
            'watched_date' => 'date',
            'is_watched' => 'boolean',
        ];
    }
}
