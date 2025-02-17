<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'avatar',
        'about',
        'nickname',
        'website',
        'location',
        'pronouns',
        'twitter',
        'instagram',
        'facebook',
        'youtube',
        'tiktok',
        'bluesky',
        'bio',
        'favorite_movies',
        'favorite_shows',
        'favorite_actors',
        'rated_items',
        'reviewed_items',
        'liked_items',
        'user_id',
    ];

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
