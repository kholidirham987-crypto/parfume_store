<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // STATISTIK UTAMA
        // ==========================================

        $jumlahProduk = Product::count();
        $jumlahKategori = Category::count();
        $jumlahMerek = Brand::count();
        $jumlahPesanan = Order::count();


        // ==========================================
        // DATA DIAGRAM BATANG
        // JUMLAH PRODUK PER KATEGORI
        // ==========================================

        $produkPerKategori = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->get();

        $kategoriLabels = $produkPerKategori
            ->pluck('nama_kategori')
            ->values();

        $kategoriData = $produkPerKategori
            ->pluck('products_count')
            ->values();


        // ==========================================
        // DATA DIAGRAM LINGKARAN
        // STATUS PESANAN
        // ==========================================

        $statusLabels = [
            'Pending',
            'Lunas',
            'Batal',
        ];

        $statusData = [
            Order::where('status', 'Pending')->count(),
            Order::where('status', 'Lunas')->count(),
            Order::where('status', 'Batal')->count(),
        ];


        // ==========================================
        // PESANAN TERBARU
        // ==========================================

        $pesananTerbaru = Order::latest()
            ->take(5)
            ->get();


        // ==========================================
        // STOK RENDAH
        // ==========================================

        $stokRendah = Product::with(['category', 'brand'])
            ->where('stok', '<=', 5)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();


        return view('admin.dashboard', compact(
            'jumlahProduk',
            'jumlahKategori',
            'jumlahMerek',
            'jumlahPesanan',
            'kategoriLabels',
            'kategoriData',
            'statusLabels',
            'statusData',
            'pesananTerbaru',
            'stokRendah'
        ));
    }
}