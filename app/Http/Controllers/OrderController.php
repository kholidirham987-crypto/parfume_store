<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN - DAFTAR PESANAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Order::with('user')
            ->latest();

        // Pencarian berdasarkan kode, penerima, atau nama customer.
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                    ->orWhere('nama_penerima', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter status pesanan.
        $allowedStatuses = [
            'menunggu_verifikasi',
            'diproses',
            'dikirim',
            'selesai',
            'dibatalkan',
        ];

        if (
            $request->filled('status') &&
            in_array($request->status, $allowedStatuses, true)
        ) {
            $query->where('status_pesanan', $request->status);
        }

        // Filter metode pembayaran.
        if (
            $request->filled('metode_pembayaran') &&
            in_array($request->metode_pembayaran, ['dana', 'cod'], true)
        ) {
            $query->where(
                'metode_pembayaran',
                $request->metode_pembayaran
            );
        }

        $orders = $query
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - HALAMAN CHECKOUT
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $user = auth()->user();

        $carts = $user->carts()
            ->with('product')
            ->latest()
            ->get();

        if ($carts->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        foreach ($carts as $cart) {
            if (!$cart->product) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', 'Ada produk dalam keranjang yang sudah tidak tersedia.');
            }

            if ($cart->jumlah < 1 || $cart->jumlah > $cart->product->stok) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        'Stok ' . $cart->product->nama_produk .
                        ' tidak mencukupi. Stok tersedia: ' .
                        $cart->product->stok . '.'
                    );
            }
        }

        // Hitung dari harga dan jumlah terkini.
        $subtotal = $carts->sum(
            fn ($cart) => $cart->product->harga * $cart->jumlah
        );

        $ongkir = 10000;
        $total = $subtotal + $ongkir;

        return view(
            'customer.checkout.create',
            compact('carts', 'subtotal', 'ongkir', 'total')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - MEMBUAT PESANAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kurir' => 'required|in:JNE,J&T,SiCepat',
            'layanan_kurir' => 'required|string|max:255',
            'metode_pembayaran' => 'required|in:dana,cod',
            'catatan_customer' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        try {
            $order = DB::transaction(function () use ($data, $user) {
                // Ambil dan kunci keranjang milik user.
                $carts = $user->carts()
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get();

                if ($carts->isEmpty()) {
                    throw new \RuntimeException(
                        'Keranjang masih kosong.'
                    );
                }

                $subtotal = 0;
                $items = [];

                /*
                 * Validasi SEMUA produk terlebih dahulu.
                 * Tidak ada pesanan yang dibuat jika satu saja
                 * produk tidak memenuhi stok.
                 */
                foreach ($carts as $cart) {
                    if ($cart->jumlah < 1) {
                        throw new \RuntimeException(
                            'Jumlah produk harus minimal 1.'
                        );
                    }

                    $product = Product::whereKey($cart->product_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        throw new \RuntimeException(
                            'Ada produk dalam keranjang yang sudah tidak tersedia.'
                        );
                    }

                    if ($product->stok < $cart->jumlah) {
                        throw new \RuntimeException(
                            'Stok ' . $product->nama_produk .
                            ' tidak mencukupi. Stok tersedia: ' .
                            $product->stok .
                            ', jumlah yang dipesan: ' .
                            $cart->jumlah . '.'
                        );
                    }

                    $harga = $product->harga;
                    $jumlah = $cart->jumlah;
                    $itemSubtotal = $harga * $jumlah;

                    $subtotal += $itemSubtotal;

                    $items[] = [
                        'product' => $product,
                        'jumlah' => $jumlah,
                        'harga' => $harga,
                        'subtotal' => $itemSubtotal,
                    ];
                }

                $ongkir = 10000;
                $total = $subtotal + $ongkir;

                do {
                    $kodePesanan = 'ORD-' .
                        now()->format('YmdHis') . '-' .
                        strtoupper(Str::random(4));
                } while (
                    Order::where('kode_pesanan', $kodePesanan)->exists()
                );

                if ($data['metode_pembayaran'] === 'dana') {
                    $statusPembayaran = 'menunggu_verifikasi';
                    $statusPesanan = 'menunggu_verifikasi';
                } else {
                    $statusPembayaran = 'belum_dibayar';
                    $statusPesanan = 'diproses';
                }

                // Buat pesanan setelah seluruh stok tervalidasi.
                $order = Order::create([
                    'user_id' => $user->id,
                    'kode_pesanan' => $kodePesanan,
                    'nama_penerima' => $data['nama_penerima'],
                    'no_hp' => $data['no_hp'],
                    'alamat' => $data['alamat'],
                    'kota' => $data['kota'],
                    'kecamatan' => $data['kecamatan'],
                    'kurir' => $data['kurir'],
                    'layanan_kurir' => $data['layanan_kurir'],
                    'ongkir' => $ongkir,
                    'subtotal' => $subtotal,
                    'total_harga' => $total,
                    'metode_pembayaran' => $data['metode_pembayaran'],
                    'status_pembayaran' => $statusPembayaran,
                    'status_pesanan' => $statusPesanan,
                    'bukti_pembayaran' => null,
                    'catatan_customer' => $data['catatan_customer'] ?? null,
                    'catatan_admin' => null,
                ]);

                // Simpan detail pesanan dan kurangi stok.
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'jumlah' => $item['jumlah'],
                        'harga' => $item['harga'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    $item['product']->decrement(
                        'stok',
                        $item['jumlah']
                    );
                }

                // Hapus keranjang hanya setelah semua proses berhasil.
                $user->carts()->delete();

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - DAFTAR PESANAN
    |--------------------------------------------------------------------------
    */

    public function customerOrders(Request $request)
    {
        $query = auth()->user()
            ->orders()
            ->with('items.product')
            ->latest();

        $allowedStatuses = [
            'menunggu_verifikasi',
            'diproses',
            'dikirim',
            'selesai',
            'dibatalkan',
        ];

        $status = $request->query('status');

        if ($status && in_array($status, $allowedStatuses, true)) {
            $query->where('status_pesanan', $status);
        }

        $orders = $query->get();

        return view('customer.orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - DETAIL PESANAN
    |--------------------------------------------------------------------------
    */

    public function customerShow(Order $order)
    {
        abort_unless(
            (int) $order->user_id === (int) auth()->id(),
            403
        );

        $order->load('items.product');

        return view('customer.orders.show', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - BATALKAN PESANAN
    |--------------------------------------------------------------------------
    */

    public function cancel(Order $order)
    {
        abort_unless(
            (int) $order->user_id === (int) auth()->id(),
            403
        );

        $buktiLama = null;

        try {
            DB::transaction(function () use ($order, &$buktiLama) {
                $pesanan = Order::whereKey($order->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                abort_unless(
                    (int) $pesanan->user_id === (int) auth()->id(),
                    403
                );

                if ($pesanan->status_pesanan !== 'menunggu_verifikasi') {
                    throw new \RuntimeException(
                        'Pesanan tidak dapat dibatalkan karena statusnya sudah berubah.'
                    );
                }

                $items = OrderItem::where('order_id', $pesanan->id)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get();

                // Kunci semua produk dan pastikan datanya tersedia.
                $products = [];

                foreach ($items as $item) {
                    $product = Product::whereKey($item->product_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        throw new \RuntimeException(
                            'Produk pesanan tidak ditemukan. Hubungi admin.'
                        );
                    }

                    $products[] = [
                        'product' => $product,
                        'jumlah' => $item->jumlah,
                    ];
                }

                foreach ($products as $entry) {
                    $entry['product']->increment(
                        'stok',
                        $entry['jumlah']
                    );
                }

                $buktiLama = $pesanan->bukti_pembayaran;

                $pesanan->update([
                    'status_pesanan' => 'dibatalkan',
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        if (
            $buktiLama &&
            Storage::disk('public')->exists($buktiLama)
        ) {
            Storage::disk('public')->delete($buktiLama);
        }

        return redirect()
            ->route('customer.orders.show', $order)
            ->with(
                'success',
                'Pesanan berhasil dibatalkan dan stok telah dikembalikan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - UPLOAD BUKTI PEMBAYARAN DANA
    |--------------------------------------------------------------------------
    */

    public function uploadPaymentProof(Request $request, Order $order)
    {
        abort_unless(
            (int) $order->user_id === (int) auth()->id(),
            403
        );

        if ($order->metode_pembayaran !== 'dana') {
            return back()->with(
                'error',
                'Upload bukti pembayaran hanya tersedia untuk DANA.'
            );
        }

        if (!in_array(
            $order->status_pesanan,
            ['menunggu_verifikasi'],
            true
        ) || !in_array(
            $order->status_pembayaran,
            ['menunggu_verifikasi', 'ditolak'],
            true
        )) {
            return back()->with(
                'error',
                'Pesanan ini tidak dapat menerima bukti pembayaran.'
            );
        }

        $data = $request->validate([
            'bukti_pembayaran' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $path = $request->file('bukti_pembayaran')
            ->store('payment-proofs', 'public');

        $buktiLama = $order->bukti_pembayaran;

        $order->update([
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'menunggu_verifikasi',
            'status_pesanan' => 'menunggu_verifikasi',
        ]);

        if (
            $buktiLama &&
            Storage::disk('public')->exists($buktiLama)
        ) {
            Storage::disk('public')->delete($buktiLama);
        }

        return back()->with(
            'success',
            'Bukti pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOMER - KONFIRMASI PESANAN DITERIMA (COD)
    |--------------------------------------------------------------------------
    */

    public function received(Order $order)
    {
        abort_unless(
            (int) $order->user_id === (int) auth()->id(),
            403
        );

        if ($order->metode_pembayaran !== 'cod') {
            abort(403);
        }

        if ($order->status_pesanan !== 'dikirim') {
            return back()->with(
                'error',
                'Pesanan belum dapat dikonfirmasi sebagai diterima.'
            );
        }

        $order->update([
            'status_pesanan' => 'selesai',
            'status_pembayaran' => 'dibayar',
        ]);

        return back()->with(
            'success',
            'Pesanan berhasil dikonfirmasi diterima.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - DETAIL PESANAN
    |--------------------------------------------------------------------------
    */

    public function show(Order $order)
    {
        $order->load('user', 'items.product');

        return view('admin.orders.show', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - VERIFIKASI DANA
    |--------------------------------------------------------------------------
    */

    public function verifyPayment(Order $order)
    {
        if ($order->metode_pembayaran !== 'dana') {
            return back()->with(
                'error',
                'Pesanan ini bukan pembayaran DANA.'
            );
        }

        if (!$order->bukti_pembayaran) {
            return back()->with(
                'error',
                'Bukti pembayaran belum diupload customer.'
            );
        }

        if (
            $order->status_pesanan !== 'menunggu_verifikasi' ||
            !in_array(
                $order->status_pembayaran,
                ['menunggu_verifikasi'],
                true
            )
        ) {
            return back()->with(
                'error',
                'Pesanan ini tidak lagi menunggu verifikasi pembayaran.'
            );
        }

        $order->update([
            'status_pembayaran' => 'terverifikasi',
            'status_pesanan' => 'diproses',
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with(
                'success',
                'Pembayaran DANA berhasil diverifikasi. Pesanan masuk proses.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - TOLAK BUKTI DANA
    |--------------------------------------------------------------------------
    */

    public function rejectPayment(Request $request, Order $order)
    {
        if ($order->metode_pembayaran !== 'dana') {
            return back()->with(
                'error',
                'Pesanan ini bukan pembayaran DANA.'
            );
        }

        if ($order->status_pesanan !== 'menunggu_verifikasi') {
            return back()->with(
                'error',
                'Pesanan ini tidak lagi menunggu verifikasi.'
            );
        }

        $data = $request->validate([
            'catatan_admin' => 'required|string|max:1000',
        ]);

        $buktiLama = $order->bukti_pembayaran;

        $order->update([
            'bukti_pembayaran' => null,
            'status_pembayaran' => 'ditolak',
            'catatan_admin' => $data['catatan_admin'],
        ]);

        if (
            $buktiLama &&
            Storage::disk('public')->exists($buktiLama)
        ) {
            Storage::disk('public')->delete($buktiLama);
        }

        return redirect()
            ->route('orders.show', $order)
            ->with(
                'success',
                'Bukti pembayaran ditolak. Customer dapat mengupload ulang.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - FORM EDIT PESANAN
    |--------------------------------------------------------------------------
    */

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - UPDATE PESANAN
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status_pesanan' =>
                'required|in:menunggu_verifikasi,diproses,dikirim,selesai,dibatalkan',
            'status_pembayaran' =>
                'required|in:menunggu_verifikasi,terverifikasi,ditolak,belum_dibayar,dibayar',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        // Status dibatalkan harus lewat mekanisme pembatalan khusus
        // agar stok dikembalikan dengan benar.
        if (
            $data['status_pesanan'] === 'dibatalkan' &&
            $order->status_pesanan !== 'dibatalkan'
        ) {
            return back()->with(
                'error',
                'Gunakan mekanisme pembatalan khusus agar stok dikembalikan dengan benar.'
            );
        }

        $statusPesanan = $data['status_pesanan'];
        $statusPembayaran = $data['status_pembayaran'];

        if (
            $statusPesanan === 'diproses' &&
            $order->metode_pembayaran === 'dana'
        ) {
            $statusPembayaran = 'terverifikasi';
        }

        if ($statusPesanan === 'selesai') {
            $statusPembayaran = 'dibayar';
        }

        $order->update([
            'status_pesanan' => $statusPesanan,
            'status_pembayaran' => $statusPembayaran,
            'catatan_admin' => $data['catatan_admin'] ?? null,
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN - HAPUS PESANAN
    |--------------------------------------------------------------------------
    */

    public function customerDestroy(Order $order)
    {
        // Pastikan pesanan milik customer yang sedang login.
        abort_unless($order->user_id === auth()->id(), 403);

        // Hanya pesanan selesai atau dibatalkan yang boleh dihapus.
        if (!in_array($order->status_pesanan, ['selesai', 'dibatalkan'], true)) {
            return back()->with(
                'error',
                'Pesanan hanya dapat dihapus jika sudah selesai atau dibatalkan.'
            );
        }

        DB::transaction(function () use ($order) {
            $order->load('items');

            // Hapus bukti pembayaran jika ada.
            if ($order->bukti_pembayaran) {
                Storage::disk('public')->delete($order->bukti_pembayaran);
            }

            // Hapus detail produk terlebih dahulu.
            $order->items()->delete();

            // Hapus pesanan.
            $order->delete();
        });

        return redirect()
            ->route('customer.orders')
            ->with('success', 'Riwayat pesanan berhasil dihapus.');
    }
}