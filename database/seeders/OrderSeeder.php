<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Schema;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // 1. Matikan pengecekan Foreign Key sementara
        // (Wajib dilakukan karena tabel orders dan order_items saling terhubung)
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan Tabel (Hapus Semua Data)
        OrderItem::truncate();
        Order::truncate();

        // 3. Hidupkan lagi pengecekan Foreign Key
        Schema::enableForeignKeyConstraints();

        // Kasih info di terminal
        $this->command->info('✅ Sip! Semua data antrian & pesanan sudah dihapus bersih.');
    }
}