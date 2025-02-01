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

            // Converted all motion measurements to TEXT
            // Shoulder Range of Motion
            $table->text('flex_arom')->nullable();
            $table->text('flex_prom')->nullable();
            $table->text('flex_end_feel')->nullable();
            $table->text('flex_aroml')->nullable();
            $table->text('flex_proml')->nullable();
            $table->text('flex_end_feell')->nullable();

            $table->text('ext_arom')->nullable();
            $table->text('ext_prom')->nullable();
            $table->text('ext_end_feel')->nullable();
            $table->text('ext_aroml')->nullable();
            $table->text('ext_proml')->nullable();
            $table->text('ext_end_feell')->nullable();

            $table->text('abd_arom')->nullable();
            $table->text('abd_prom')->nullable();
            $table->text('abd_end_feel')->nullable();
            $table->text('abd_aroml')->nullable();
            $table->text('abd_proml')->nullable();
            $table->text('abd_end_feell')->nullable();

            $table->text('add_arom')->nullable();
            $table->text('add_prom')->nullable();
            $table->text('add_end_feel')->nullable();
            $table->text('add_aroml')->nullable();
            $table->text('add_proml')->nullable();
            $table->text('add_end_feell')->nullable();

            $table->text('ir_arom')->nullable();
            $table->text('ir_prom')->nullable();
            $table->text('ir_end_feel')->nullable();
            $table->text('ir_aroml')->nullable();
            $table->text('ir_proml')->nullable();
            $table->text('ir_end_feell')->nullable();

            $table->text('er_arom')->nullable();
            $table->text('er_prom')->nullable();
            $table->text('er_end_feel')->nullable();
            $table->text('er_aroml')->nullable();
            $table->text('er_proml')->nullable();
            $table->text('er_end_feell')->nullable();

            // Elbow Range of Motion
            $table->text('elbow_flex2_arom')->nullable();
            $table->text('elbow_flex2_prom')->nullable();
            $table->text('elbow_flex2_end_feel')->nullable();
            $table->text('elbow_flex2_aroml')->nullable();
            $table->text('elbow_flex2_proml')->nullable();
            $table->text('elbow_flex2_end_feell')->nullable();

            $table->text('elbow_ext2_arom')->nullable();
            $table->text('elbow_ext2_prom')->nullable();
            $table->text('elbow_ext2_end_feel')->nullable();
            $table->text('elbow_ext2_aroml')->nullable();
            $table->text('elbow_ext2_proml')->nullable();
            $table->text('elbow_ext2_end_feell')->nullable();

            $table->text('elbow_pron_arom')->nullable();
            $table->text('elbow_pron_prom')->nullable();
            $table->text('elbow_pron_end_feel')->nullable();
            $table->text('elbow_pron_aroml')->nullable();
            $table->text('elbow_pron_proml')->nullable();
            $table->text('elbow_pron_end_feell')->nullable();

            // Wrist Range of Motion
            $table->text('wrist_flex_arom')->nullable();
            $table->text('wrist_flex_prom')->nullable();
            $table->text('wrist_flex_end_feel')->nullable();
            $table->text('wrist_flex_aroml')->nullable();
            $table->text('wrist_flex_proml')->nullable();
            $table->text('wrist_flex_end_feell')->nullable();

            $table->text('wrist_ext_arom')->nullable();
            $table->text('wrist_ext_prom')->nullable();
            $table->text('wrist_ext_end_feel')->nullable();
            $table->text('wrist_ext_aroml')->nullable();
            $table->text('wrist_ext_proml')->nullable();
            $table->text('wrist_ext_end_feell')->nullable();

            $table->text('wrist_uln_dev_arom')->nullable();
            $table->text('wrist_uln_dev_prom')->nullable();
            $table->text('wrist_uln_dev_end_feel')->nullable();
            $table->text('wrist_uln_dev_aroml')->nullable();
            $table->text('wrist_uln_dev_proml')->nullable();
            $table->text('wrist_uln_dev_end_feell')->nullable();

            $table->text('wrist_rad_dev_arom')->nullable();
            $table->text('wrist_rad_dev_prom')->nullable();
            $table->text('wrist_rad_dev_end_feel')->nullable();
            $table->text('wrist_rad_dev_aroml')->nullable();
            $table->text('wrist_rad_dev_proml')->nullable();
            $table->text('wrist_rad_dev_end_feell')->nullable();

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