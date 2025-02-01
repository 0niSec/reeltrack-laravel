<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    

    protected function casts(): array
    {
        return [
            'avatar' => 'string',
            'rated_items' => 'array',
            'reviewed_items' => 'array',
            'liked_items' => 'array',
        ];
    }
}
