<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Prescription Medications',
                'type' => 'drug',
                'description' => 'Medications that require a prescription from a licensed healthcare provider',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Over-the-Counter Medications',
                'type' => 'drug',
                'description' => 'Medications that can be purchased without a prescription',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Vaccines',
                'type' => 'drug',
                'description' => 'Preventive medications that provide immunity against specific diseases',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Medical Supplies',
                'type' => 'product',
                'description' => 'Disposable items used in medical procedures and patient care',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Medical Equipment',
                'type' => 'product',
                'description' => 'Durable medical equipment and devices',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Laboratory Supplies',
                'type' => 'product',
                'description' => 'Items used in laboratory testing and diagnostics',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'First Aid Supplies',
                'type' => 'product',
                'description' => 'Basic medical supplies for emergency care and minor injuries',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Personal Protective Equipment',
                'type' => 'product',
                'description' => 'Items used to protect staff and patients from infection and contamination',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Surgical Supplies',
                'type' => 'product',
                'description' => 'Items used in surgical procedures',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Office Supplies',
                'type' => 'product',
                'description' => 'General supplies used in clinic administration',
                'created_at' => '2025-02-05 14:07:15',
                'updated_at' => '2025-02-05 14:07:15',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}