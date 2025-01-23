<?php

namespace App\Http\Controllers;

use App\Models\TvSeries;
use Illuminate\Http\Request;

class TvSeriesController extends Controller
{
    public function index()
    {
        return TvSeries::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'backdrop_path' => ['required'],
            'created_by' => ['required'],
            'episode_run_time' => ['required'],
            'first_air_date' => ['required'],
            'genres' => ['required'],
            'tmdb_id' => ['required', 'integer'],
            'in_production' => ['boolean'],
            'languages' => ['required'],
            'last_air_date' => ['nullable'],
            'name' => ['required'],
            'number_of_episodes' => ['required', 'integer'],
            'number_of_seasons' => ['required', 'integer'],
            'origin_country' => ['required'],
            'original_language' => ['required'],
            'original_name' => ['required'],
            'overview' => ['nullable'],
            'poster_path' => ['required'],
            'seasons' => ['required'],
            'status' => ['required'],
            'tagline' => ['nullable'],
        ]);

        return TvSeries::create($data);
    }

    public function show(TvSeries $tvSeries)
    {
        return $tvSeries;
    }

    public function update(Request $request, TvSeries $tvSeries)
    {
        $data = $request->validate([
            'backdrop_path' => ['required'],
            'created_by' => ['required'],
            'episode_run_time' => ['required'],
            'first_air_date' => ['required'],
            'genres' => ['required'],
            'tmdb_id' => ['required', 'integer'],
            'in_production' => ['boolean'],
            'languages' => ['required'],
            'last_air_date' => ['nullable'],
            'name' => ['required'],
            'number_of_episodes' => ['required', 'integer'],
            'number_of_seasons' => ['required', 'integer'],
            'origin_country' => ['required'],
            'original_language' => ['required'],
            'original_name' => ['required'],
            'overview' => ['nullable'],
            'poster_path' => ['required'],
            'seasons' => ['required'],
            'status' => ['required'],
            'tagline' => ['nullable'],
        ]);

        $tvSeries->update($data);

        return $tvSeries;
    }

    public function destroy(TvSeries $tvSeries)
    {
        $tvSeries->delete();

        return response()->json();
    }
}
