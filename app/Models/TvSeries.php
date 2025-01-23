<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TvSeries extends Model
{
    protected function casts(): array
    {
        return [
            'created_by' => 'array',
            'episode_run_time' => 'array',
            'genres' => 'array',
            'in_production' => 'boolean',
            'languages' => 'array',
            'origin_country' => 'array',
            'seasons' => 'array',
        ];
    }

    public function tvSeriesSeasons(): HasMany
    {
        return $this->hasMany(TvSeriesSeason::class, 'tv_series_id');
    }

    public function tvSeriesEpisodes(): HasManyThrough
    {
        return $this->hasManyThrough(TvSeriesEpisode::class, TvSeriesSeason::class, 'tv_series_id', 'season_id');
    }
}
