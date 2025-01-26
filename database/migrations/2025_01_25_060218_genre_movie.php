<?php

use App\Models\Movie;
use App\Models\MovieGenre;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movie_movie_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Movie::class)->constrained('movies')->cascadeOnDelete();
            $table->foreignIdFor(MovieGenre::class)->constrained('movie_genres')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_movie_genre');
    }
};
