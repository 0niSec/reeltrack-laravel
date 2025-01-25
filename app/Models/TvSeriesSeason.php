<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TvSeriesSeason extends Model
{
    protected $fillable = [
        'tv_series_id',
        'tmdb_id',
        'air_date',
        'name',
        'overview',
        'poster_path',
        'season_number',
    ];

    protected function casts(): array
    {
        return [
            'air_date' => 'date',
        ];
    }

    public function cast(): MorphMany
    {
        $this->morphMany(Cast::class, 'castable');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
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
