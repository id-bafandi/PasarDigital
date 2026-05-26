<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjualController extends Controller
{
    public function dashboard()
    {
        $totalProduk  = Product::where('seller_id', Auth::id())->count();
        $totalTerjual = Product::where('seller_id', Auth::id())
                               ->withSum('orderItems', 'jumlah')
                               ->get()
                               ->sum('order_items_sum_jumlah');
        $produkTerbaru = Product::with('category')
                               ->where('seller_id', Auth::id())
                               ->latest()
                               ->take(5)
                               ->get();

        return view('penjual.dashboard', compact('totalProduk', 'totalTerjual', 'produkTerbaru'));
    }

    public function products()
    {
        $products = Product::with('category')
                           ->where('seller_id', Auth::id())
                           ->latest()
                           ->paginate(20);

        return view('penjual.products', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('penjual.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'deskripsi'   => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['seller_id'] = Auth::id();

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['gambar'] = $filename;
        }

        Product::create($validated);

        return redirect()->route('penjual.products')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        abort_if($product->seller_id !== Auth::id(), 403);
        $categories = Category::all();
        return view('penjual.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        abort_if($product->seller_id !== Auth::id(), 403);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:150',
            'deskripsi'   => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validated['gambar'] = $filename;
        }

        $product->update($validated);

        return redirect()->route('penjual.products')
            ->with('success', 'Produk berhasil diupdate.');
    }

    public function delete(Product $product)
    {
        abort_if($product->seller_id !== Auth::id(), 403);
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}