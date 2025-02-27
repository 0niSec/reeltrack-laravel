<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'watched',
        'watch_date',
        'is_rewatch',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reelable(): MorphTo
    {
        return $this->morphTo();
    }

    public function like(): HasOne
    {
        return $this->hasOne(Like::class, 'reel_id');
    }

    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class, 'reel_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function scopeForUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }


    // Query Scopes

    public function scopeLiked(Builder $query): Builder
    {
        return $query->where('is_liked', true);
    }

    public function scopeRated(Builder $query): Builder
    {
        return $query->whereNotNull('rating');
    }

    public function scopeWatched(Builder $query): Builder
    {
        return $query->whereNotNull('watch_date');
    }

    public function scopeReviewed(Builder $query): Builder
    {
        return $query->whereNotNull('review_id');
    }

    protected function casts(): array
    {
        return [
            'watch_date' => 'date',
            'specific_year' => 'integer',
            'before_year' => 'integer',
            'rating' => 'decimal:1',
            'is_liked' => 'boolean',
            'is_rewatch' => 'boolean',
            'watched' => 'boolean',
        ];
    }
}
