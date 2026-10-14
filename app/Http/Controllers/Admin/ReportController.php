<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_akhir' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_mulai',
            ],
        ]);

        $tanggalMulai = $request->input(
            'tanggal_mulai',
            now()->startOfMonth()->toDateString()
        );

        $tanggalAkhir = $request->input(
            'tanggal_akhir',
            now()->toDateString()
        );

        $query = Order::with('user')
            ->whereDate('created_at', '>=', $tanggalMulai)
            ->whereDate('created_at', '<=', $tanggalAkhir);

        $pesananSelesai = (clone $query)
            ->where('status_pesanan', 'selesai')
            ->latest()
            ->get();

        $totalPenjualan = $pesananSelesai->sum('total_harga');
        $jumlahTransaksi = $pesananSelesai->count();

        $rataRataTransaksi = $jumlahTransaksi > 0
            ? $totalPenjualan / $jumlahTransaksi
            : 0;

        $menungguVerifikasi = (clone $query)
            ->where('status_pesanan', 'menunggu_verifikasi')
            ->count();

        $totalDana = $pesananSelesai
            ->where('metode_pembayaran', 'dana')
            ->sum('total_harga');

        $totalCod = $pesananSelesai
            ->where('metode_pembayaran', 'cod')
            ->sum('total_harga');

        $transaksiHarian = $pesananSelesai
            ->groupBy(fn ($order) => $order->created_at->format('Y-m-d'))
            ->map(fn ($orders, $tanggal) => [
                'tanggal' => $tanggal,
                'jumlah' => $orders->count(),
                'total' => $orders->sum('total_harga'),
            ])
            ->sortKeys()
            ->values();

        return view('admin.reports.index', compact(
            'tanggalMulai',
            'tanggalAkhir',
            'pesananSelesai',
            'totalPenjualan',
            'jumlahTransaksi',
            'rataRataTransaksi',
            'menungguVerifikasi',
            'totalDana',
            'totalCod',
            'transaksiHarian'
        ));
    }
}
