<?php
 
namespace App\Http\Controllers;
 
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
 
class CartController extends Controller
{
    /**
     * Ambil cart milik user yang sedang login.
     */
    public function index(Request $request): JsonResponse
    {
        $cart = Cart::with('items.product')
            ->firstOrCreate(['user_id' => $request->user()->id]);
 
        return response()->json([
            'success' => true,
            'data'    => [
                'cart'       => $cart,
                'total_price' => $this->calculateTotal($cart),
                'total_items' => $cart->items->sum('quantity'),
            ],
        ]);
    }
 
    /**
     * Tambahkan produk ke cart.
     */
    public function addItem(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);
 
        $product = Product::findOrFail($validated['product_id']);
 
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi.',
            ], 422);
        }
 
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
 
        $cartItem = $cart->items()->where('product_id', $product->id)->first();
 
        if ($cartItem) {
            $newQty = $cartItem->quantity + $validated['quantity'];
 
            if ($product->stock < $newQty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi untuk jumlah tersebut.',
                ], 422);
            }
 
            $cartItem->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $validated['quantity'],
                'price'      => $product->price,
            ]);
        }
 
        $cart->load('items.product');
 
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke cart.',
            'data'    => [
                'cart'        => $cart,
                'total_price' => $this->calculateTotal($cart),
                'total_items' => $cart->items->sum('quantity'),
            ],
        ], 201);
    }
 
    /**
     * Update jumlah item di cart.
     */
    public function updateItem(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->authorizeCartItem($request, $cartItem);
 
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
 
        $product = $cartItem->product;
 
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi.',
            ], 422);
        }
 
        $cartItem->update(['quantity' => $validated['quantity']]);
 
        $cart = $cartItem->cart->load('items.product');
 
        return response()->json([
            'success' => true,
            'message' => 'Jumlah item berhasil diperbarui.',
            'data'    => [
                'cart'        => $cart,
                'total_price' => $this->calculateTotal($cart),
                'total_items' => $cart->items->sum('quantity'),
            ],
        ]);
    }
 
    /**
     * Hapus item dari cart.
     */
    public function removeItem(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->authorizeCartItem($request, $cartItem);
 
        $cart = $cartItem->cart;
        $cartItem->delete();
 
        $cart->load('items.product');
 
        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus dari cart.',
            'data'    => [
                'cart'        => $cart,
                'total_price' => $this->calculateTotal($cart),
                'total_items' => $cart->items->sum('quantity'),
            ],
        ]);
    }
 
    /**
     * Kosongkan seluruh cart.
     */
    public function clear(Request $request): JsonResponse
    {
        $cart = Cart::where('user_id', $request->user()->id)->first();
 
        if ($cart) {
            $cart->items()->delete();
        }
 
        return response()->json([
            'success' => true,
            'message' => 'Cart berhasil dikosongkan.',
        ]);
    }
 
    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------
 
    private function calculateTotal(Cart $cart): float
    {
        return $cart->items->sum(fn($item) => $item->price * $item->quantity);
    }
 
    private function authorizeCartItem(Request $request, CartItem $cartItem): void
    {
        abort_if(
            $cartItem->cart->user_id !== $request->user()->id,
            403,
            'Akses tidak diizinkan.'
        );
    }
}
 