<?php

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movie_likes', function (Blueprint $table) {
            $table->id();
            $table->boolean('liked')->default(false);
            $table->foreignIdFor(Movie::class)->constrained('movies')->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();

            $table->index('movie_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_likes');
    }
};
