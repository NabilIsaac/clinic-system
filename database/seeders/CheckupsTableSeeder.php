<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CheckupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('checkups')->delete();
        
        \DB::table('checkups')->insert(array (
            0 => 
            array (
                'id' => 2,
                'patient_id' => 10,
                'doctor_id' => 3,
                'bp' => '120/80',
                'total_amount' => '210.00',
                'reason' => 'knee_pain',
                'visit_history' => 'patient has a knee problem',
                'additional_comments' => NULL,
                'status' => 'completed',
                'created_at' => '2025-02-05 14:12:06',
                'updated_at' => '2025-02-05 14:12:06',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}