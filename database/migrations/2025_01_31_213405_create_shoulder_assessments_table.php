<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shoulder_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_health_info_id')->constrained()->onDelete('cascade');
            
            // General Section
            $table->text('observation')->nullable();
            $table->text('limitations')->nullable();
            $table->enum('is_lie_affected_side', ['Yes', 'No'])->nullable();
            $table->text('vegetative_changes')->nullable();

            // Special Tests and Assessments (already text)
            $table->text('accessory_movements')->nullable();
            $table->text('finger_movements')->nullable();
            $table->text('muscle_power')->nullable();
            $table->text('horizontal_abduction')->nullable();
            $table->text('impingement_test')->nullable();
            $table->text('supraspinatus')->nullable();
            
            // Enum columns remain unchanged
            $table->enum('speed', ['R', 'L'])->nullable();
            $table->enum('ligamentus', ['R', 'L'])->nullable();
            $table->enum('foment', ['R', 'L'])->nullable();
            $table->enum('allen', ['R', 'L'])->nullable();

            // Other text fields
            $table->text('distraction')->nullable();
            $table->text('reflexes')->nullable();
            $table->text('palpation')->nullable();
            $table->text('sensation')->nullable();
            $table->text('other_comments')->nullable();

            // Signs
            $table->text('sulcus')->nullable();
            $table->text('ok')->nullable();
            $table->text('tinel')->nullable();

            // Treatment
            $table->text('rx_goals')->nullable();
            $table->text('rx')->nullable();
            $table->text('adl')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shoulder_assessments');
    }
};