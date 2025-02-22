<?php

namespace App\Models;

use App\Observers\WatchlistObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ObservedBy([WatchlistObserver::class])]
class Watchlist extends Model
{
    public mixed $movie;
    protected $fillable = [
        'watchlistable_id',
        'watchlistable_type',
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
