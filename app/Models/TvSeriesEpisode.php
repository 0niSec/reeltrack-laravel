<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TvSeriesEpisode extends Model
{
    public function tvSeriesSeason(): BelongsTo
    {
        return $this->belongsTo(TvSeriesSeason::class);
    }
}
