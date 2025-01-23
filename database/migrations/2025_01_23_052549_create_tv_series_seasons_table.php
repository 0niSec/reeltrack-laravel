<?php

use App\Models\TvSeries;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tv_series_seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TvSeries::class)->constrained('tv_series')->cascadeOnDelete();
            $table->bigInteger('tmdb_id');
            $table->string('air_date');
            $table->string('name');
            $table->text('overview')->nullable();
            $table->string('poster_path')->nullable();
            $table->integer('season_number')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tv_series_seasons');
    }
};
