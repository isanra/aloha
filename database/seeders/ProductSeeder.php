<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel dulu biar gak dobel
        Product::truncate(); 

        $items = [
            // Kategori: Main Course
            [
                'name' => 'Crazy Rich Rice Bowl', 
                'price' => 35000, 
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80', 
                'category' => 'Main Course'
            ],
            [
                'name' => 'Mega Steak & Fries', 
                'price' => 85000, 
                'image' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=500&q=80', 
                'category' => 'Main Course'
            ],

            // Kategori: Drinks
            [
                'name' => 'Berry Manuka', 
                'price' => 27000, 
                'image' => '/img/manuka.png', // Pastikan gambar ada
                'category' => 'Drinks'
            ],
            [
                'name' => 'Sparkling Lychee Tea', 
                'price' => 23000, 
                'image' => '/img/lychee.png', 
                'category' => 'Drinks'
            ],
            [
                'name' => 'Magic Water', 
                'price' => 16000, 
                'image' => '/img/magic.png', 
                'category' => 'Drinks'
            ],

            // Kategori: Bread
            [
                'name' => 'Choco Lava Bun', 
                'price' => 21000, 
                'image' => '/img/bun.png', 
                'category' => 'Bread'
            ],
            [
                'name' => 'Croissant Butter', 
                'price' => 18000, 
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=500&q=80', 
                'category' => 'Bread'
            ],

            // Kategori: Fruiti
            [
                'name' => 'Fruiti Punch Bowl', 
                'price' => 28000, 
                'image' => '/img/fruiti.png', 
                'category' => 'Fruiti'
            ],
            [
                'name' => 'Summer Fruit Salad', 
                'price' => 32000, 
                'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500&q=80', 
                'category' => 'Fruiti'
            ],
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}