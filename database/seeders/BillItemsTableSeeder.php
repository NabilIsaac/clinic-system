<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BillItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bill_items')->delete();
        
        \DB::table('bill_items')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bill_id' => 1,
                'name' => 'Paracetamol',
                'type' => 'Medication',
                'quantity' => 1,
                'unit_price' => '10.00',
                'total_price' => '10.00',
                'created_at' => '2025-02-05 14:23:13',
                'updated_at' => '2025-02-05 14:23:13',
            ),
            1 => 
            array (
                'id' => 2,
                'bill_id' => 1,
                'name' => 'Neck guard',
                'type' => 'Product',
                'quantity' => 1,
                'unit_price' => '200.00',
                'total_price' => '200.00',
                'created_at' => '2025-02-05 14:23:13',
                'updated_at' => '2025-02-05 14:23:13',
            ),
        ));
        
        
    }
}