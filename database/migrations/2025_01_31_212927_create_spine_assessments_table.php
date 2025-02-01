<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spine_assessments', function (Blueprint $table) {
            $table->id();
            // Posture section
            $table->text('gait')->nullable();
            $table->text('vegetative_changes')->nullable();
            $table->enum('sitting', ['Good', 'Fair', 'Poor'])->nullable();
            $table->enum('standing', ['Good', 'Fair', 'Poor'])->nullable();
            $table->enum('lordosis', ['Red', 'Acc', 'Normal'])->nullable();
            $table->enum('lateral_shift', ['Right', 'Left', 'Nil'])->nullable();
            $table->enum('kyphosis', ['Red', 'Acc', 'Normal'])->nullable();
            $table->enum('correction_of_posture', ['Better', 'Worse', 'No effect'])->nullable();
            $table->text('asymmetry')->nullable();
            $table->text('bps')->nullable();

            // Movement Type with side variations
            $table->enum('movement_type', [
                'Flex',
                'Ext',
                'Hyperext',
                'Lat_Flex',
                'Rot'
            ]);
            
            // Side (only for Lat_Flex and Rot)
            $table->enum('side', ['Left', 'Right', 'Both'])->nullable();
            
            // ROM measurement
            $table->boolean('rom')->nullable()->comment('Range of Motion present');
            
            // Pain assessment
            $table->enum('pain', [
                'No', 
                'Yes_Slight', 
                'Yes_Severe'
            ])->default('No');
            
            // Specific tests
            $table->enum('test_type', [
                'Lasegue',
                'Schober',
                'Patrik',
                'Bowstring',
                'Other'
            ]);
            
            // Test result
            $table->boolean('test_result')->nullable()->comment('Positive/Negative');
            
            // Comments
            $table->text('comment')->nullable();
            // Additional assessments
            $table->text('functional_test')->nullable();
            $table->text('accessory_movements')->nullable();
            $table->enum('palpation', [
                'Tender', 
                'Sore', 
                'Stiff', 
                'Thick', 
                'Elicited spasm', 
                'Prominent', 
                'Hypermobile segment'
            ])->nullable();
            
            // Physical assessments
            $table->text('abdominal_strength')->nullable();
            $table->text('wasting')->nullable();
            $table->text('manual_traction')->nullable();
            $table->text('other_comments')->nullable();

            // Treatment and goals
            $table->text('rx_goals')->nullable();
            $table->text('adl')->nullable();
            $table->text('rx')->nullable();
            $table->text('review')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spine_assessments');
    }
};