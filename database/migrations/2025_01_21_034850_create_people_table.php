<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('tmdb_id');
            $table->text('biography')->nullable();
            $table->string('profile_path');
            $table->string('birthday');
            $table->string('deathday')->nullable();
            $table->string('place_of_birth');
            $table->integer('gender');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
