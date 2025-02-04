<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reel extends Model
{
    protected $fillable = [
        'user_id',
        'reelable_id',
        'reelable_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reelable(): MorphTo
    {
        return $this->morphTo();
    }

    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class, 'reel_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class, 'reel_id');
    }

    public function like(): HasOne
    {
        return $this->hasOne(Like::class, 'reel_id');
    }

    public function watch(): HasOne
    {
        return $this->hasOne(Watch::class, 'reel_id');
    }
}
