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
           
            

            // Kategori: Drinks
            [
                'name' => 'Berry Manuka', 
                'price' => 31000, 
                'image' => '/img/manuka2.png', // Pastikan gambar ada
                'category' => 'Drinks',
                'stock' => 20

            ],
            [
                'name' => 'Passion Tea', 
                'price' => 27000, 
                'image' => '/img/passion.png', 
                'category' => 'Drinks',
                'stock' => 30
            ],
            [
                'name' => 'Batavian Latte', 
                'price' => 25000, 
                'image' => '/img/batavian.png', 
                'category' => 'Drinks',
                'stock' => 35
            ],

            // Kategori: Bread
            [
                'name' => 'Steamed Bun', 
                'price' => 25000, 
                'image' => '/img/bun.png', 
                'category' => 'Bread',
                'stock' => 3
            ],
            

            // Kategori: Fruiti
            [
                'name' => 'Fruiti Punch ', 
                'price' => 34000, 
                'image' => '/img/fruiti.png', 
                'category' => 'Fruiti',
                'stock' => 3
            ],
            
        ];

        foreach ($items as $item) {
            Product::create($item);
        }
    }
}