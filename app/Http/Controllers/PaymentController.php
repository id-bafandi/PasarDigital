<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Upload bukti transfer (QRIS).
     */
    public function uploadProof(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $request->validate([
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('proof')->store('payment_proofs', 'public');

        // Buat atau update payment
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'bukti_pembayaran'  => $path,
                'status_pembayaran' => Payment::STATUS_WAITING_CONFIRMATION,
                'batas_bayar'       => now()->addDay(),
                'paid_at'           => now(),
            ]
        );

        return redirect()->route('konsumen.payment', ['order' => $order->id])
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi admin.');
    }

    /**
     * Konfirmasi pesanan COD oleh user.
     */
    public function confirmCod(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'status_pembayaran' => Payment::STATUS_PENDING,
                'batas_bayar'       => now()->addDays(3),
            ]
        );

        $order->update(['status' => 'paid']);

        return redirect()->route('konsumen.payment', ['order' => $order->id])
            ->with('success', 'Pesanan COD dikonfirmasi. Pesananmu sedang diproses.');
    }

    /**
     * [Admin] Konfirmasi pembayaran QRIS.
     */
    public function confirm(Request $request, Payment $payment)
    {
        abort_unless($request->user()->role === 'admin', 403);

        DB::beginTransaction();
        try {
            $payment->update([
                'status_pembayaran' => Payment::STATUS_PAID,
                'confirmed_at'      => now(),
                'confirmed_by'      => $request->user()->id,
            ]);

            $payment->order->update(['status' => 'paid']);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengkonfirmasi pembayaran.');
        }

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    /**
     * [Admin] Tolak pembayaran.
     */
    public function reject(Request $request, Payment $payment)
    {
        abort_unless($request->user()->role === 'admin', 403);

        DB::beginTransaction();
        try {
            $payment->update(['status_pembayaran' => Payment::STATUS_CANCELLED]);

            $order = $payment->order;
            foreach ($order->items as $item) {
                $item->product->increment('stok', $item->jumlah);
            }
            $order->update(['status' => Order::STATUS_CANCELLED]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menolak pembayaran.');
        }

        return back()->with('success', 'Pembayaran ditolak dan stok dikembalikan.');
    }
}
