<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing categories first
        Category::query()->delete();

        $categories = [
            [
                'name' => 'Maps',
                'slug' => 'maps',
                'description' => 'Custom game maps and scenarios',
                'children' => [
                    ['name' => 'Melee Maps', 'slug' => 'melee-maps', 'description' => 'Traditional melee gameplay maps'],
                    ['name' => 'Custom Scenarios', 'slug' => 'custom-scenarios', 'description' => 'Custom scenario maps'],
                    ['name' => 'RPG Maps', 'slug' => 'rpg-maps', 'description' => 'Role playing game maps'],
                    ['name' => 'Tower Defense', 'slug' => 'tower-defense', 'description' => 'Tower defense maps'],
                ]
            ],
            [
                'name' => 'Models',
                'slug' => 'models',
                'description' => '3D models for units, buildings, and effects',
                'children' => [
                    ['name' => 'Units', 'slug' => 'unit-models', 'description' => 'Custom unit models'],
                    ['name' => 'Buildings', 'slug' => 'building-models', 'description' => 'Custom building models'],
                    ['name' => 'Effects', 'slug' => 'effect-models', 'description' => 'Special effect models'],
                    ['name' => 'UI Elements', 'slug' => 'ui-models', 'description' => 'User interface models'],
                ]
            ],
            [
                'name' => 'Textures',
                'slug' => 'textures',
                'description' => 'Custom textures and skins',
                'children' => [
                    ['name' => 'Unit Textures', 'slug' => 'unit-textures', 'description' => 'Unit skin textures'],
                    ['name' => 'Building Textures', 'slug' => 'building-textures', 'description' => 'Building skin textures'],
                    ['name' => 'Terrain Textures', 'slug' => 'terrain-textures', 'description' => 'Terrain and environment textures'],
                ]
            ],
            [
                'name' => 'Icons',
                'slug' => 'icons',
                'description' => 'Custom ability and item icons',
                'children' => [
                    ['name' => 'Ability Icons', 'slug' => 'ability-icons', 'description' => 'Spell and ability icons'],
                    ['name' => 'Item Icons', 'slug' => 'item-icons', 'description' => 'Item and inventory icons'],
                    ['name' => 'UI Icons', 'slug' => 'ui-icons', 'description' => 'User interface icons'],
                ]
            ],
            [
                'name' => 'Tools',
                'slug' => 'tools',
                'description' => 'Development tools and utilities',
                'children' => [
                    ['name' => 'Editors', 'slug' => 'editors', 'description' => 'Map and model editors'],
                    ['name' => 'Converters', 'slug' => 'converters', 'description' => 'File format converters'],
                    ['name' => 'Utilities', 'slug' => 'utilities', 'description' => 'Development utilities'],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            // Use firstOrCreate to avoid duplicates
            $category = Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );

            foreach ($children as $childData) {
                Category::firstOrCreate(
                    ['slug' => $childData['slug']],
                    array_merge($childData, [
                        'parent_id' => $category->id
                    ])
                );
            }
        }
    }
}