<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ResourceSeeder::class,
        ]);
        

        $this->command->info('=== Database Seeding Completed ===');
        $this->command->info('Admin: admin@hiveworkshop.com / password');
        $this->command->info('Moderator: moderator@hiveworkshop.com / password'); 
        $this->command->info('User: user@hiveworkshop.com / password');
    }
}