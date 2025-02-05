<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DrugsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('drugs')->delete();
        
        \DB::table('drugs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Paracetamol',
                'sku' => '12wqi',
                'generic_name' => 'para',
                'description' => 'para',
                'price' => '10.00',
                'stock_quantity' => 200,
                'reorder_level' => 50,
                'unit' => 'tablets',
                'created_at' => '2025-02-05 14:09:48',
                'updated_at' => '2025-02-05 14:09:48',
                'deleted_at' => NULL,
                'category_id' => 2,
            ),
        ));
        
        
    }
}