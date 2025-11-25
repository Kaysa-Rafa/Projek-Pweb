<?php
// database/seeders/UserSeeder.php - Alternatif
namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Cleaning existing users...');
        
        // Hapus data lama (hati-hati di production!)
        DB::table('user_profiles')->delete();
        DB::table('users')->delete();

        $this->command->info('Creating new users...');

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@hiveworkshop.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'reputation' => 1000,
            'email_verified_at' => now(),
        ]);

        UserProfile::create([
            'user_id' => $admin->id,
            'bio' => 'Site Administrator',
            'location' => 'Internet',
        ]);

        // Create moderator user
        $moderator = User::create([
            'name' => 'Moderator User',
            'email' => 'moderator@hiveworkshop.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
            'reputation' => 500,
            'email_verified_at' => now(),
        ]);

        UserProfile::create([
            'user_id' => $moderator->id,
            'bio' => 'Community Moderator',
        ]);

        // Create regular user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@hiveworkshop.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'reputation' => 100,
            'email_verified_at' => now(),
        ]);

        UserProfile::create([
            'user_id' => $user->id,
            'bio' => 'Regular community member',
        ]);

        $this->command->info('Users created successfully!');
        $this->command->info('Admin: admin@hiveworkshop.com / password');
        $this->command->info('Moderator: moderator@hiveworkshop.com / password');
        $this->command->info('User: user@hiveworkshop.com / password');
    }
}