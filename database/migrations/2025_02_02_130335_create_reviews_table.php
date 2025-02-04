<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('reel_id')->nullable(); // Optional Reel ID
            $table->unsignedBigInteger('reviewable_id'); // ID of the movie or TV show reviewed
            $table->string('reviewable_type'); // Movie or TV


            $table->index(['reviewable_id', 'reviewable_type']);
            $table->index(['reviewable_type', 'reviewable_id', 'user_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
