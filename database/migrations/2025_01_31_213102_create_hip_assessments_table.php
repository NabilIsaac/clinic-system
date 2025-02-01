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
            
            // Posture and Basic Measurements
            $table->text('observation')->nullable();
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

            // Range of Motion - Right Hip
            $table->string('flex_arom')->nullable();
            $table->string('flex_prom')->nullable();
            $table->string('flex_end_feel')->nullable();
            $table->string('ext_arom')->nullable();
            $table->string('ext_prom')->nullable();
            $table->string('ext_end_feel')->nullable();
            $table->string('abd_arom')->nullable();
            $table->string('abd_prom')->nullable();
            $table->string('abd_end_feel')->nullable();
            $table->string('add_arom')->nullable();
            $table->string('add_prom')->nullable();
            $table->string('add_end_feel')->nullable();
            $table->string('ir_arom')->nullable();
            $table->string('ir_prom')->nullable();
            $table->string('ir_end_feel')->nullable();
            $table->string('er_arom')->nullable();
            $table->string('er_prom')->nullable();
            $table->string('er_end_feel')->nullable();

            // Range of Motion - Left Hip
            $table->string('flex_aroml')->nullable();
            $table->string('flex_proml')->nullable();
            $table->string('flex_end_feell')->nullable();
            $table->string('ext_aroml')->nullable();
            $table->string('ext_proml')->nullable();
            $table->string('ext_end_feell')->nullable();
            $table->string('abd_aroml')->nullable();
            $table->string('abd_proml')->nullable();
            $table->string('abd_end_feell')->nullable();
            $table->string('add_aroml')->nullable();
            $table->string('add_proml')->nullable();
            $table->string('add_end_feell')->nullable();
            $table->string('ir_aroml')->nullable();
            $table->string('ir_proml')->nullable();
            $table->string('ir_end_feell')->nullable();
            $table->string('er_aroml')->nullable();
            $table->string('er_proml')->nullable();
            $table->string('er_end_feell')->nullable();

            // Muscle Flexibility
            $table->enum('muscle_flexibility', [
                'Iliopsoas',
                'Rectus femoris',
                "Obers",
                'Hamstrings',
                'Adductors',
                'Gluteus medius',
                'Piriformis',
                'Gastrocnemius',
                'Soleus'
            ])->nullable();

            // Functional Tests
            $table->enum('functional_test', ['Stairs', 'Squat', 'Running'])->nullable();

            // Special Tests
            $table->enum('zero', ['right', 'left'])->nullable();
            $table->enum('thirty', ['right', 'left'])->nullable();
            $table->enum('ant_drawer', ['R', 'L'])->nullable();
            $table->enum('post_drawer', ['R', 'L'])->nullable();
            $table->enum('lachman', ['R', 'L'])->nullable();
            $table->enum('mcmurray', ['R', 'L'])->nullable();
            $table->enum('apley_commpression', ['R', 'L'])->nullable();
            $table->enum('traction', ['R', 'L'])->nullable();
            $table->enum('pivot_shift', ['R', 'L'])->nullable();
            $table->enum('kleiger', ['R', 'L'])->nullable();

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