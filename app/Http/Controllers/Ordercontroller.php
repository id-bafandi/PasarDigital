<?php
 
namespace App\Http\Controllers;
 
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class OrderController extends Controller
{
    /**
     * Daftar pesanan milik user yang login.
     */
    public function index(Request $request)
    {
        $orders = Order::with('payment')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);
 
        return view('konsumen.orders', compact('orders'));
    }
 
    /**
     * Detail satu pesanan.
     */
    public function show(Request $request, Order $order)
    {
        abort_if(
            $order->user_id !== $request->user()->id && !$request->user()->is_admin,
            403
        );
 
        $order->load('items.product', 'payment');
 
        return view('konsumen.orders.show', compact('order'));
    }
 
    /**
     * Halaman konfirmasi setelah checkout.
     */
    public function confirmation(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);
 
        $order->load('items.product');
        $payment = $order->payment;
 
        return view('konsumen.order-confirmation', compact('order', 'payment'));
    }
 
    /**
     * Batalkan pesanan oleh user.
     */
    public function cancel(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);
 
        if ($order->status_pesanan !== Order::STATUS_PENDING) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }
 
        DB::beginTransaction();
        try {
            foreach ($order->items as $item) {
                $item->product->increment('stok', $item->quantity);
            }
 
            $order->update(['status_pesanan' => Order::STATUS_CANCELLED]);
 
            if ($order->payment) {
                $order->payment->update(['status_pembayaran' => Payment::STATUS_CANCELLED]);
            }
 
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan pesanan.');
        }
 
        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
 
    // =========================================================================
    // ADMIN
    // =========================================================================
 
    public function adminIndex(Request $request)
    {
        abort_unless($request->user()->is_admin, 403);
 
        $status = $request->get('status');
 
        $orders = Order::with('user', 'payment')
            ->when($status, fn($q) => $q->where('status_pesanan', $status))
            ->latest()
            ->paginate(20);
 
        return view('admin.orders.index', compact('orders', 'status'));
    }
 
    public function adminShow(Request $request, Order $order)
    {
        abort_unless($request->user()->is_admin, 403);
        $order->load('items.product', 'payment', 'user');
        return view('admin.orders.show', compact('order'));
    }
 
    public function updateStatus(Request $request, Order $order)
    {
        abort_unless($request->user()->is_admin, 403);
 
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
 
        $order->update(['status_pesanan' => $validated['status']]);
 
        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
 