<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = Cart::with('items.product')
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('konsumen.cart')
                ->with('error', 'Keranjang belanjamu masih kosong.');
        }

        $subtotal = $cart->items->sum(fn($item) => $item->price * $item->quantity);
        $ongkir   = 0;
        $total    = $subtotal + $ongkir;
        $user     = $request->user();

        return view('konsumen.checkout', compact('cart', 'subtotal', 'ongkir', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penerima'     => 'required|string|max:100',
            'no_telepon'        => 'required|string|max:20',
            'alamat_pengiriman' => 'required|string|max:500',
            'catatan'           => 'nullable|string|max:300',
        ]);

        $cart = Cart::with('items.product')
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('konsumen.cart')
                ->with('error', 'Keranjang belanjamu masih kosong.');
        }

        foreach ($cart->items as $item) {
            if ($item->product->stok < $item->quantity) {
                return redirect()->route('konsumen.cart')
                    ->with('error', "Stok \"{$item->product->nama_produk}\" tidak mencukupi.");
            }
        }

        DB::beginTransaction();
        try {
            $total = $cart->items->sum(fn($i) => $i->price * $i->quantity);

            $order = Order::create([
                'user_id'           => $request->user()->id,
                'order_number'      => $this->generateOrderNumber(),
                'total_price'       => $total,
                'status'            => 'pending',
                'metode_pembayaran' => $request->metode_pembayaran ?? 'qris',
                'alamat_pengiriman' => $validated['nama_penerima'] . "\n"
                                     . $validated['no_telepon'] . "\n"
                                     . $validated['alamat_pengiriman'],
                'catatan'           => $validated['catatan'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'jumlah'     => $item->quantity,
                    'harga'      => $item->price,
                ]);

                $item->product->decrement('stok', $item->quantity);
            }

            $cart->items()->delete();

            DB::commit();

            return redirect()->route('konsumen.payment', ['order' => $order->id])
                ->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    private function generateOrderNumber(): string
    {
        $prefix = 'ORD-' . now()->format('Ymd') . '-';
        $last   = Order::where('order_number', 'like', $prefix . '%')
                       ->orderByDesc('id')
                       ->first();

        $seq = $last ? (int) substr($last->order_number, -4) + 1 : 1;

        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}