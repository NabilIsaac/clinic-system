<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stroke_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_health_info_id')->constrained()->onDelete('cascade');
            
            // Basic stroke information
            $table->date('date_of_onset_of_stroke');
            $table->date('date_of_seeing_pratitioner');
            $table->date('date_of_admission');
            $table->enum('side_of_affectation', ['Right Hemi', 'Left Hemi']);
            $table->enum('first_course_of_treatment', ['Home care', 'Herbal treatment', 'Orthodox treatment']);
            
            // Risk factors and complications
            $table->enum('associated_risk_factors_of_patient', [
                'Obesity', 'Hypertension', 'Diabetes', 'Smoking', 'Alcoholic', 'Genetic'
            ]);
            $table->string('risk_factors_of_patient')->nullable(); // For "Other" option
            $table->enum('associated_complication', [
                'Aphasia', 'Dysphasia', 'Facial pals', 'Dysarthria'
            ]);
            
            // Medical history
            $table->text('current_medication')->nullable();
            $table->text('drug_history')->nullable();
            
            // Patient condition
            $table->enum('skin_condition', ['Rashes', 'Unkempt', 'Bedsores']);
            $table->string('skin_condition_other')->nullable(); // For "Other" option
            $table->enum('mental_state_of_patient', [
                'depression', 'lethargy', 'irritability', 'aggression',
                'cheerful', 'weeping', 'elation/ excited'
            ]);
            $table->string('glasgow_coma_score');
            
            // Reflexes and Sensory Functions
            $table->enum('knee_jerk', ['Hyporeflexia', 'Normal', 'Hyper reflexia']);
            $table->enum('biceps', ['Hyporeflexia', 'Normal', 'Hyper reflexia']);
            $table->enum('spot_test', ['Normal', 'Impaired', 'Lost']);
            $table->enum('temperature', ['Normal', 'Impaired', 'Lost']);
            $table->enum('touch', ['Normal', 'Impaired', 'Lost']);
            $table->enum('colour_distinction', ['Normal', 'Impaired', 'Lost']);
            
            // Communication
            $table->enum('language_comprehension', ['Normal', 'Impaired', 'Lost']);
            $table->enum('speech', ['Normal', 'Impaired', 'Lost']);
            $table->enum('impaired_speech', ['Slow', 'Slurred', 'Inauible', 'Incoherent', 'Irritional']);
            $table->enum('reading_memory', ['Normal', 'Impaired', 'Lost']);
            $table->enum('writing_memory', ['Normal', 'Impaired', 'Lost']);
            
            // Treatment and Goals
            $table->text('rx_goals')->nullable();
            $table->text('rx')->nullable();
            $table->text('adl')->nullable();
            $table->text('bps')->nullable();
            
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stroke_assessments');
    }
};