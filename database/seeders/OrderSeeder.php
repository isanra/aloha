<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // 1. Ambil semua produk yang sudah ada di DB
        $products = Product::all();

        if($products->isEmpty()) {
            $this->command->info('Produk kosong! Jalankan ProductSeeder dulu.');
            return;
        }

        // 2. Bikin Daftar Nama Dummy & Statusnya
        $dummies = [
            ['name' => 'Kak Rina', 'status' => 'Selesai', 'minutes_ago' => 60],
            ['name' => 'Bang Jago', 'status' => 'Selesai', 'minutes_ago' => 45],
            ['name' => 'Sisil', 'status' => 'Dimasak', 'minutes_ago' => 30],
            ['name' => 'Pak Budi', 'status' => 'Dimasak', 'minutes_ago' => 20],
            ['name' => 'Mama Dedeh', 'status' => 'Menunggu', 'minutes_ago' => 10],
            ['name' => 'Mas Kurir', 'status' => 'Menunggu', 'minutes_ago' => 5],
            ['name' => 'Dek Tono', 'status' => 'Menunggu', 'minutes_ago' => 2],
        ];

        foreach ($dummies as $d) {
            // Pilih 1-3 produk random buat si customer ini
            $randomProducts = $products->random(rand(1, 3));
            $totalPrice = 0;

            // Buat Order Utama
            $order = Order::create([
                'customer_name' => $d['name'],
                'customer_notes' => 'Catatan dummy untuk testing.',
                'status' => $d['status'],
                'total_price' => 0, // Nanti diupdate
                'created_at' => Carbon::now()->subMinutes($d['minutes_ago']), // Waktu mundur
                'updated_at' => Carbon::now()->subMinutes($d['minutes_ago']),
            ]);

            // Masukin Item Pesanan
            foreach ($randomProducts as $product) {
                $qty = rand(1, 2);
                $price = $product->price;
                $subtotal = $price * $qty;
                $totalPrice += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $product->name, // Simpan nama incase produk dihapus
                    'quantity' => $qty,
                    'price' => $price,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->created_at,
                ]);
            }

            // Update Total Harga di Tabel Order
            $order->update(['total_price' => $totalPrice]);
        }
    }
}