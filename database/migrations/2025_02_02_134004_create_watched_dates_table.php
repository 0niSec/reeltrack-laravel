<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('watched_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date_watched')->default(now());
            $table->foreignIdFor(User::class)->constrained('users');
            $table->unsignedBigInteger('watchable_id'); // ID of the movie or TV show reviewed
            $table->string('watchable_type'); // Movie or TV
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watched_dates');
    }
};
