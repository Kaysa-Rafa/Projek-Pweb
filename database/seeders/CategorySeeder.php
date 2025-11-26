<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Models',
                'slug' => 'models',
                'description' => '3D models for units, buildings, doodads, and more.',
                'icon' => '📦',
                'color' => 'blue',
            ],
            [
                'name' => 'Skins',
                'slug' => 'skins',
                'description' => 'Textures for units, heroes, and buildings.',
                'icon' => '🎨',
                'color' => 'rose',
            ],
            [
                'name' => 'Icons',
                'slug' => 'icons',
                'description' => 'BTN, DISBTN, Passive icons, and more.',
                'icon' => '🖼️',
                'color' => 'amber',
            ],
            [
                'name' => 'Spells',
                'slug' => 'spells',
                'description' => 'Spell packs, effects, and abilities.',
                'icon' => '✨',
                'color' => 'purple',
            ],
            [
                'name' => 'Maps',
                'slug' => 'maps',
                'description' => 'Complete maps: RPG, AoS, TD, Melee and more.',
                'icon' => '🗺️',
                'color' => 'green',
            ],
            [
                'name' => 'Tools',
                'slug' => 'tools',
                'description' => 'Software tools for editing and modding Warcraft.',
                'icon' => '🛠️',
                'color' => 'slate',
            ],
            [
                'name' => 'Tutorials',
                'slug' => 'tutorials',
                'description' => 'Guides for modeling, mapping, scripting, etc.',
                'icon' => '📘',
                'color' => 'cyan',
            ],
            [
                'name' => 'Packs',
                'slug' => 'packs',
                'description' => 'Bundled packs of skins, models, icons, and more.',
                'icon' => '📁',
                'color' => 'yellow',
            ],
            [
                'name' => 'Scripts & AI',
                'slug' => 'scripts-ai',
                'description' => 'JASS, vJASS, Lua scripts and AI systems.',
                'icon' => '💻',
                'color' => 'indigo',
            ],
        ];

        foreach ($categories as $c) {
            Category::create($c);
        }
    }
}
