<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserInteraction extends Model
{
    protected $fillable = [
        'user_id',
        'interactable_id',
        'interactable_type',
        'rating',
        'is_liked',
        'is_watched',
        'is_in_watchlist',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function interactable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'is_liked' => 'boolean',
            'is_watched' => 'boolean',
            'is_in_watchlist' => 'boolean',
        ];
    }
}
