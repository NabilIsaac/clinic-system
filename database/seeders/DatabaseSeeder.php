<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DepartmentsAndEmployeeTypesSeeder;
use Database\Seeders\TestDataSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            DepartmentsAndEmployeeTypesSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            // TestDataSeeder::class,
        ]);
        $this->call(CheckupsTableSeeder::class);
        $this->call(DrugsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(MediaTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        $this->call(BillItemsTableSeeder::class);
    }
}
