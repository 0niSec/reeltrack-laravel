<?php

use App\Models\ReelEntry;
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
            $table->boolean('contains_spoilers');
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(ReelEntry::class)->constrained('reel_entries')->cascadeOnDelete();
            $table->morphs('reviewable');
            $table->index(['user_id', 'reel_entry_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
