<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReelEntry extends Model
{

    protected $fillable = [
        'user_id',
        'reelable_id',
        'reelable_type',
        'watched_at',
        'is_rewatch',
        'is_liked',
        'rating',
    ];

    protected $casts = [
        'is_liked' => 'boolean',
        'is_rewatch' => 'boolean',
        'rating' => 'float',
    ];

// Helpers

    /**
     * Determines if the entity has associated reviews.
     *
     * @return bool
     */
    public function hasReviews(): bool
    {
        return $this->reviews()->exists();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reel_entry_id');
    }

// End Helpers


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reelable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'watched_at' => 'date',
            'is_rewatch' => 'boolean',
            'is_liked' => 'boolean',
        ];
    }
}
