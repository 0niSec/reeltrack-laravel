<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('backdrop_path');
            $table->string('poster_path');
            $table->string('overview');
            $table->string('tagline');
            $table->integer('runtime');
            $table->bigInteger('tmdb_id');
            $table->string('release_date');
            $table->bigInteger('ratings_count');
            $table->decimal('rating_average');
            $table->bigInteger('total_reviews');
            $table->bigInteger('total_ratings');
            $table->bigInteger('total_likes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
