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
        'watch_date',
        'specific_year',
        'before_year',
        'is_rewatch',
        'rating',
        'is_liked',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reelable(): MorphTo
    {
        return $this->morphTo();
    }

    public function reviews(): HasOne
    {
        return $this->hasOne(Review::class);
    }


    // Query Scopes

    public function scopeForUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

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

    public function toggleLike(): void
    {
        $this->is_liked = !$this->is_liked;
        $this->save();
    }

    // Helper Methods

    public function markAsWatched(?string $date = null): void
    {
        $this->watch_date = $date ?? now();
        $this->save();
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
        $this->save();
    }

    public function createReview(array $attributes): Review
    {
        $review = new Review($attributes);
        $review->save();

        $this->review_id = $review->id;
        $this->save();

        return $review;
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
        ];
    }


}
