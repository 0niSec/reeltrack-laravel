<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->boolean('status');
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('likeable_id'); // ID of the movie or TV show reviewed
            $table->string('likeable_type'); // Movie or TV
            $table->index(['likeable_id', 'likeable_type', 'user_id', 'status']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
