<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TvSeriesSeason extends Model
{
    protected $fillable = [
        'tv_series_id', 'season_number', 'episode_count', 'air_date', 'name', 'poster_path', 'overview', 'tmdb_id'
    ];

    protected function casts(): array
    {
        return [
            'air_date' => 'date',
        ];
    }

    public function tvSeries(): BelongsTo
    {
        return $this->belongsTo(TvSeries::class);
    }

    public function tvSeriesEpisodes(): HasMany
    {
        return $this->hasMany(TvSeriesEpisode::class, 'tv_series_season_id');
    }
}
