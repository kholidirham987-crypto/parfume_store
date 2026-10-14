 @extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
@php
    $statusPesanan = $order->status_pesanan ?? '';
    $statusPembayaran = $order->status_pembayaran ?? '';

    $labelPesanan = [
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'diproses' => 'Sedang Diproses',
        'dikirim' => 'Dalam Pengiriman',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];

    $labelPembayaran = [
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'terverifikasi' => 'Terverifikasi',
        'ditolak' => 'Ditolak',
        'belum_dibayar' => 'Belum Dibayar',
        'dibayar' => 'Sudah Dibayar',
    ];
@endphp

<style>
    .admin-order { color: #332b25; }
    .admin-order .page-heading {
        display: flex; justify-content: space-between;
        align-items: center; gap: 16px; flex-wrap: wrap;
        margin-bottom: 24px;
    }
    .admin-order .page-heading h1 {
        margin: 0; font-size: 26px; font-weight: 750;
    }
    .admin-order .muted { color: #82786e; font-size: 14px; }
    .admin-order .panel {
        background: #fff; border: 1px solid #e9e1d8;
        border-radius: 14px; padding: 22px;
        margin-bottom: 20px;
    }
    .admin-order .panel h3 {
        font-size: 17px; margin: 0 0 18px;
        font-weight: 700; color: #4b382c;
    }
    .admin-order .info-grid {
        display: grid; grid-template-columns: repeat(2,minmax(0,1fr));
        gap: 16px;
    }
    .admin-order .info-item {
        min-width: 0; padding-bottom: 12px;
        border-bottom: 1px solid #f0ebe6;
    }
    .admin-order .info-label {
        display: block; font-size: 12px;
        color: #82786e; margin-bottom: 5px;
    }
    .admin-order .info-value {
        font-weight: 600; overflow-wrap: anywhere;
    }
    .admin-order .badge-status {
        display: inline-block; padding: 7px 11px;
        border-radius: 20px; font-size: 12px; font-weight: 700;
        background: #f5ead9; color: #815c27;
    }
    .admin-order .table-wrap { overflow-x: auto; }
    .admin-order table {
        width: 100%; border-collapse: collapse; min-width: 520px;
    }
    .admin-order th, .admin-order td {
        padding: 12px; text-align: left;
        border-bottom: 1px solid #eee8e2; vertical-align: middle;
    }
    .admin-order th {
        background: #f8f4ef; color: #6c5543; font-size: 13px;
    }
    .admin-order .total-line {
        display: flex; justify-content: space-between;
        gap: 16px; padding: 9px 0;
    }
    .admin-order .grand-total {
        border-top: 1px solid #e9e1d8; margin-top: 8px;
        padding-top: 15px; font-size: 18px; font-weight: 800;
    }
    .admin-order .field { margin-bottom: 16px; }
    .admin-order .field label {
        display: block; font-weight: 600; margin-bottom: 7px;
    }
    .admin-order .field select,
    .admin-order .field textarea {
        width: 100%; padding: 11px 12px;
        border: 1px solid #d9cfc4; border-radius: 8px;
        background: #fff; box-sizing: border-box;
    }
    .admin-order .btn-admin {
        display: inline-flex; justify-content: center; align-items: center;
        padding: 10px 15px; border-radius: 8px;
        border: 0; text-decoration: none; cursor: pointer;
        font-weight: 650; font-size: 14px;
    }
    .admin-order .btn-primary { background: #684832; color: #fff; }
    .admin-order .btn-light { background: #eee8e1; color: #44372d; }
    .admin-order .btn-danger { background: #a63e36; color: #fff; }
    .admin-order .alert {
        padding: 12px 15px; border-radius: 9px; margin-bottom: 16px;
    }
    .admin-order .alert-success { background: #e7f5e9; color: #28623a; }
    .admin-order .alert-error { background: #fdebea; color: #9a302b; }
    @media(max-width:650px) {
        .admin-order .info-grid { grid-template-columns: 1fr; }
        .admin-order .panel { padding: 16px; }
        .admin-order .page-heading h1 { font-size: 22px; }
    }
</style>

<div class="admin-order">
    <div class="page-heading">
        <div>
            <h1>Detail Pesanan</h1>
            <p class="muted">
                Kode: {{ $order->kode_pesanan ?? '#'.$order->id }}
            </p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn-admin btn-light">
            &larr; Kembali ke Daftar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:20px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <h3>Ringkasan Pesanan</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nomor Pesanan</span>
                <div class="info-value">
                    {{ $order->kode_pesanan ?? '#'.$order->id }}
                </div>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Pesanan</span>
                <div class="info-value">
                    {{ optional($order->created_at)->format('d M Y, H:i') ?? '-' }}
                </div>
            </div>
            <div class="info-item">
                <span class="info-label">Status Pesanan</span>
                <span class="badge-status">
                    {{ $labelPesanan[$statusPesanan] ?? $statusPesanan }}
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Status Pembayaran</span>
                <span class="badge-status">
                    {{ $labelPembayaran[$statusPembayaran] ?? $statusPembayaran }}
                </span>
            </div>
        </div>
    </div>

    <div class="panel">
        <h3>Informasi Customer</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nama Akun</span>
                <div class="info-value">{{ $order->user->name ?? '-' }}</div>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <div class="info-value">{{ $order->user->email ?? '-' }}</div>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Penerima</span>
                <div class="info-value">{{ $order->nama_penerima ?? '-' }}</div>
            </div>
            <div class="info-item">
                <span class="info-label">Nomor HP</span>
                <div class="info-value">{{ $order->no_hp ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="panel">
        <h3>Informasi Pengiriman</h3>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Kurir</span>
                <div class="info-value">
                    {{ $order->kurir ?? '-' }}
                    @if($order->layanan_kurir)
                        — {{ $order->layanan_kurir }}
                    @endif
                </div>
            </div>
            <div class="info-item">
                <span class="info-label">Kota / Kecamatan</span>
                <div class="info-value">
                    {{ $order->kota ?? '-' }} / {{ $order->kecamatan ?? '-' }}
                </div>
            </div>
            <div class="info-item" style="grid-column:1/-1">
                <span class="info-label">Alamat Lengkap</span>
                <div class="info-value">{{ $order->alamat ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="panel">
        <h3>Produk yang Dipesan</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $item)
                        <tr>
                            <td>{{ $item->product->nama_produk ?? 'Produk tidak tersedia' }}</td>
                            <td>Rp {{ number_format((float)$item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp {{ number_format((float)$item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada detail produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <h3>Ringkasan Pembayaran</h3>
        <div class="total-line">
            <span>Subtotal Produk</span>
            <strong>Rp {{ number_format((float)$order->subtotal, 0, ',', '.') }}</strong>
        </div>
        <div class="total-line">
            <span>Ongkos Kirim</span>
            <strong>Rp {{ number_format((float)$order->ongkir, 0, ',', '.') }}</strong>
        </div>
        <div class="total-line">
            <span>Metode Pembayaran</span>
            <strong>{{ strtoupper($order->metode_pembayaran ?? '-') }}</strong>
        </div>
        <div class="total-line grand-total">
            <span>Total</span>
            <span>Rp {{ number_format((float)$order->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($order->metode_pembayaran === 'dana')
        <div class="panel">
            <h3>Verifikasi Pembayaran DANA</h3>

            @if($order->bukti_pembayaran)
                <p>
                    <a href="{{ asset('storage/'.$order->bukti_pembayaran) }}"
                       target="_blank" rel="noopener noreferrer">
                        Lihat bukti pembayaran
                    </a>
                </p>
                <img
                    src="{{ asset('storage/'.$order->bukti_pembayaran) }}"
                    alt="Bukti pembayaran DANA"
                    style="max-width:320px;width:100%;height:auto;border:1px solid #e5ddd4;border-radius:10px"
                >
            @else
                <p class="muted">Customer belum mengunggah bukti pembayaran.</p>
            @endif

            @if($statusPesanan === 'menunggu_verifikasi' && $statusPembayaran === 'menunggu_verifikasi' && $order->bukti_pembayaran)
                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:18px">
                    <form action="{{ route('orders.verify-payment', $order) }}"
                          method="POST"
                          onsubmit="return confirm('Verifikasi pembayaran ini?')">
                        @csrf
                        @method('PATCH')
                        <button class="btn-admin btn-primary" type="submit">
                            Verifikasi Pembayaran
                        </button>
                    </form>

                    <form action="{{ route('orders.reject-payment', $order) }}"
                          method="POST"
                          style="flex:1;min-width:240px"
                          onsubmit="return confirm('Tolak bukti pembayaran ini?')">
                        @csrf
                        @method('PATCH')
                        <div class="field">
                            <label for="catatan_admin">Alasan Penolakan</label>
                            <textarea id="catatan_admin" name="catatan_admin"
                                      rows="3" maxlength="1000" required
                                      placeholder="Jelaskan alasan bukti pembayaran ditolak"></textarea>
                        </div>
                        <button class="btn-admin btn-danger" type="submit">
                            Tolak Pembayaran
                        </button>
                    </form>
                </div>
            @endif

            @if($order->catatan_admin)
                <div style="margin-top:18px;padding:13px;background:#fff5e8;border-radius:8px">
                    <strong>Catatan Admin:</strong>
                    <p style="margin:6px 0 0">{{ $order->catatan_admin }}</p>
                </div>
            @endif
        </div>
    @endif

    <div class="panel">
        <h3>Kelola Status Pesanan</h3>
        <form action="{{ route('orders.update', $order) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="status_pesanan">Status Pesanan</label>
                <select id="status_pesanan" name="status_pesanan" required>
                    @foreach($labelPesanan as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('status_pesanan', $statusPesanan) === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="status_pembayaran">Status Pembayaran</label>
                <select id="status_pembayaran" name="status_pembayaran" required>
                    @foreach($labelPembayaran as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('status_pembayaran', $statusPembayaran) === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="catatan_admin">Catatan Admin</label>
                <textarea id="catatan_admin" name="catatan_admin" rows="3"
                          maxlength="1000"
                          placeholder="Catatan untuk customer">{{ old('catatan_admin', $order->catatan_admin) }}</textarea>
            </div>

            <button type="submit" class="btn-admin btn-primary">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection