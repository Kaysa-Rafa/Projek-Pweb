<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'melee', 'rpg', 'td', 'arena', 'defense', 'survival',
            'hero', 'custom', 'multiplayer', 'singleplayer',
            'warcraft-3', 'reforged', 'classic', 'hd',
            'unit', 'building', 'spell', 'item', 'ui',
            'texture', 'model', 'icon', 'skin', 'particle',
            'tool', 'utility', 'importer', 'exporter', 'converter'
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => \Str::slug($tagName),
            ]);
        }
    }
}