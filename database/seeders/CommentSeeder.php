<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $resources = Resource::approved()->get();
        $users = User::all();

        if ($resources->isEmpty() || $users->isEmpty()) {
            return;
        }

        $sampleComments = [
            'Great resource! Works perfectly.',
            'Thanks for sharing this!',
            'Having some issues with installation, any help?',
            'Amazing quality, much better than expected!',
            'Could you add more variations?',
            'Perfect for my custom map, thank you!',
            'The textures are very high quality.',
            'Easy to install and works great!',
            'Looking forward to more from this creator!',
            'Very useful tool, saved me a lot of time.',
        ];

        foreach ($resources as $resource) {
            $commentCount = rand(0, 8);
            
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'body' => $sampleComments[array_rand($sampleComments)],
                    'user_id' => $users->random()->id,
                    'resource_id' => $resource->id,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }
}