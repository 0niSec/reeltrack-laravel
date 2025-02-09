<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Watchlist extends Model
{
    protected $fillable = [
        'watchlistable_id',
        'watchlistable_typr',
        'is_watchlisted',
        'user_id',
    ];

    public function watchlistable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'is_watchlisted' => 'boolean',
        ];
    }
}
