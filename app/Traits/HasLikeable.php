<?php

namespace App\Traits;

use App\Models\ReviewLike;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikeable
{
    public function likes(): MorphMany
    {
        return $this->morphMany(ReviewLike::class, 'likeable');
    }

    public function like(): void
    {
        $this->likes()->create(['user_id' => auth()->user()->id]);
    }

    public function unlike(): void
    {
        $this->likes()->where('user_id', auth()->user()->id)->delete();
    }
}
