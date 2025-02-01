<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('limb_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained();

            $table->enum('limb_type', ['upper', 'lower']);
            $table->enum('muscle_tone', ['Spastic', 'Normal', 'Flaccid']);
            $table->enum('muscle_bulk', ['Normal', 'Atrophy', 'Hypertrophy']);
            $table->string('power');
            $table->string('deformity');
            $table->enum('hand_grip', ['Normal', 'Impaired', 'Lost'])->nullable(); // Only for upper

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limb_assessments');
    }
};
