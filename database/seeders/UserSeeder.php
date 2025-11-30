<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@hiveworkshop.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'reputation' => 1000,
                'email_verified_at' => now(),
            ]
        );

        UserProfile::firstOrCreate(['user_id' => $admin->id], [
            'bio' => 'Site Administrator',
            'location' => 'Internet',
        ]);

        // Create Moderator
        $moderator = User::firstOrCreate(
            ['email' => 'moderator@hiveworkshop.com'],
            [
                'name' => 'Moderator User',
                'password' => Hash::make('password'),
                'role' => 'moderator',
                'reputation' => 500,
                'email_verified_at' => now(),
            ]
        );

        UserProfile::firstOrCreate(['user_id' => $moderator->id], [
            'bio' => 'Community Moderator',
        ]);

        // Create Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@hiveworkshop.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'reputation' => 100,
                'email_verified_at' => now(),
            ]
        );

        UserProfile::firstOrCreate(['user_id' => $user->id], [
            'bio' => 'Regular community member',
        ]);
    }
}