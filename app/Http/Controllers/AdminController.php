<?php

namespace App\Http\Controllers;

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
    public function dashboard()
    {
        if (!Session::has('is_admin')) {
            return redirect('/admin');
        }

        // KITA GANTI LOGIC SORTINGNYA BIAR SUPPORT SQLITE
        $orders = Order::with('items')
            ->orderByRaw("CASE 
                WHEN status = 'Menunggu' THEN 1 
                WHEN status = 'Dimasak' THEN 2 
                WHEN status = 'Selesai' THEN 3 
                WHEN status = 'Batal' THEN 4 
                ELSE 5 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('orders'));
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

    // 5. Logout
    public function logout()
    {
        Session::forget('is_admin');
        return redirect('/admin');
    }
}