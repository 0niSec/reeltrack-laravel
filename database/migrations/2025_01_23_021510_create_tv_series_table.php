<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tv_series', function (Blueprint $table) {
            $table->id();
            $table->string('backdrop_path');
            $table->json('created_by')->nullable();
            $table->json('episode_run_time');
            $table->string('first_air_date')->nullable();
            $table->json('genres');
            $table->bigInteger('tmdb_id');
            $table->boolean('in_production')->default(false);
            $table->json('languages')->nullable();
            $table->string('last_air_date')->nullable();
            $table->string('name');
            $table->integer('number_of_episodes')->nullable();
            $table->integer('number_of_seasons')->nullable();
            $table->json('origin_country')->nullable();
            $table->string('original_language')->nullable();
            $table->string('original_name')->nullable();
            $table->text('overview')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('status');
            $table->string('tagline')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tv_series');
    }
};
