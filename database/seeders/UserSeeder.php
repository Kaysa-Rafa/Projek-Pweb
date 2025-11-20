<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@hiveworkshop.test'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create regular users
        User::firstOrCreate(
            ['email' => 'user1@hiveworkshop.test'],
            [
                'name' => 'Test User 1',
                'username' => 'user1',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user2@hiveworkshop.test'],
            [
                'name' => 'Test User 2',
                'username' => 'user2',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Create more dummy users
        User::factory(5)->create();
    }
}