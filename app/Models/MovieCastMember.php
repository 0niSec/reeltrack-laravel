<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieCastMember extends Model
{
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
