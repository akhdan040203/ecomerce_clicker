<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keyboards = \App\Models\Category::where('slug', 'keyboards')->first();
        $switches = \App\Models\Category::where('slug', 'switches')->first();
        $keycaps = \App\Models\Category::where('slug', 'keycaps')->first();

        $products = [
            // Keyboards
            ['category_id' => $keyboards->id, 'name' => 'Keychron K2 Wireless', 'slug' => 'keychron-k2-wireless', 'description' => 'A versatile wireless mechanical keyboard with 84 keys.', 'price' => 1200000, 'stock' => 50],
            ['category_id' => $keyboards->id, 'name' => 'Ducky One 3 Mini', 'slug' => 'ducky-one-3-mini', 'description' => 'The legendary Ducky One 3 with QUACK Mechanics.', 'price' => 1500000, 'stock' => 30],
            ['category_id' => $keyboards->id, 'name' => 'Keychron V1 QMK', 'slug' => 'keychron-v1-qmk', 'description' => 'Fully customizable 75% layout keyboard.', 'price' => 1100000, 'stock' => 25],
            ['category_id' => $keyboards->id, 'name' => 'Akko 3068B Plus', 'slug' => 'akko-3068b-plus', 'description' => 'Multi-mode wireless keyboard with Boken design.', 'price' => 950000, 'stock' => 40],
            
            // Switches
            ['category_id' => $switches->id, 'name' => 'Gateron Yellow Switches (Set of 35)', 'slug' => 'gateron-yellow-switches-35', 'description' => 'Smooth linear switches for a great typing experience.', 'price' => 250000, 'stock' => 100],
            ['category_id' => $switches->id, 'name' => 'Cherry MX Red (Set of 35)', 'slug' => 'cherry-mx-red-35', 'description' => 'Classic linear switch for fast gaming.', 'price' => 350000, 'stock' => 80],
            ['category_id' => $switches->id, 'name' => 'Kailh Box White (Set of 35)', 'slug' => 'kailh-box-white-35', 'description' => 'Tactile clicky switches with box stem.', 'price' => 280000, 'stock' => 60],
            ['category_id' => $switches->id, 'name' => 'Holy Panda (Set of 35)', 'slug' => 'holy-panda-35', 'description' => 'Legendary tactile switches for enthusiasts.', 'price' => 850000, 'stock' => 20],

            // Keycaps
            ['category_id' => $keycaps->id, 'name' => 'GMK Mizu Base Kit', 'slug' => 'gmk-mizu-base-kit', 'description' => 'High quality ABS double-shot keycaps in Mizu colors.', 'price' => 2100000, 'stock' => 15],
            ['category_id' => $keycaps->id, 'name' => 'PBT Notion Keycaps', 'slug' => 'pbt-notion-keycaps', 'description' => 'Minimalist PBT keycaps with crisp legends.', 'price' => 750000, 'stock' => 35],
            ['category_id' => $keycaps->id, 'name' => 'EPOMAKER Botanical', 'slug' => 'epomaker-botanical', 'description' => 'Nature inspired dye-sub PBT keycaps.', 'price' => 600000, 'stock' => 45],
            ['category_id' => $keycaps->id, 'name' => 'GMK Laser Custom', 'slug' => 'gmk-laser-custom', 'description' => 'Cyberpunk themed premium keycaps.', 'price' => 2500000, 'stock' => 10],
        ];

        foreach ($products as $product) {
            \App\Models\Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
