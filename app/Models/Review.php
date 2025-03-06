<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'content',
        'contains_spoilers',
        'user_id',
        'reel_entry_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reelEntry(): BelongsTo
    {
        return $this->belongsTo(ReelEntry::class);
    }

    protected function casts(): array
    {
        return [
            'contains_spoilers' => 'boolean',
        ];
    }
}
