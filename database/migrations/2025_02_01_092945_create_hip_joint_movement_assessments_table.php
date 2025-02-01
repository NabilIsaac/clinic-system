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
        Schema::create('hip_joint_movement_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hip_assessment_id')->constrained()->onDelete('cascade');
            $table->enum('joint', ['hip', 'knee'])->nullable();
            $table->enum('movement', [
                'flexion',
                'extension',
                'abduction',
                'adduction',
                'internal_rotation',
                'external_rotation'
            ])->nullable();
            
            // Right Side Measurements
            $table->integer('r_arom')->nullable(); // Active Range of Motion
            $table->integer('r_prom')->nullable(); // Passive Range of Motion
            $table->enum('r_end_feel', [
                'normal',
                'firm',
                'soft',
                'empty',
                'spasm'
            ])->nullable();
            
            // Left Side Measurements
            $table->integer('l_arom')->nullable();
            $table->integer('l_prom')->nullable();
            $table->enum('l_end_feel', [
                'normal',
                'firm',
                'soft',
                'empty',
                'spasm'
            ])->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hip_joint_movement_assessments');
    }
};
