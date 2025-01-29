<?php

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movie_reviews', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignIdFor(Movie::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

            $table->index('movie_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_reviews');
    }
};
