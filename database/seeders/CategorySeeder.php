<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->delete();

        $categories = [
            [
                'name' => 'Maps',
                'slug' => 'maps',
                'description' => 'Custom Warcraft III maps and scenarios',
                'color' => 'blue',
                'icon' => '🗺️',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Models',
                'slug' => 'models',
                'description' => '3D models and character assets',
                'color' => 'green',
                'icon' => '🔷',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Skins & Textures',
                'slug' => 'skins-textures',
                'description' => 'Texture skins and appearance modifications',
                'color' => 'purple',
                'icon' => '🎨',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tools',
                'slug' => 'tools',
                'description' => 'Utilities and applications for modding',
                'color' => 'red',
                'icon' => '🛠️',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Icons',
                'slug' => 'icons',
                'description' => 'Custom icons and interface elements',
                'color' => 'yellow',
                'icon' => '📱',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Scripts',
                'slug' => 'scripts',
                'description' => 'Code scripts and triggers',
                'color' => 'indigo',
                'icon' => '📜',
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}