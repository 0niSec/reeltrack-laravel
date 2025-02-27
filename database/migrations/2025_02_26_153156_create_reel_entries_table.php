<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reel_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users');
            $table->morphs('reelable');

            $table->date('watched_at');

            $table->boolean('is_rewatch')->default(false);
            $table->boolean('contains_spoilers')->default(false);
            $table->boolean('is_liked')->default(false);

            $table->decimal('rating')->nullable();

            $table->text('review_content')->nullable();

            $table->index(['user_id', 'is_liked', 'watched_at', 'rating', 'reelable_id', 'reelable_type']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reel_entries');
    }
};
