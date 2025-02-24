<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();

            $table->morphs('reelable');

            $table->date('watch_date')->nullable(); // Watches
            $table->year('specific_year')->nullable();
            $table->year('before_year')->nullable();
            $table->boolean('is_rewatch')->nullable();

            $table->decimal('rating', 3)->nullable(); // Rating

            $table->boolean('is_liked')->nullable(); // Like

            $table->index(['reelable_id', 'reelable_type']);
            $table->index(['reelable_type', 'reelable_id', 'user_id']);
            $table->index(['reelable_type', 'reelable_id', 'rating', 'user_id']);
            $table->index(['reelable_type', 'reelable_id', 'watch_date', 'user_id']);
            $table->index(['reelable_type', 'reelable_id', 'is_liked', 'user_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reels');
    }
};
