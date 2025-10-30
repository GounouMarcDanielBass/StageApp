<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in logical order: roles first, then users, then entities, then relationships

        $this->call([
            // Foundation data
            RoleSeeder::class,

            // User-related data
            UserSeeder::class,

            // Entity data with relationships
            CameroonDataSeeder::class,

            // Additional comprehensive data if needed
            ComprehensiveSeeder::class,
        ]);
    }
}
