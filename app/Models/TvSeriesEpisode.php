<?php

namespace App\Models;

use App\Contracts\Watchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TvSeriesEpisode extends Model implements Watchable
{

    protected $fillable = [
        'air_date',
        'episode_number',
        'name',
        'overview',
        'tmdb_id',
        'season_number',
        'still_path',
        'runtime',
        'tv_series_season_id',
    ];

    public function cast(): MorphMany
    {
        $this->morphMany(Cast::class, 'castable');
    }

    public function crew(): MorphMany
    {
        return $this->morphMany(Crew::class, 'crewable');
    }

    public function tvSeriesSeason(): BelongsTo
    {
        return $this->belongsTo(TvSeriesSeason::class);
    }

    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function getTitle(): string
    {
        return $this->name;
    }

    public function getId(): int|string
    {
        return $this->id;
    }
}
