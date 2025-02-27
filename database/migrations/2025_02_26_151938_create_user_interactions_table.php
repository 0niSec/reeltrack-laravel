<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->morphs('interactable');
            $table->decimal('rating')->nullable();
            $table->boolean('is_liked')->default(false);
            $table->boolean('is_watched')->default(false);
            $table->boolean('is_in_watchlist')->default(false);

            $table->index([
                'user_id', 'interactable_id', 'interactable_type', 'is_liked', 'is_watched', 'is_in_watchlist',
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_interactions');
    }
};
