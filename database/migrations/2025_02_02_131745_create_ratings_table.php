<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->decimal('score')->nullable();
            $table->foreignIdFor(User::class)->constrained('users');
            $table->unsignedBigInteger('rateable_id'); // ID of the movie or TV show reviewed
            $table->string('rateable_type'); // Movie or TV
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
