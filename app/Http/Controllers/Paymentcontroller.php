<?php
 
namespace App\Http\Controllers;
 
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
 
class PaymentController extends Controller
{
    /**
     * Proses checkout — buat order + payment, redirect ke halaman konfirmasi.
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|in:cod,transfer_ewallet',
            'receiver_name'     => 'required|string|max:255',
            'phone'             => 'required|string|max:20',
            'alamat_pengiriman' => 'required|string|max:500',
            'city'              => 'nullable|string|max:100',
            'postal_code'       => 'nullable|string|max:10',
            'catatan'           => 'nullable|string|max:255',
        ]);
 
        $cart = Cart::with('items.product')
            ->where('user_id', $request->user()->id)
            ->first();
 
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Cart kosong. Tambahkan produk terlebih dahulu.');
        }
 
        // Gabungkan alamat lengkap
        $fullAddress = $validated['alamat_pengiriman'];
        if (!empty($validated['city']))        $fullAddress .= ', ' . $validated['city'];
        if (!empty($validated['postal_code'])) $fullAddress .= ' ' . $validated['postal_code'];
 
        // ✅ Cek stok — kolom 'stok' di tabel products
        foreach ($cart->items as $item) {
            if ($item->product->stok < $item->quantity) {
                return back()->with('error', "Stok produk '{$item->product->nama_produk}' tidak mencukupi.");
            }
        }
 
        DB::beginTransaction();
 
        try {
            // ✅ kolom 'harga' di cart_items
            $totalHarga = $cart->items->sum(fn($i) => $i->harga * $i->quantity);
 
            // ✅ kolom orders: total_harga, status_pesanan, alamat_pengiriman, catatan
            $order = Order::create([
                'user_id'           => $request->user()->id,
                'order_number'      => $this->generateOrderNumber(),
                'total_harga'       => $totalHarga,
                'status_pesanan'    => Order::STATUS_PENDING,
                'alamat_pengiriman' => $fullAddress,
                'catatan'           => $validated['catatan'] ?? null,
            ]);
 
            foreach ($cart->items as $item) {
                // ✅ kolom order_items: harga, subtotal
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'harga'      => $item->harga,
                    'subtotal'   => $item->harga * $item->quantity,
                ]);
 
                // ✅ kurangi stok — kolom 'stok'
                $item->product->decrement('stok', $item->quantity);
            }
 
            // ✅ kolom payments: metode_pembayaran, jumlah_transfer, status_pembayaran, batas_bayar
            $payment = Payment::create([
                'order_id'          => $order->id,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'nama_rekening'     => null,
                'jumlah_transfer'   => $totalHarga,
                'status_pembayaran' => Payment::STATUS_PENDING,
                'batas_bayar'       => now()->addDay(),
            ]);
 
            // Kosongkan cart
            $cart->items()->delete();
 
            DB::commit();
 
            return redirect()->route('orders.confirmation', $order->id);
 
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
 
    /**
     * Tampilkan halaman upload bukti transfer.
     */
    public function uploadProofPage(Payment $payment)
    {
        abort_if($payment->order->user_id !== auth()->id(), 403);
        $payment->load('order.items.product');
        return view('konsumen.payment-upload', compact('payment'));
    }
 
    /**
     * Proses upload bukti transfer.
     */
    public function uploadProof(Request $request, Payment $payment)
    {
        abort_if($payment->order->user_id !== auth()->id(), 403);
 
        // ✅ cek kolom 'status_pembayaran'
        if ($payment->status_pembayaran !== Payment::STATUS_PENDING) {
            return back()->with('error', 'Pembayaran sudah diproses, tidak dapat mengupload bukti.');
        }
 
        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
 
        $path = $request->file('proof')->store('payment_proofs', 'public');
 
        // ✅ kolom payments: bukti_pembayaran, status_pembayaran, paid_at
        $payment->update([
            'bukti_pembayaran'  => $path,
            'status_pembayaran' => Payment::STATUS_WAITING_CONFIRMATION,
            'paid_at'           => now(),
        ]);
 
        return redirect()->route('orders.show', $payment->order_id)
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }
 
    /**
     * [Admin] Konfirmasi pembayaran.
     */
    public function confirm(Request $request, Payment $payment)
    {
        abort_unless($request->user()->is_admin, 403, 'Akses ditolak.');
 
        // ✅ cek kolom 'status_pembayaran'
        if (!in_array($payment->status_pembayaran, [
            Payment::STATUS_PENDING,
            Payment::STATUS_WAITING_CONFIRMATION,
        ])) {
            return back()->with('error', 'Status pembayaran tidak dapat dikonfirmasi.');
        }
 
        DB::beginTransaction();
 
        try {
            // ✅ update kolom: status_pembayaran, confirmed_at, confirmed_by
            $payment->update([
                'status_pembayaran' => Payment::STATUS_PAID,
                'confirmed_at'      => now(),
                'confirmed_by'      => $request->user()->id,
            ]);
 
            // ✅ update kolom orders: status_pesanan
            $payment->order->update(['status_pesanan' => Order::STATUS_PROCESSING]);
 
            DB::commit();
 
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengkonfirmasi pembayaran.');
        }
 
        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
 
    /**
     * [Admin] Tolak / batalkan pembayaran.
     */
    public function reject(Request $request, Payment $payment)
    {
        abort_unless($request->user()->is_admin, 403, 'Akses ditolak.');
 
        DB::beginTransaction();
 
        try {
            $payment->update(['status_pembayaran' => Payment::STATUS_CANCELLED]);
 
            $order = $payment->order;
 
            // ✅ kembalikan stok — kolom 'stok'
            foreach ($order->items as $item) {
                $item->product->increment('stok', $item->quantity);
            }
 
            // ✅ kolom orders: status_pesanan
            $order->update(['status_pesanan' => Order::STATUS_CANCELLED]);
 
            DB::commit();
 
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menolak pembayaran.');
        }
 
        return back()->with('success', 'Pembayaran ditolak dan stok dikembalikan.');
    }
 
    /**
     * [User] Batalkan pembayaran sendiri.
     */
    public function cancel(Request $request, Payment $payment)
    {
        abort_if(
            $payment->order->user_id !== $request->user()->id,
            403,
            'Akses tidak diizinkan.'
        );
 
        // ✅ cek status_pembayaran
        if (!in_array($payment->status_pembayaran, [
            Payment::STATUS_PENDING,
            Payment::STATUS_WAITING_CONFIRMATION,
        ])) {
            return back()->with('error', 'Pembayaran tidak dapat dibatalkan.');
        }
 
        DB::beginTransaction();
 
        try {
            $payment->update(['status_pembayaran' => Payment::STATUS_CANCELLED]);
 
            $order = $payment->order;
 
            foreach ($order->items as $item) {
                $item->product->increment('stok', $item->quantity);
            }
 
            $order->update(['status_pesanan' => Order::STATUS_CANCELLED]);
 
            DB::commit();
 
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membatalkan pembayaran.');
        }
 
        return redirect()->route('orders.index')
            ->with('success', 'Pembayaran dan pesanan berhasil dibatalkan.');
    }
 
    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------
 
    private function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(Str::random(8)) . '-' . now()->format('Ymd');
    }
}
 