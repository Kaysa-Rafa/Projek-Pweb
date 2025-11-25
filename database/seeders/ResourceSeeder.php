<?php
// database/seeders/ResourceSeeder.php
namespace Database\Seeders;

use App\Models\Resource;
use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('resources')->delete();

        $users = User::all();
        $categories = Category::all();
        
        // Create some tags
        $tags = Tag::firstOrCreate(['name' => 'Warcraft III', 'slug' => 'warcraft-iii']);
        $tags = Tag::firstOrCreate(['name' => 'Custom Map', 'slug' => 'custom-map']);
        $tags = Tag::firstOrCreate(['name' => 'HD', 'slug' => 'hd']);
        $tags = Tag::firstOrCreate(['name' => 'Multiplayer', 'slug' => 'multiplayer']);

        for ($i = 1; $i <= 20; $i++) {
            $resource = Resource::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title' => 'Sample Resource ' . $i,
                'slug' => 'sample-resource-' . $i,
                'description' => $this->generateDescription($i),
                'file_path' => 'resources/sample-' . $i . '.zip',
                'file_size' => rand(1024, 10485760), // 1KB to 10MB
                'version' => '1.' . ($i % 3),
                'download_count' => rand(50, 5000),
                'view_count' => rand(100, 10000),
                'is_approved' => true,
                'is_featured' => $i <= 5, // First 5 are featured
                'update_notes' => $i % 3 == 0 ? 'Fixed some bugs and improved performance' : null,
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now(),
            ]);

            // Attach random tags
            $resource->tags()->attach(
                Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id')
            );
        }
    }

    private function generateDescription($index): string
    {
        $descriptions = [
            "A high-quality custom map for Warcraft III with unique gameplay mechanics and balanced heroes.",
            "This model pack includes detailed character models with custom animations and textures.",
            "HD texture pack that enhances the visual quality of the game with improved resolution.",
            "Powerful tool for modding Warcraft III maps with user-friendly interface and extensive features.",
            "Collection of custom icons for spells, items, and abilities with consistent art style.",
            "Advanced script library for creating complex game mechanics and AI behaviors.",
        ];

        return $descriptions[$index % count($descriptions)] . " This is sample resource #{$index}.";
    }
}