<?php

namespace App\Http\Controllers;

use App\Models\Product; // <--- TAMBAHKAN BARIS INI
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // 1. Halaman Login
    public function loginForm()
    {
        // Kalau sudah login, lempar langsung ke dashboard
        if (Session::has('is_admin')) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    // 2. Proses Cek Password
    public function login(Request $request)
    {
        // PASSWORD SAKTI: 'admin123' (Bisa diganti)
        if ($request->password === 'admin123') {
            Session::put('is_admin', true);
            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Password salah bos!');
    }

    // 3. Halaman Dashboard (List Pesanan)
    // app/Http/Controllers/AdminController.php

    public function dashboard()
    {
        if (!Session::has('is_admin')) {
            return redirect('/admin');
        }

        // 1. Ambil Antrian (Logic Lama)
        $orders = Order::with('items')
            ->orderByRaw("CASE 
                WHEN status = 'Menunggu' THEN 1 
                WHEN status = 'Dimasak' THEN 2 
                WHEN status = 'Selesai' THEN 3 
                ELSE 4 END")
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. DATA BARU: Total Pendapatan (Hanya yang status Selesai)
        $totalRevenue = Order::where('status', 'Selesai')->sum('total_price');

        // 3. DATA BARU: Total Order Hari Ini
        $totalOrdersToday = Order::whereDate('created_at', today())->count();

        // 4. DATA BARU: Stok Produk untuk Monitor
        $products = Product::select('id', 'name', 'stock', 'image')->get();

        return view('admin.dashboard', compact('orders', 'totalRevenue', 'totalOrdersToday', 'products'));
    }

    // 4. Update Status Pesanan
    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->status = $request->status;
            $order->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
    // Update Stok Produk
    public function updateStock(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->stock = $request->stock;
            $product->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    // 5. Logout
    public function logout()
    {
        Session::forget('is_admin');
        return redirect('/admin');
    }
}