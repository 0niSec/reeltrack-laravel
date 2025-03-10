<?php

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('review_comments', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignIdFor(User::class)->constrained('users');
            $table->foreignIdFor(Review::class)->constrained('reviews');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_comments');
    }
};
