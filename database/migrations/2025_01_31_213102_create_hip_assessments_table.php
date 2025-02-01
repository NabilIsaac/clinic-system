<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hip_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_health_info_id')->constrained()->onDelete('cascade');
            
            // Posture and Basic Measurements
            $table->text('gait')->nullable();
            $table->text('vegetative_changes')->nullable();
            $table->enum('coxa', ['Vara', 'Valga'])->nullable();
            $table->enum('genu', ['Varus', 'Valgus'])->nullable();
            
            // Leg Measurements
            $table->string('right_leg')->nullable();
            $table->string('left_leg')->nullable();
            $table->string('right_circumference')->nullable();
            $table->string('left_circumference')->nullable();
            $table->string('aids')->nullable();
            $table->string('footwear')->nullable();

             // Muscle Flexibility
            $table->json('muscle_flexibility')->nullable(); // Store multiple selections
            
            // Special Tests
            $table->json('special_tests')->nullable(); // Store test results

            // Functional Tests
            $table->enum('functional_test', ['Stairs', 'Squat', 'Running'])->nullable();
            $table->text('stairs_notes')->nullable();
            $table->text('running_notes')->nullable();
            $table->text('squat_notes')->nullable();

            // Muscle Flexibility
            // $table->enum('muscle_flexibility', [
            //     'Iliopsoas',
            //     'Rectus femoris',
            //     "Obers",
            //     'Hamstrings',
            //     'Adductors',
            //     'Gluteus medius',
            //     'Piriformis',
            //     'Gastrocnemius',
            //     'Soleus'
            // ])->nullable(); 

            // Special Tests
            // $table->enum('zero', ['right', 'left'])->nullable();
            // $table->enum('thirty', ['right', 'left'])->nullable();
            // $table->enum('ant_drawer', ['R', 'L'])->nullable();
            // $table->enum('post_drawer', ['R', 'L'])->nullable();
            // $table->enum('lachman', ['R', 'L'])->nullable();
            // $table->enum('mcmurray', ['R', 'L'])->nullable();
            // $table->enum('apley_commpression', ['R', 'L'])->nullable();
            // $table->enum('traction', ['R', 'L'])->nullable();
            // $table->enum('pivot_shift', ['R', 'L'])->nullable();
            // $table->enum('kleiger', ['R', 'L'])->nullable();

            // Additional Tests and Observations
            $table->string('faber')->nullable();
            $table->string('trendelenberg')->nullable();
            $table->string('reflexes')->nullable();
            $table->text('palpation')->nullable();
            $table->text('sentation')->nullable();
            $table->text('other_comments')->nullable();
            
            // Treatment and Goals
            $table->text('rx_goals')->nullable();
            $table->text('rx')->nullable();
            $table->text('adl')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hip_assessments');
    }
};