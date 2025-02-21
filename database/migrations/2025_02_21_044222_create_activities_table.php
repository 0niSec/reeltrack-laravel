<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->cascadeOnDelete();
            $table->morphs('subject'); // Creates subject_id & subject_type columns
            $table->string('event_type');
            $table->string('action');
            $table->json('metadata')->nullable(); // Flexible field for additional info

            // Indexes
            $table->index(['subject_id', 'subject_type']);
            $table->index('event_type');
            $table->index('created_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
