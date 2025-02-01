<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patient_health_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');

            // Basic Health Info
            $table->enum('hpt_dm', ['HPT', 'DM', 'Internal fixation', 'Other'])->nullable();
            $table->text('hpt_other')->nullable();
            $table->text('pc')->nullable();
            $table->text('hpc')->nullable();
            $table->text('pmhx')->nullable();
            $table->text('shx')->nullable();
            $table->text('med')->nullable();
            $table->text('test_x_ray')->nullable();

            // Pain Assessment
            $table->string('pain_nature')->nullable();
            $table->string('degree_of_pain')->nullable();
            $table->unsignedTinyInteger('pain_scale')->nullable();
            $table->enum('pain_frequency', ['Constant', 'Periodic', 'Occasional'])->nullable();
            $table->string('aggravated_by')->nullable();
            $table->string('eased_by')->nullable();
            $table->enum('pain_period', ['Evening', 'Rising', 'Day pain'])->nullable();
            $table->enum('associated_symptoms', [
                'Dizziness',
                'Micturition',
                'Breathing',
                'Coughing/Sneezing'
            ])->nullable();
            
            // Disease Classification
            $table->enum('disease_type', [
                'shoulder',
                'hip',
                'spine',
                'stroke'
            ])->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_health_infos');
    }
};