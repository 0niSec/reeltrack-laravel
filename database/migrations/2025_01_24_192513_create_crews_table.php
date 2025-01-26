<?php

use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('crews', function (Blueprint $table) {
            $table->id();
            // Polymorphic columns
            $table->unsignedBigInteger('crewable_id');
            $table->string('crewable_type');

            // Typical Crew info
            $table->string('department');
            $table->string('job');
            $table->string('name');
            $table->foreignIdFor(Person::class)->constrained('people');

            // Index for faster polymorphic lookups
            $table->index(['crewable_id', 'crewable_type']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crews');
    }
};
