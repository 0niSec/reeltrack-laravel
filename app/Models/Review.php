<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    protected $fillable = [
        'content',
        'contains_spoilers',
        'user_id',
        'reel_entry_id',
        'reviewable_id',
        'reviewable_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reelEntry(): BelongsTo
    {
        return $this->belongsTo(ReelEntry::class);
    }

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(ReviewLike::class, 'review_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ReviewComment::class)->whereNull('parent_id')->latest();
    }

    protected function casts(): array
    {
        return [
            'contains_spoilers' => 'boolean',
        ];
    }
}
