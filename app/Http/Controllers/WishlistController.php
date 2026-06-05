<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Toggle wishlist — tambah kalau belum ada, hapus kalau sudah ada.
     */
    public function toggle(Request $request, $productId): \Illuminate\Http\JsonResponse
    {
        $product = Product::findOrFail($productId);

        $wishlist = Wishlist::where('user_id', $request->user()->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $wishlisted = false;
            $message    = 'Produk dihapus dari favorit.';
        } else {
            Wishlist::create([
                'user_id'    => $request->user()->id,
                'product_id' => $productId,
            ]);
            $wishlisted = true;
            $message    = 'Produk ditambahkan ke favorit.';
        }

        return response()->json([
            'success'    => true,
            'wishlisted' => $wishlisted,
            'message'    => $message,
        ]);
    }

    /**
     * Tampilkan halaman wishlist user.
     */
    public function index(Request $request)
    {
        $wishlists = Wishlist::with('product.category')
                             ->where('user_id', $request->user()->id)
                             ->latest()
                             ->get();

        return view('konsumen.wishlist', compact('wishlists'));
    }
}