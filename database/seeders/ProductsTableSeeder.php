<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products')->delete();
        
        \DB::table('products')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Neck guard',
                'description' => 'neck guard',
                'price' => '200.00',
                'stock_quantity' => 200,
                'unit' => 'pieces',
                'category_id' => 8,
                'sku' => '12wq2',
                'reorder_level' => 50,
                'created_at' => '2025-02-05 14:10:15',
                'updated_at' => '2025-02-05 14:10:15',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}