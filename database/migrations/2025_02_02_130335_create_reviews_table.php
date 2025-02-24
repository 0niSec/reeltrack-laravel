<?php

use App\Models\Reel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Reel::class)->constrained('reels')->cascadeOnDelete();

            $table->morphs('reviewable');

            $table->text('content');

            $table->boolean('contains_spoilers')->default(false);

            $table->index(['reviewable_id', 'reviewable_type']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
