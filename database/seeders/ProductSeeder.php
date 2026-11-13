<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Wipe old records clean first so we do not get duplicate errors
        Product::truncate();

        Product::create([
            'name' => 'Volt Retro Sneakers',
            'slug' => 'volt-retro-sneakers',
            'description' => 'Comfortable athletic running shoes built for speed.',
            'category' => 'Sneakers',
            'price' => 120.00,
            'stock' => 15,
            'image_url' => 'https://unsplash.com'
        ]);

        Product::create([
            'name' => 'Wireless Sound Headphones',
            'slug' => 'wireless-sound-headphones',
            'description' => 'Noise-canceling premium over-ear headphones.',
            'category' => 'Audio',
            'price' => 89.00,
            'stock' => 8,
            'image_url' => 'https://unsplash.com'
        ]);

        Product::create([
            'name' => 'Minimalist Leather Watch',
            'slug' => 'minimalist-leather-watch',
            'description' => 'Sleek executive timepiece with genuine leather bands.',
            'category' => 'Accessories',
            'price' => 199.00,
            'stock' => 5,
            'image_url' => 'https://unsplash.com'
        ]);
    }
}
