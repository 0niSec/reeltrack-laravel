<?php

namespace App\Models;

use App\Events\ReviewDeletingEvent;
use App\Traits\HasLikeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasLikeable;

    protected $fillable = [
        'content',
        'contains_spoilers',
        'user_id',
        'reel_entry_id',
        'reviewable_id',
        'reviewable_type',
    ];

    protected $dispatchesEvents = [
        'deleting' => ReviewDeletingEvent::class,
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

    public function comments(): HasMany
    {
        return $this->hasMany(ReviewComment::class)->whereNull('parent_id');
    }

    protected function casts(): array
    {
        return [
            'contains_spoilers' => 'boolean',
        ];
    }
}
