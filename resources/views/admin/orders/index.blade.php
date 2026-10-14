@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
@php
    $statusLabels = [
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'diproses' => 'Sedang Diproses',
        'dikirim' => 'Dalam Pengiriman',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];

    $statusColors = [
        'menunggu_verifikasi' => '#fff1d6',
        'diproses' => '#dcecff',
        'dikirim' => '#e9e0ff',
        'selesai' => '#dff5e5',
        'dibatalkan' => '#fde5e3',
    ];

    $paymentLabels = [
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'terverifikasi' => 'Terverifikasi',
        'ditolak' => 'Ditolak',
        'belum_dibayar' => 'Belum Dibayar',
        'dibayar' => 'Sudah Dibayar',
    ];
@endphp

<style>
    .orders-page { color:#392d25; }
    .orders-heading {
        display:flex; justify-content:space-between;
        align-items:center; flex-wrap:wrap; gap:14px;
        margin-bottom:24px;
    }
    .orders-heading h1 {
        margin:0; font-size:27px; font-weight:750;
    }
    .orders-muted { color:#82766c; font-size:14px; }
    .orders-card {
        background:#fff; border:1px solid #e9e1d8;
        border-radius:14px; padding:20px;
        margin-bottom:20px;
    }
    .orders-filters {
        display:grid;
        grid-template-columns:minmax(200px,2fr) 1fr 1fr auto;
        gap:12px; align-items:end;
    }
    .orders-field label {
        display:block; font-size:13px;
        font-weight:650; margin-bottom:7px;
    }
    .orders-field input, .orders-field select {
        width:100%; min-width:0; box-sizing:border-box;
        border:1px solid #d9cfc4; border-radius:8px;
        padding:11px 12px; background:#fff;
        color:#392d25;
    }
    .orders-btn {
        display:inline-flex; justify-content:center;
        align-items:center; gap:6px; padding:11px 15px;
        border:0; border-radius:8px; text-decoration:none;
        cursor:pointer; font-size:13px; font-weight:700;
        white-space:nowrap;
    }
    .orders-btn-primary { background:#684832; color:#fff; }
    .orders-btn-light { background:#eee8e1; color:#49382c; }
    .orders-btn:hover { opacity:.88; }
    .orders-table-wrap { overflow-x:auto; }
    .orders-table {
        width:100%; border-collapse:collapse;
        min-width:900px;
    }
    .orders-table th {
        background:#f7f3ee; color:#6c5543;
        text-align:left; font-size:12px;
        text-transform:uppercase; letter-spacing:.3px;
        padding:14px 12px; white-space:nowrap;
    }
    .orders-table td {
        padding:15px 12px; border-bottom:1px solid #f0ebe6;
        font-size:13px; vertical-align:middle;
    }
    .orders-table tbody tr:hover { background:#fdfbf8; }
    .orders-code { font-weight:750; color:#493326; }
    .orders-status {
        display:inline-block; border-radius:20px;
        padding:6px 9px; font-size:11px; font-weight:750;
        white-space:nowrap;
    }
    .orders-empty {
        padding:36px 16px!important; text-align:center;
        color:#82766c;
    }
    .orders-alert {
        padding:12px 15px; border-radius:9px;
        margin-bottom:16px;
    }
    .orders-success { background:#e7f5e9; color:#28623a; }
    .orders-error { background:#fdebea; color:#9a302b; }
    .orders-pagination { margin-top:18px; }
    @media(max-width:900px) {
        .orders-filters { grid-template-columns:1fr 1fr; }
    }
    @media(max-width:560px) {
        .orders-card { padding:14px; }
        .orders-heading h1 { font-size:23px; }
        .orders-filters { grid-template-columns:1fr; }
        .orders-heading .orders-btn { width:100%; }
    }
</style>

<div class="orders-page">
    <div class="orders-heading">
        <div>
            <h1>Manajemen Pesanan</h1>
            <p class="orders-muted">
                Kelola transaksi, status pesanan, dan pembayaran customer.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="orders-alert orders-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="orders-alert orders-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="orders-alert orders-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="orders-card">
        <form action="{{ route('orders.index') }}" method="GET">
            <div class="orders-filters">
                <div class="orders-field">
                    <label for="search">Cari Pesanan</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Kode pesanan atau nama customer..."
                    >
                </div>

                <div class="orders-field">
                    <label for="status">Status Pesanan</label>
                    <select name="status" id="status">
                        <option value="">Semua Status</option>
                        @foreach($statusLabels as $value => $label)
                            <option value="{{ $value }}"
                                @selected(request('status') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="orders-field">
                    <label for="metode_pembayaran">Pembayaran</label>
                    <select name="metode_pembayaran" id="metode_pembayaran">
                        <option value="">Semua Pembayaran</option>
                        <option value="dana"
                            @selected(request('metode_pembayaran') === 'dana')>
                            DANA
                        </option>
                        <option value="cod"
                            @selected(request('metode_pembayaran') === 'cod')>
                            COD
                        </option>
                    </select>
                </div>

                <div style="display:flex;gap:8px">
                    <button type="submit" class="orders-btn orders-btn-primary">
                        Cari
                    </button>
                    <a href="{{ route('orders.index') }}"
                       class="orders-btn orders-btn-light">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="orders-card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:16px">
            <h3 style="margin:0;font-size:17px">Daftar Transaksi</h3>
            <span class="orders-muted">
                Total hasil: {{ $orders->total() }} pesanan
            </span>
        </div>

        <div class="orders-table-wrap">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode Pesanan</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="orders-code">
                                    {{ $order->kode_pesanan ?? '#'.$order->id }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:650">
                                    {{ $order->nama_penerima ?? $order->user->name ?? '-' }}
                                </div>
                                <div class="orders-muted">
                                    {{ $order->user->email ?? '' }}
                                </div>
                            </td>
                            <td>
                                {{ optional($order->created_at)->format('d/m/Y') ?? '-' }}
                                <div class="orders-muted">
                                    {{ optional($order->created_at)->format('H:i') }}
                                </div>
                            </td>
                            <td style="white-space:nowrap;font-weight:700">
                                Rp {{ number_format((float)$order->total_harga, 0, ',', '.') }}
                            </td>
                            <td>
                                <div style="font-weight:750">
                                    {{ strtoupper($order->metode_pembayaran ?? '-') }}
                                </div>
                                <div class="orders-muted">
                                    {{ $paymentLabels[$order->status_pembayaran ?? ''] ?? ($order->status_pembayaran ?? '-') }}
                                </div>
                            </td>
                            <td>
                                <span class="orders-status"
                                      style="background:{{ $statusColors[$order->status_pesanan ?? ''] ?? '#eee8e1' }}">
                                    {{ $statusLabels[$order->status_pesanan ?? ''] ?? ($order->status_pesanan ?? '-') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}"
                                   class="orders-btn orders-btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="orders-empty">
                                <div style="font-size:28px;margin-bottom:8px">📦</div>
                                <strong>Pesanan tidak ditemukan</strong>
                                <div class="orders-muted" style="margin-top:5px">
                                    Coba ubah kata kunci atau filter pencarian.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="orders-pagination">
                {{ $orders->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
