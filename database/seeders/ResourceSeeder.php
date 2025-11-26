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
        $skins = Category::where('slug', 'skins')->first();
        $icons = Category::where('slug', 'icons')->first();
        $spells = Category::where('slug', 'spells')->first();
        $maps = Category::where('slug', 'maps')->first();
        $tools = Category::where('slug', 'tools')->first();
        $tutorials = Category::where('slug', 'tutorials')->first();
        $packs = Category::where('slug', 'packs')->first();
        $scripts = Category::where('slug', 'scripts-ai')->first();

        $resources = [

            // MODELS
            [
                'title' => 'Footman HD Model',
                'slug' => 'footman-hd-model',
                'description' => 'High quality Footman model with improved animations.',
                'file_path' => 'uploads/models/footman_hd.mdx',
                'category_id' => $models->id,
                'download_count' => 1220,
            ],
            [
                'title' => 'Dragon Whelp Model',
                'slug' => 'dragon-whelp-model',
                'description' => 'A cute dragon whelp unit model.',
                'file_path' => 'uploads/models/dragon_whelp.mdx',
                'category_id' => $models->id,
                'download_count' => 850,
            ],

            // SKINS
            [
                'title' => 'Knight Elite Skin',
                'slug' => 'knight-elite-skin',
                'description' => 'Reworked knight armor with HD textures.',
                'file_path' => 'uploads/skins/knight_elite.blp',
                'category_id' => $skins->id,
                'download_count' => 540,
            ],

            // ICONS
            [
                'title' => 'BTNFireball Icon',
                'slug' => 'btn-fireball-icon',
                'description' => 'Warcraft 3 style fireball icon (BTN/DISBTN).',
                'file_path' => 'uploads/icons/btn_fireball.png',
                'category_id' => $icons->id,
                'download_count' => 300,
            ],

            // SPELLS
            [
                'title' => 'Meteor Strike Spell',
                'slug' => 'meteor-strike-spell',
                'description' => 'A cinematic meteor strike spell with SFX.',
                'file_path' => 'uploads/spells/meteor_strike.w3x',
                'category_id' => $spells->id,
                'download_count' => 760,
            ],

            // MAPS
            [
                'title' => 'The Frozen Kingdom Map',
                'slug' => 'frozen-kingdom-map',
                'description' => 'A melee map set in the frozen north.',
                'file_path' => 'uploads/maps/frozen_kingdom.w3x',
                'category_id' => $maps->id,
                'download_count' => 1500,
            ],

            // TOOLS
            [
                'title' => 'Model Converter Tool',
                'slug' => 'model-converter-tool',
                'description' => 'Convert MDX ↔ OBJ for Warcraft III modding.',
                'file_path' => 'uploads/tools/model_converter.zip',
                'category_id' => $tools->id,
                'download_count' => 670,
            ],

            // TUTORIALS
            [
                'title' => 'How to Create Custom Icons',
                'slug' => 'tutorial-custom-icons',
                'description' => 'Beginner friendly guide to creating Warcraft 3 icons.',
                'file_path' => null,
                'category_id' => $tutorials->id,
                'download_count' => 0,
            ],

            // PACKS
            [
                'title' => 'Human Buildings Pack',
                'slug' => 'human-buildings-pack',
                'description' => 'A pack of improved human building models.',
                'file_path' => 'uploads/packs/human_buildings_pack.zip',
                'category_id' => $packs->id,
                'download_count' => 940,
            ],

            // SCRIPTS & AI
            [
                'title' => 'Advanced AI System (JASS)',
                'slug' => 'advanced-ai-system',
                'description' => 'A smart JASS-based AI system for custom maps.',
                'file_path' => 'uploads/scripts/advanced_ai.j',
                'category_id' => $scripts->id,
                'download_count' => 500,
            ],
        ];

        foreach ($resources as $r) {
            Resource::create($r);
        }
    }
}
