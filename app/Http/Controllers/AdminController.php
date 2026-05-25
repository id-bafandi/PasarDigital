<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUser     = User::where('role', 'user')->count();
        $totalPenjual  = User::where('role', 'penjual')->count();
        $totalProduk   = Product::count();
        $totalPesanan  = Order::count();
        $pesananPending = Order::where('status', 'pending')->count();
        $totalPendapatan = Order::where('status', '!=', 'cancelled')->sum('total_price');
        $pesananTerbaru = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalPenjual',
            'totalProduk',
            'totalPesanan',
            'pesananPending',
            'totalPendapatan',
            'pesananTerbaru'
        ));
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        abort_if($user->role === 'admin', 403, 'Tidak bisa hapus admin.');
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function products()
    {
        $products = Product::with('category', 'seller')->latest()->paginate(20);
        return view('admin.products', compact('products'));
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function payments()
    {
        $payments = Payment::with('order.user')->latest()->paginate(20);
        return view('admin.payments', compact('payments'));
    }
}