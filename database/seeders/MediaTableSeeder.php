<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MediaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('media')->delete();
        
        \DB::table('media')->insert(array (
            0 => 
            array (
                'id' => 1,
                'model_type' => 'App\\Models\\Drug',
                'model_id' => 1,
                'uuid' => '317e7052-ee8a-453c-bdf6-3441ee717461',
                'collection_name' => 'image',
                'name' => '93d42372-1cb6-4a73-a37d-0f4c94e9c94f__89800',
                'file_name' => '93d42372-1cb6-4a73-a37d-0f4c94e9c94f__89800.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 239471,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 1,
                'created_at' => '2025-02-05 14:09:48',
                'updated_at' => '2025-02-05 14:09:48',
            ),
            1 => 
            array (
                'id' => 2,
                'model_type' => 'App\\Models\\Product',
                'model_id' => 1,
                'uuid' => 'bb4b5119-2410-4339-ba45-746b3956d400',
                'collection_name' => 'image',
                'name' => 'shock-doctor-neck-guard-ultra1_2000x',
                'file_name' => 'shock-doctor-neck-guard-ultra1_2000x.webp',
                'mime_type' => 'image/webp',
                'disk' => 'public',
                'conversions_disk' => 'public',
                'size' => 108802,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'generated_conversions' => '[]',
                'responsive_images' => '[]',
                'order_column' => 1,
                'created_at' => '2025-02-05 14:10:15',
                'updated_at' => '2025-02-05 14:10:15',
            ),
        ));
        
        
    }
}