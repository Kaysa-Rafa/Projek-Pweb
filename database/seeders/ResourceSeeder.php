<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\Category;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $models = Category::where('slug', 'models')->first();
        if (!$models) return;
        $skins = Category::where('slug', 'skins')->first();
        $icons = Category::where('slug', 'icons')->first();
        $spells = Category::where('slug', 'spells')->first();
        $maps = Category::where('slug', 'maps')->first();
        $tools = Category::where('slug', 'tools')->first();
        $tutorials = Category::where('slug', 'tutorials')->first();
        $packs = Category::where('slug', 'packs')->first();
        $scripts = Category::where('slug', 'scripts-ai')->first();

$resources = [
            [
                'title' => 'Footman HD Model',
                'slug' => 'footman-hd-model',
                'description' => 'High quality Footman model with improved animations.',
                'file_path' => 'uploads/models/footman_hd.mdx',
                'original_filename' => 'footman_hd.mdx',
                'file_size' => 102400, 
                'file_extension' => 'mdx',
                'file_mime_type' => 'application/octet-stream',
                
                'category_id' => $models->id,
                'user_id' => 1, 
                'is_approved' => true,
                'is_public' => true,
                'download_count' => 1220,
            ],
            [
                'title' => 'The Frozen Kingdom Map',
                'slug' => 'frozen-kingdom-map',
                'description' => 'A melee map set in the frozen north.',
                'file_path' => 'uploads/maps/frozen_kingdom.w3x',
                'original_filename' => 'frozen_kingdom.w3x',
                'file_size' => 2048000, 
                'file_extension' => 'w3x',
                'file_mime_type' => 'application/octet-stream',

                'category_id' => $maps->id,
                'user_id' => 1,
                'is_approved' => true,
                'is_public' => true,
                'download_count' => 1500,
            ],
        ];

        foreach ($resources as $r) {
            Resource::firstOrCreate(['slug' => $r['slug']], $r);
        }
    }
}