<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan ini SANGAT PENTING
        $this->call([
            UserSeeder::class,      // 1. Buat User dulu (PENTING!)
            CategorySeeder::class,  // 2. Buat Kategori
            TagSeeder::class,       // 3. Buat Tag
            ResourceSeeder::class,  // 4. Baru buat Resource (karena butuh User & Kategori)
        ]);
        
        $this->command->info('=== Database Seeding Completed ===');
    }
}