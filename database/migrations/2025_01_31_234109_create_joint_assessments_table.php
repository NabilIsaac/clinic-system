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
        Schema::create('joint_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('limb_assessment_id')->constrained();
            
            $table->enum('joint_type', [
                // Upper limb joints
                'shoulder', 'elbow', 'wrist', 'fingers', 'hand',
                // Lower limb joints
                'hip', 'knee', 'ankle', 'foot', 'toes'
            ]);
            
            $table->enum('status', [
                'Contracture', 
                'Stiff', 
                'Flexible', 
                'Active movements'
            ]);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joint_assessments');
    }
};
