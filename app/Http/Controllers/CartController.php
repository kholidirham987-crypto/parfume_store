<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan keranjang customer
     */
    public function index()
    {
        $carts = auth()->user()
            ->carts()
            ->with('product')
            ->latest()
            ->get();

        $subtotal = $carts->sum('total_harga');

        return view('customer.cart.index', compact('carts', 'subtotal'));

    }
    /**
     * Menambahkan produk ke keranjang
     */
    public function add(Product $product)
    {
        $user = auth()->user();

        // Pastikan stok tersedia
        if ($product->stok < 1) {
            return back()->with(
                'error',
                'Produk sedang habis.'
            );
        }

        // Cari cart milik customer yang sedang login
        $cart = $user->carts()
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {

            $jumlahBaru = $cart->jumlah + 1;

            // Jangan melebihi stok
            if ($jumlahBaru > $product->stok) {
                return back()->with(
                    'error',
                    'Jumlah melebihi stok produk.'
                );
            }

            $cart->update([
                'jumlah' => $jumlahBaru,
                'total_harga' => $product->harga * $jumlahBaru,
            ]);

        } else {

            $user->carts()->create([
                'product_id' => $product->id,
                'jumlah' => 1,
                'total_harga' => $product->harga,
            ]);
        }

        return back()->with(
            'success',
            $product->nama_produk .
            ' berhasil ditambahkan ke keranjang.'
        );
    }


    /**
     * Mengubah jumlah produk di keranjang
     */
    public function update(Request $request, Cart $cart)
    {
        // Pastikan cart milik customer yang sedang login
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'jumlah' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        // Pastikan product masih tersedia
        if (!$cart->product) {
            return back()->with(
                'error',
                'Produk tidak ditemukan.'
            );
        }

        // Jangan melebihi stok
        if ($request->jumlah > $cart->product->stok) {
            return back()->with(
                'error',
                'Jumlah melebihi stok produk.'
            );
        }

        $cart->update([
            'jumlah' => $request->jumlah,
            'total_harga' => $cart->product->harga * $request->jumlah,
        ]);

        return back()->with(
            'success',
            'Jumlah produk berhasil diperbarui.'
        );
    }


    /**
     * Menghapus produk dari keranjang
     */
    public function destroy(Cart $cart)
    {
        // Pastikan cart milik customer yang sedang login
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with(
            'success',
            'Produk berhasil dihapus dari keranjang.'
        );
    }
}