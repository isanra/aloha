<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['name' => 'Berry Manuka', 'price' => 27000, 'image' => '/img/manuka.png', 'category' => 'Drinks'],
            ['name' => 'Choco Lava Bun', 'price' => 21000, 'image' => '/img/bun.png', 'category' => 'Dessert'],
            ['name' => 'Sparkling Lychee Tea', 'price' => 23000, 'image' => '/img/lychee.png', 'category' => 'Drinks'],
            ['name' => 'Magic Water', 'price' => 16000, 'image' => '/img/magic.png', 'category' => 'Drinks'],
            ['name' => 'Fruiti Punch', 'price' => 28000, 'image' => '/img/fruiti.png', 'category' => 'Drinks'],
            ['name' => 'Choco Lava Cake', 'price' => 22000, 'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476d?w=500&q=80', 'category' => 'Dessert'],
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}