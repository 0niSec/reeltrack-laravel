<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('avatar')->nullable();
            $table->text('about')->nullable();
            $table->text('favorite_movies')->nullable();
            $table->text('favorite_shows')->nullable();
            $table->text('favorite_actors')->nullable();
            $table->json('rated_items')->nullable();
            $table->json('reviewed_items')->nullable();
            $table->json('liked_items')->nullable();
            $table->foreignIdFor(User::class)->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
