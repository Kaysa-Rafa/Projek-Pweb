<?php

namespace Database\Seeders;

use App\Models\Download;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Seeder;

class DownloadSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $resources = Resource::approved()->get();

        if ($users->isEmpty() || $resources->isEmpty()) {
            return;
        }

        // Create download history
        foreach (range(1, 100) as $i) {
            Download::create([
                'user_id' => $users->random()->id,
                'resource_id' => $resources->random()->id,
                'ip_address' => '192.168.1.' . rand(1, 255),
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'downloaded_at' => now()->subDays(rand(0, 60)),
            ]);
        }
    }
}