<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReelEntry extends Model
{
    protected $fillable = [
        'user_id',
        'reelable_id',
        'reelable_type',
        'watched_at',
        'is_rewatch',
        'contains_spoilers',
        'is_liked',
        'rating',
        'review_content',
    ];

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
            'contains_spoilers' => 'boolean',
        ];
    }
}
