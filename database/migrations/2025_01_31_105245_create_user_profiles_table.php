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
            $table->string('nickname')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->enum('pronouns', ['He/him', 'He/their', 'She/her', 'She/their', 'They/their'])->nullable()
                ->default
                (null);
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('bluesky')->nullable();
            $table->text('bio')->nullable();
            $table->text('favorite_movies')->nullable();
            $table->text('favorite_shows')->nullable();
            $table->text('favorite_actors')->nullable();
            $table->json('rated_items')->nullable();
            $table->json('reviewed_items')->nullable();
            $table->json('liked_items')->nullable();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
