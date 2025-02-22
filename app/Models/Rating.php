<?php

namespace App\Models;

use App\Observers\RatingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ObservedBy(RatingObserver::class)]
class Rating extends Model
{

    protected $fillable = [
        'rating',
        'user_id',
        'reel_id',
        'rateable_id',
        'rateable_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }

    public function reel(): BelongsTo
    {
        return $this->belongsTo(Reel::class);
    }
}
