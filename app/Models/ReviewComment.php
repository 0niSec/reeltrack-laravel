<?php

namespace App\Models;

use App\Traits\HasLikeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReviewComment extends Model
{
    use HasLikeable;

    protected $fillable = [
        'content',
        'user_id',
        'review_id',
    ];

    protected $with = ['user', 'review', 'replies'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ReviewComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ReviewComment::class, 'parent_id')->orderBy('created_at', 'asc');
    }
}
