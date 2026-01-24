<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
{
    public function index()
    {
        // 1. Ambil Menu dari Database
        $products = Product::all();

        // 2. Ambil Antrian Live (Hari ini & Status bukan Batal)
        // Format data disesuaikan agar bisa dibaca Alpine.js
        $queues = Order::with('items')
            ->whereDate('created_at', today())
            ->where('status', '!=', 'Batal')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'name' => $order->customer_name,
                    'time' => $order->created_at->format('H:i'), // Jam Order
                    'status' => $order->status, // Menunggu/Dimasak/Selesai
                    'total' => $order->total_price,
                    'items' => $order->items->map(fn($item) => [
                        'name' => $item->product_name,
                        'qty' => $item->quantity
                    ]),
                ];
            });

        return view('order', [
            'products' => $products,
            'queues' => $queues
        ]);
    }

    // app/Http/Controllers/OrderController.php

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'cart' => 'required|array|min:1'
        ]);

        try {
            DB::beginTransaction();

            $total = 0;
            
            // 1. CEK STOK & HITUNG TOTAL DULU
            foreach ($request->cart as $item) {
                $product = Product::lockForUpdate()->find($item['id']); // Lock biar ga rebutan
                
                if (!$product || $product->stock < $item['qty']) {
                    throw new \Exception("Stok {$item['name']} tidak cukup!");
                }
                
                $total += $item['price'] * $item['qty'];
            }

            // 2. SIMPAN ORDER
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_notes' => $request->customer_notes,
                'total_price' => $total,
                'status' => 'Menunggu'
            ]);

            // 3. SIMPAN ITEM & KURANGI STOK
            foreach ($request->cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item['name'], // Simpan nama buat history
                    'quantity' => $item['qty'],
                    'price' => $item['price']
                ]);

                // Kurangi Stok Real di Database
                Product::where('id', $item['id'])->decrement('stock', $item['qty']);
            }

            DB::commit();
            return response()->json(['success' => true, 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

