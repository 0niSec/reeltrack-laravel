<?php

use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movie_crew_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('tmdb_id');
            $table->string('job');
            $table->string('department');
            $table->string('profile_path')->nullable();
            $table->foreignIdFor(Movie::class)->constrained('movies');
            $table->foreignIdFor(Person::class)->constrained('people');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_crew_members');
    }
};
