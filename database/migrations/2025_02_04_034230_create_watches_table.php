<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('watches', function (Blueprint $table) {
            $table->id();
            $table->date('watched_date')->nullable();
            $table->boolean('is_watched')->nullable();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('watchable_id');
            $table->string('watchable_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watches');
    }
};
