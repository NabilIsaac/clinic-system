<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Prescription Medications',
                'type' => 'drug',
                'description' => 'Medications that require a prescription from a licensed healthcare provider'
            ],
            [
                'name' => 'Over-the-Counter Medications',
                'type' => 'drug',
                'description' => 'Medications that can be purchased without a prescription'
            ],
            [
                'name' => 'Vaccines',
                'type' => 'drug',
                'description' => 'Preventive medications that provide immunity against specific diseases'
            ],
            [
                'name' => 'Medical Supplies',
                'type' => 'product',
                'description' => 'Disposable items used in medical procedures and patient care'
            ],
            [
                'name' => 'Medical Equipment',
                'type' => 'product',
                'description' => 'Durable medical equipment and devices'
            ],
            [
                'name' => 'Laboratory Supplies',
                'type' => 'product',
                'description' => 'Items used in laboratory testing and diagnostics'
            ],
            [
                'name' => 'First Aid Supplies',
                'type' => 'product',
                'description' => 'Basic medical supplies for emergency care and minor injuries'
            ],
            [
                'name' => 'Personal Protective Equipment',
                'type' => 'product',
                'description' => 'Items used to protect staff and patients from infection and contamination'
            ],
            [
                'name' => 'Surgical Supplies',
                'type' => 'product',
                'description' => 'Items used in surgical procedures'
            ],
            [
                'name' => 'Office Supplies',
                'type' => 'product',
                'description' => 'General supplies used in clinic administration'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
