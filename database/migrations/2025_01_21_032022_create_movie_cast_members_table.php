<?php

use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('movie_cast_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('character');
            $table->integer('gender');
            $table->string('profile_path')->nullable();
            $table->integer('order');
            $table->foreignIdFor(Movie::class)->constrained('movies');
            $table->foreignIdFor(Person::class)->constrained('people');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_cast_members');
    }
};
