<?php

use App\Models\TvSeriesSeason;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tv_series_episodes', function (Blueprint $table) {
            $table->id();
            $table->string('air_date');
            $table->integer('episode_number');
            $table->string('name');
            $table->text('overview')->nullable();
            $table->unsignedBigInteger('tmdb_id');
            $table->integer('season_number');
            $table->string('still_path')->nullable();
            $table->integer('runtime');
            $table->foreignIdFor(TvSeriesSeason::class)->constrained('tv_series_seasons')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tv_series_episodes');
    }
};
