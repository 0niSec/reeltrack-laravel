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
            $table->foreignIdFor(User::class)->constrained('users');
            $table->unsignedBigInteger('likeable_id'); // ID of the movie or TV show reviewed
            $table->string('likeable_type'); // Movie or TV
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
