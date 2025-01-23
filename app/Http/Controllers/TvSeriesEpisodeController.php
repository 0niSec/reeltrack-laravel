<?php

namespace App\Http\Controllers;

use App\Models\TvSeriesEpisode;
use Illuminate\Http\Request;

class TvSeriesEpisodeController extends Controller
{
    public function index()
    {
        return TvSeriesEpisode::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'air_date' => ['required'],
            'episode_number' => ['required', 'integer'],
            'name' => ['required'],
            'overview' => ['nullable'],
            'tmdb_id' => ['required', 'integer'],
            'season_number' => ['required', 'integer'],
            'still_path' => ['nullable'],
            'runtime' => ['required', 'integer'],
            'tv_series_season_id' => ['required', 'exists:tv_series_seasons'],
        ]);

        return TvSeriesEpisode::create($data);
    }

    public function show(TvSeriesEpisode $tvSeriesEpisode)
    {
        return $tvSeriesEpisode;
    }

    public function update(Request $request, TvSeriesEpisode $tvSeriesEpisode)
    {
        $data = $request->validate([
            'air_date' => ['required'],
            'episode_number' => ['required', 'integer'],
            'name' => ['required'],
            'overview' => ['nullable'],
            'tmdb_id' => ['required', 'integer'],
            'season_number' => ['required', 'integer'],
            'still_path' => ['nullable'],
            'runtime' => ['required', 'integer'],
            'tv_series_season_id' => ['required', 'exists:tv_series_seasons'],
        ]);

        $tvSeriesEpisode->update($data);

        return $tvSeriesEpisode;
    }

    public function destroy(TvSeriesEpisode $tvSeriesEpisode)
    {
        $tvSeriesEpisode->delete();

        return response()->json();
    }
}
