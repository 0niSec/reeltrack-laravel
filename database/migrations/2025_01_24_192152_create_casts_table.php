<?php

use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('casts', function (Blueprint $table) {
            $table->id();
            
            // Polymorphic columns
            $table->unsignedBigInteger('castable_id');
            $table->string('castable_type');

            // Standard Cast Info
            $table->string('name');
            $table->string('character');
            $table->integer('order');

            // Foreign Key constraints
            $table->foreignIdFor(Person::class)->constrained('people');

            // Indexes for polymorphic lookup
            $table->index(['castable_id', 'castable_type']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('casts');
    }
};
