<?php
 
namespace App\Http\Controllers;
 
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
 
class PaymentController extends Controller
{
    /**
     * Buat order baru dari cart + pilih metode pembayaran.
     */
    public function checkout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'payment_method'   => 'required|in:cod,transfer_bank,transfer_ewallet',
            'shipping_address' => 'required|string|max:500',
            'notes'            => 'nullable|string|max:255',
        ]);
 
        $cart = Cart::with('items.product')
            ->where('user_id', $request->user()->id)
            ->first();
 
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart kosong. Tambahkan produk terlebih dahulu.',
            ], 422);
        }
 
        // Cek stok semua item sebelum proses
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok produk '{$item->product->name}' tidak mencukupi.",
                ], 422);
            }
        }
 
        DB::beginTransaction();
 
        try {
            $totalAmount = $cart->items->sum(fn($i) => $i->price * $i->quantity);
 
            // Buat order
            $order = Order::create([
                'user_id'          => $request->user()->id,
                'order_number'     => $this->generateOrderNumber(),
                'status'           => 'pending',
                'total_amount'     => $totalAmount,
                'shipping_address' => $validated['shipping_address'],
                'notes'            => $validated['notes'] ?? null,
            ]);
 
            // Salin item dari cart ke order
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'subtotal'   => $item->price * $item->quantity,
                ]);
 
                // Kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }
 
            // Buat record pembayaran
            $payment = Payment::create([
                'order_id'       => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount'         => $totalAmount,
                'status'         => 'pending',
                'due_date'       => now()->addDays(1),
            ]);
 
            // Kosongkan cart setelah checkout
            $cart->items()->delete();
 
            DB::commit();
 
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat.',
                'data'    => [
                    'order'           => $order->load('items.product'),
                    'payment'         => $payment,
                    'payment_info'    => $this->getPaymentInfo($validated['payment_method'], $totalAmount),
                ],
            ], 201);
 
        } catch (\Throwable $e) {
            DB::rollBack();
 
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan. Silakan coba lagi.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
 
    /**
     * Upload bukti pembayaran (untuk transfer bank / e-wallet).
     */
    public function uploadProof(Request $request, Payment $payment): JsonResponse
    {
        $this->authorizePayment($request, $payment);
 
        if ($payment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran sudah diproses, tidak dapat mengupload bukti.',
            ], 422);
        }
 
        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
 
        $path = $request->file('proof')->store('payment_proofs', 'public');
 
        $payment->update([
            'proof_image' => $path,
            'status'      => 'waiting_confirmation',
            'paid_at'     => now(),
        ]);
 
        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.',
            'data'    => $payment->fresh(),
        ]);
    }
 
    /**
     * Konfirmasi pembayaran (khusus admin).
     */
    public function confirm(Request $request, Payment $payment): JsonResponse
    {
        // Pastikan yang mengakses adalah admin
        abort_unless($request->user()->is_admin, 403, 'Akses ditolak.');
 
        if (!in_array($payment->status, ['pending', 'waiting_confirmation'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status pembayaran tidak dapat dikonfirmasi.',
            ], 422);
        }
 
        DB::beginTransaction();
 
        try {
            $payment->update([
                'status'       => 'paid',
                'confirmed_at' => now(),
                'confirmed_by' => $request->user()->id,
            ]);
 
            $payment->order->update(['status' => 'processing']);
 
            DB::commit();
 
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikonfirmasi.',
                'data'    => $payment->load('order'),
            ]);
 
        } catch (\Throwable $e) {
            DB::rollBack();
 
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengkonfirmasi pembayaran.',
            ], 500);
        }
    }
 
    /**
     * Batalkan pembayaran / order.
     */
    public function cancel(Request $request, Payment $payment): JsonResponse
    {
        $this->authorizePayment($request, $payment);
 
        if (!in_array($payment->status, ['pending', 'waiting_confirmation'])) {
            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak dapat dibatalkan.',
            ], 422);
        }
 
        DB::beginTransaction();
 
        try {
            $payment->update(['status' => 'cancelled']);
 
            $order = $payment->order;
 
            // Kembalikan stok
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
 
            $order->update(['status' => 'cancelled']);
 
            DB::commit();
 
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran dan pesanan berhasil dibatalkan.',
            ]);
 
        } catch (\Throwable $e) {
            DB::rollBack();
 
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan pembayaran.',
            ], 500);
        }
    }
 
    /**
     * Detail pembayaran.
     */
    public function show(Request $request, Payment $payment): JsonResponse
    {
        $this->authorizePayment($request, $payment);
 
        return response()->json([
            'success' => true,
            'data'    => $payment->load('order.items.product'),
        ]);
    }
 
    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------
 
    private function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(Str::random(8)) . '-' . now()->format('Ymd');
    }
 
    private function getPaymentInfo(string $method, float $amount): array
    {
        return match ($method) {
            'cod' => [
                'instruction' => 'Bayar tunai saat pesanan tiba di alamat Anda.',
                'amount'      => $amount,
            ],
            'transfer_bank' => [
                'instruction'    => 'Transfer ke rekening berikut, lalu upload bukti pembayaran.',
                'bank_name'      => config('payment.bank_name', 'BCA'),
                'account_number' => config('payment.bank_account', '1234567890'),
                'account_name'   => config('payment.bank_holder', 'Nama Toko'),
                'amount'         => $amount,
            ],
            'transfer_ewallet' => [
                'instruction'    => 'Transfer ke e-wallet berikut, lalu upload bukti pembayaran.',
                'ewallet'        => config('payment.ewallet_type', 'GoPay'),
                'phone_number'   => config('payment.ewallet_number', '08123456789'),
                'account_name'   => config('payment.ewallet_holder', 'Nama Toko'),
                'amount'         => $amount,
            ],
            default => [],
        };
    }
 
    private function authorizePayment(Request $request, Payment $payment): void
    {
        abort_if(
            $payment->order->user_id !== $request->user()->id && !$request->user()->is_admin,
            403,
            'Akses tidak diizinkan.'
        );
    }
}
 