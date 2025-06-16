<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Panggil semua seeder yang kamu butuhkan
        $this->call([
            AdminSeeder::class,
            // FieldSeeder::class,
            // OrderSeeder::class,
        ]);
    }
}
