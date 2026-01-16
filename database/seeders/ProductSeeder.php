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
                'name' => 'Japlak', 
                'price' => 27000, 
                'image' => '/img/japlak.png', 
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
            

            // Kategori: Fruiti
            [
                'name' => 'Fruiti Punch Bowl', 
                'price' => 28000, 
                'image' => '/img/fruiti.png', 
                'category' => 'Fruiti'
            ],
            
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}