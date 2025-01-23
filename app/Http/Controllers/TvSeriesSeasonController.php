<?php

namespace App\Http\Controllers;

use App\Models\TvSeriesSeason;
use Illuminate\Http\Request;

class TvSeriesSeasonController extends Controller
{
    public function index()
    {
        return TvSeriesSeason::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tv_series_id' => ['required', 'exists:tv_series'],
            'tmdb_id' => ['required', 'integer'],
            'air_date' => ['required'],
            'name' => ['required'],
            'overview' => ['nullable'],
            'poster_path' => ['nullable'],
            'season_number' => ['required'],
        ]);

        return TvSeriesSeason::create($data);
    }

    public function show(TvSeriesSeason $tvSeriesSeason)
    {
        return $tvSeriesSeason;
    }

    public function update(Request $request, TvSeriesSeason $tvSeriesSeason)
    {
        $data = $request->validate([
            'tv_series_id' => ['required', 'exists:tv_series'],
            'tmdb_id' => ['required', 'integer'],
            'air_date' => ['required'],
            'name' => ['required'],
            'overview' => ['nullable'],
            'poster_path' => ['nullable'],
            'season_number' => ['required'],
        ]);

        $tvSeriesSeason->update($data);

        return $tvSeriesSeason;
    }

    public function destroy(TvSeriesSeason $tvSeriesSeason)
    {
        $tvSeriesSeason->delete();

        return response()->json();
    }
}
