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
            $table->string('backdrop_path')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('overview');
            $table->string('tagline');
            $table->integer('runtime');
            $table->unsignedBigInteger('tmdb_id');
            $table->string('release_date');
            $table->unsignedBigInteger('ratings_count')->default(0);
            $table->decimal('rating_average', 3)->default(0);
            $table->unsignedBigInteger('total_reviews')->default(0);
            $table->unsignedBigInteger('total_ratings')->default(0);
            $table->unsignedBigInteger('total_likes')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
