<?php

namespace App\Models;

use App\Contracts\Watchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TvSeries extends Model
{
    protected $fillable = [
        'backdrop_path',
        'created_by',
        'episode_run_time',
        'first_air_date',
        'genres',
        'tmdb_id',
        'in_production',
        'languages',
        'last_air_date',
        'name',
        'number_of_episodes',
        'number_of_seasons',
        'origin_country',
        'original_language',
        'original_name',
        'overview',
        'poster_path',
        'status',
        'tagline',
    ];

    public function cast(): MorphMany
    {
        $this->morphMany(Cast::class, 'castable');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
    }

    public function tvSeriesEpisodes(): HasManyThrough
    {
        return $this->hasManyThrough(TvSeriesEpisode::class, TvSeriesSeason::class, 'tv_series_id', 'season_id');
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

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

}
