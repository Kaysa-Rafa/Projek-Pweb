<?php

namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $tags = Tag::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $sampleResources = [
            [
                'title' => 'Custom Hero Model - Archmage',
                'description' => 'A high-quality custom Archmage hero model with new animations and effects.',
                'category_id' => $categories->where('slug', 'unit-models')->first()->id,
                'version' => '1.2',
                'tags' => ['hero', 'model', 'unit', 'hd']
            ],
            [
                'title' => 'Medieval Castle Texture Pack',
                'description' => 'A collection of medieval castle textures for human buildings.',
                'category_id' => $categories->where('slug', 'textures')->first()->id,
                'version' => '2.0',
                'tags' => ['texture', 'building', 'human', 'castle']
            ],
            [
                'title' => 'Element TD Map',
                'description' => 'Popular tower defense map with elemental themed towers and creeps.',
                'category_id' => $categories->where('slug', 'tower-defense')->first()->id,
                'version' => '3.5',
                'tags' => ['td', 'tower-defense', 'multiplayer', 'classic']
            ],
            [
                'title' => 'Custom Spell Icons Pack',
                'description' => 'Over 50 custom spell icons for various magic schools.',
                'category_id' => $categories->where('slug', 'icons')->first()->id,
                'version' => '1.0',
                'tags' => ['icon', 'spell', 'ui', 'magic']
            ],
            [
                'title' => 'Warcraft 3 Model Editor',
                'description' => 'Tool for editing and creating custom models for Warcraft 3.',
                'category_id' => $categories->where('slug', 'tools')->first()->id,
                'version' => '1.8',
                'tags' => ['tool', 'editor', 'model', 'utility']
            ],
        ];

        foreach ($sampleResources as $resourceData) {
            $user = $users->random();
            $tagsToAttach = $tags->whereIn('name', $resourceData['tags']);

            $resource = Resource::create([
                'title' => $resourceData['title'],
                'slug' => \Str::slug($resourceData['title']),
                'description' => $resourceData['description'],
                'installation_instructions' => 'Extract to your Warcraft 3 directory. For models, use the import manager.',
                'user_id' => $user->id,
                'category_id' => $resourceData['category_id'],
                'file_path' => 'resources/sample/file_' . uniqid() . '.zip', // Dummy path
                'file_size' => rand(500, 5000), // KB
                'file_type' => 'application/zip',
                'version' => $resourceData['version'],
                'download_count' => rand(0, 1000),
                'view_count' => rand(0, 5000),
                'rating' => rand(30, 50) / 10, // 3.0 - 5.0
                'rating_count' => rand(5, 100),
                'is_approved' => true,
                'is_featured' => rand(0, 1),
            ]);

            // Attach tags
            $resource->tags()->attach($tagsToAttach->pluck('id'));
        }

        // Create some unapproved resources for moderation testing
        Resource::create([
            'title' => 'Pending Approval - New RPG Map',
            'slug' => 'pending-approval-new-rpg-map',
            'description' => 'A new RPG map waiting for moderator approval.',
            'user_id' => $users->where('role', 'user')->first()->id,
            'category_id' => $categories->where('slug', 'rpg-maps')->first()->id,
            'file_path' => 'resources/sample/pending_file.zip',
            'file_size' => 1500,
            'file_type' => 'application/zip',
            'version' => '1.0',
            'is_approved' => false,
        ]);
    }
}