@extends('layouts.customer')

@section('title', 'Detail Pesanan')

@section('content')

<style>
    .order-page {
        background: #f8f8f5;
        min-height: 100vh;
        padding: 40px 0 70px;
    }

    .order-card {
        background: #ffffff;
        border: 1px solid #e9e9e4;
        border-radius: 18px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.05);
    }

    .order-header {
        padding: 25px;
        border-bottom: 1px solid #eeeeea;
    }

    .order-code {
        font-size: 20px;
        font-weight: 700;
        color: #222;
    }

    .order-date {
        color: #777;
        font-size: 14px;
        margin-top: 5px;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
    }

    .status-warning {
        background: #fff4d6;
        color: #946200;
    }

    .status-success {
        background: #e6f6ea;
        color: #26733a;
    }

    .status-info {
        background: #e5f2ff;
        color: #1769aa;
    }

    .status-danger {
        background: #fde7e7;
        color: #b42318;
    }

    .section-title {
        font-size: 17px;
        font-weight: 700;
        color: #222;
        margin-bottom: 20px;
    }

    .product-item {
        padding: 18px 0;
        border-bottom: 1px solid #eeeeea;
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        background: #f4f4f1;
    }

    .product-name {
        font-weight: 600;
        color: #222;
        margin-bottom: 5px;
    }

    .product-price {
        color: #777;
        font-size: 14px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 13px;
        font-size: 14px;
    }

    .summary-row span:first-child {
        color: #777;
    }

    .summary-row span:last-child {
        font-weight: 600;
        color: #222;
        text-align: right;
    }

    .summary-total {
        padding-top: 18px;
        margin-top: 18px;
        border-top: 1px solid #eeeeea;
    }

    .summary-total span:first-child {
        font-weight: 700;
        color: #222;
    }

    .summary-total span:last-child {
        color: #52745a;
        font-size: 20px;
        font-weight: 700;
    }

    .info-box {
        background: #f8f9f6;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
    }

    .info-label {
        color: #777;
        font-size: 13px;
        margin-bottom: 4px;
    }

    .info-value {
        color: #222;
        font-weight: 600;
        line-height: 1.5;
    }

    .payment-box {
        border: 1px solid #e7e7e2;
        border-radius: 14px;
        padding: 20px;
        background: #fff;
    }

    .payment-title {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .upload-box {
        background: #f8f9f6;
        border-radius: 12px;
        padding: 18px;
        margin-top: 15px;
    }

    .btn-main {
        background: #52745a;
        border: none;
        color: white;
        border-radius: 10px;
        padding: 11px 20px;
        font-weight: 600;
    }

    .btn-main:hover {
        background: #436149;
        color: white;
    }

    .btn-outline-main {
        border: 1px solid #52745a;
        color: #52745a;
        background: white;
        border-radius: 10px;
        padding: 10px 18px;
        font-weight: 600;
    }

    .btn-outline-main:hover {
        background: #52745a;
        color: white;
    }

    .note-box {
        background: #fff8e8;
        border: 1px solid #f2dfac;
        border-radius: 12px;
        padding: 16px;
        color: #6d5a24;
    }

    @media (max-width: 767px) {

        .order-page {
            padding: 25px 0 50px;
        }

        .order-header {
            padding: 20px;
        }

        .product-image {
            width: 65px;
            height: 65px;
        }

        .order-code {
            font-size: 17px;
        }

        .summary-row {
            font-size: 13px;
        }
    }
</style>


<div class="order-page">

    <div class="container">

        {{-- ==========================================
            ALERT SUCCESS
        =========================================== --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show"
                 role="alert">

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ==========================================
            ALERT ERROR
        =========================================== --}}
        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show"
                 role="alert">

                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ==========================================
            HEADER PESANAN
        =========================================== --}}
        <div class="order-card mb-4">

            <div class="order-header">

                <div class="d-flex flex-column flex-md-row
                            justify-content-between
                            align-items-md-center gap-3">

                    <div>

                        <div class="order-code">

                            Pesanan #{{ $order->kode_pesanan }}

                        </div>

                        <div class="order-date">

                            Dibuat pada
                            {{ $order->created_at->format('d M Y, H:i') }}

                        </div>

                    </div>


                    <div>

                        @php

                            $statusPesanan = $order->status_pesanan;

                            $statusClass = match($statusPesanan) {

                                'menunggu_verifikasi'
                                    => 'status-warning',

                                'diproses'
                                    => 'status-info',

                                'dikirim'
                                    => 'status-info',

                                'selesai'
                                    => 'status-success',

                                'dibatalkan'
                                    => 'status-danger',

                                default
                                    => 'status-warning',

                            };

                            $statusLabel = match($statusPesanan) {

                                'menunggu_verifikasi'
                                    => 'Menunggu Verifikasi',

                                'diproses'
                                    => 'Sedang Diproses',

                                'dikirim'
                                    => 'Sedang Dikirim',

                                'selesai'
                                    => 'Selesai',

                                'dibatalkan'
                                    => 'Dibatalkan',

                                default
                                    => ucfirst(str_replace('_', ' ', $statusPesanan ?? 'Pending')),

                            };

                        @endphp


                        <span class="status-badge {{ $statusClass }}">

                            {{ $statusLabel }}

                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="row g-4">

            {{-- ==========================================
                KIRI
            =========================================== --}}
            <div class="col-lg-8">


                {{-- ==========================================
                    PRODUK
                =========================================== --}}
                <div class="order-card mb-4">

                    <div class="p-4">

                        <div class="section-title">

                            Produk Pesanan

                        </div>


                        @forelse($order->items as $item)

                            <div class="product-item">

                                <div class="row align-items-center g-3">

                                    {{-- FOTO --}}
                                    <div class="col-auto">

                                        @if($item->product && $item->product->foto)

                                            <img
                                                src="{{ asset('storage/' . $item->product->foto) }}"
                                                alt="{{ $item->product->nama_produk }}"
                                                class="product-image">

                                        @else

                                            <div class="product-image
                                                        d-flex
                                                        align-items-center
                                                        justify-content-center">

                                                <span class="text-muted">
                                                    📦
                                                </span>

                                            </div>

                                        @endif

                                    </div>


                                    {{-- DETAIL --}}
                                    <div class="col">

                                        <div class="product-name">

                                            {{ $item->product->nama_produk ?? 'Produk tidak ditemukan' }}

                                        </div>

                                        <div class="product-price">

                                            Rp
                                            {{ number_format(
                                                $item->harga,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                            ×

                                            {{ $item->jumlah }}

                                        </div>

                                    </div>


                                    {{-- SUBTOTAL --}}
                                    <div class="col-auto">

                                        <div class="fw-bold">

                                            Rp
                                            {{ number_format(
                                                $item->subtotal,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center text-muted py-4">

                                Tidak ada produk dalam pesanan.

                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- ==========================================
                    ALAMAT PENGIRIMAN
                =========================================== --}}
                <div class="order-card mb-4">

                    <div class="p-4">

                        <div class="section-title">

                            Informasi Pengiriman

                        </div>


                        <div class="row g-3">

                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-label">
                                        Nama Penerima
                                    </div>

                                    <div class="info-value">
                                        {{ $order->nama_penerima }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-label">
                                        Nomor HP
                                    </div>

                                    <div class="info-value">
                                        {{ $order->no_hp }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-12">

                                <div class="info-box">

                                    <div class="info-label">
                                        Alamat Lengkap
                                    </div>

                                    <div class="info-value">

                                        {{ $order->alamat }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-label">
                                        Kota
                                    </div>

                                    <div class="info-value">

                                        {{ $order->kota }}

                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-label">
                                        Kecamatan
                                    </div>

                                    <div class="info-value">

                                        {{ $order->kecamatan }}

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="info-box mt-2 mb-0">

                            <div class="info-label">
                                Kurir
                            </div>

                            <div class="info-value">

                                {{ $order->kurir }}

                                @if($order->layanan_kurir)

                                    -
                                    {{ $order->layanan_kurir }}

                                @endif

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==========================================
                    CATATAN CUSTOMER
                =========================================== --}}
                @if($order->catatan_customer)

                    <div class="order-card mb-4">

                        <div class="p-4">

                            <div class="section-title">
                                Catatan Pesanan
                            </div>

                            <div class="note-box">

                                {{ $order->catatan_customer }}

                            </div>

                        </div>

                    </div>

                @endif


                {{-- ==========================================
                    CATATAN ADMIN
                =========================================== --}}
                @if($order->catatan_admin)

                    <div class="order-card mb-4">

                        <div class="p-4">

                            <div class="section-title">
                                Catatan Admin
                            </div>

                            <div class="note-box">

                                {{ $order->catatan_admin }}

                            </div>

                        </div>

                    </div>

                @endif


                {{-- ==========================================
                    PEMBAYARAN DANA
                =========================================== --}}
                @if($order->metode_pembayaran === 'dana')

                    <div class="order-card mb-4">

                        <div class="p-4">

                            <div class="section-title">

                                Pembayaran DANA

                            </div>


                            <div class="payment-box">

                                <div class="payment-title">

                                    Status Pembayaran

                                </div>


                                @if($order->status_pembayaran === 'menunggu_verifikasi')

                                    <span class="status-badge status-warning">

                                        Menunggu Verifikasi

                                    </span>

                                    <p class="text-muted mt-3 mb-0">

                                        Silakan upload bukti pembayaran
                                        DANA untuk diverifikasi oleh admin.

                                    </p>


                                @elseif($order->status_pembayaran === 'terverifikasi')

                                    <span class="status-badge status-success">

                                        Pembayaran Terverifikasi

                                    </span>

                                    <p class="text-muted mt-3 mb-0">

                                        Pembayaran Anda telah diverifikasi
                                        oleh admin.

                                    </p>


                                @elseif($order->status_pembayaran === 'ditolak')

                                    <span class="status-badge status-danger">

                                        Pembayaran Ditolak

                                    </span>

                                    @if($order->catatan_admin)

                                        <div class="note-box mt-3">

                                            <strong>
                                                Alasan Admin:
                                            </strong>

                                            <br>

                                            {{ $order->catatan_admin }}

                                        </div>

                                    @endif

                                    <p class="text-muted mt-3 mb-0">

                                        Silakan upload kembali bukti
                                        pembayaran yang benar.

                                    </p>

                                @else

                                    <span class="status-badge status-warning">

                                        {{ ucfirst(str_replace('_', ' ', $order->status_pembayaran)) }}

                                    </span>

                                @endif


                                {{-- ==================================
                                    BUKTI PEMBAYARAN SUDAH ADA
                                =================================== --}}
                                @if($order->bukti_pembayaran)

                                    <div class="upload-box">

                                        <div class="fw-semibold mb-2">

                                            Bukti Pembayaran

                                        </div>


                                        <a
                                            href="{{ asset('storage/' . $order->bukti_pembayaran) }}"
                                            target="_blank"
                                            class="btn btn-outline-main">

                                            Lihat Bukti Pembayaran

                                        </a>

                                    </div>

                                @endif


                                {{-- ==================================
                                    UPLOAD BUKTI
                                =================================== --}}
                                @if(
                                    $order->status_pembayaran === 'menunggu_verifikasi'
                                    || $order->status_pembayaran === 'ditolak'
                                )

                                    <div class="upload-box">

                                        <div class="fw-semibold mb-2">

                                            Upload Bukti Pembayaran

                                        </div>

                                        <p class="text-muted small">

                                            Format yang diperbolehkan:
                                            JPG, JPEG, PNG.
                                            Maksimal 2 MB.

                                        </p>


                                        <form
                                            action="{{ route(
                                                'customer.orders.payment-proof',
                                                $order
                                            ) }}"
                                            method="POST"
                                            enctype="multipart/form-data">

                                            @csrf


                                            <div class="mb-3">

                                                <input
                                                    type="file"
                                                    name="bukti_pembayaran"
                                                    class="form-control"
                                                    accept=".jpg,.jpeg,.png"
                                                    required>

                                            </div>


                                            <button
                                                type="submit"
                                                class="btn btn-main">

                                                Upload Bukti Pembayaran

                                            </button>

                                        </form>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                @endif


                {{-- ==========================================
                    COD
                =========================================== --}}
                @if($order->metode_pembayaran === 'cod')

                    <div class="order-card mb-4">

                        <div class="p-4">

                            <div class="section-title">

                                Pembayaran COD

                            </div>


                            <div class="payment-box">

                                <div class="payment-title">

                                    Cash On Delivery

                                </div>

                                <p class="text-muted mb-3">

                                    Pembayaran dilakukan saat pesanan
                                    diterima.

                                </p>


                                <span class="status-badge
                                    {{ $order->status_pembayaran === 'dibayar'
                                        ? 'status-success'
                                        : 'status-warning' }}">

                                    @if($order->status_pembayaran === 'dibayar')

                                        Sudah Dibayar

                                    @else

                                        Belum Dibayar

                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>

                @endif


            </div>


            {{-- ==========================================
                KANAN
            =========================================== --}}
            <div class="col-lg-4">


                {{-- ==========================================
                    RINGKASAN PEMBAYARAN
                =========================================== --}}
                <div class="order-card mb-4">

                    <div class="p-4">

                        <div class="section-title">

                            Ringkasan Pembayaran

                        </div>


                        <div class="summary-row">

                            <span>
                                Subtotal
                            </span>

                            <span>

                                Rp
                                {{ number_format(
                                    $order->subtotal,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </span>

                        </div>


                        <div class="summary-row">

                            <span>
                                Ongkir
                            </span>

                            <span>

                                Rp
                                {{ number_format(
                                    $order->ongkir,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </span>

                        </div>


                        <div class="summary-row">

                            <span>
                                Kurir
                            </span>

                            <span>

                                {{ $order->kurir }}

                            </span>

                        </div>


                        <div class="summary-row">

                            <span>
                                Metode Pembayaran
                            </span>

                            <span>

                                @if($order->metode_pembayaran === 'dana')

                                    DANA

                                @elseif($order->metode_pembayaran === 'cod')

                                    COD

                                @else

                                    {{ strtoupper($order->metode_pembayaran) }}

                                @endif

                            </span>

                        </div>


                        <div class="summary-row summary-total">

                            <span>
                                Total
                            </span>

                            <span>

                                Rp
                                {{ number_format(
                                    $order->total_harga,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </span>

                        </div>

                    </div>

                </div>


                {{-- ==========================================
                    PESANAN DITERIMA - COD
                =========================================== --}}
                @if(
                    $order->metode_pembayaran === 'cod'
                    && $order->status_pesanan === 'dikirim'
                )

                    <div class="order-card mb-4">

                        <div class="p-4">

                            <div class="section-title">

                                Pesanan Sudah Sampai?

                            </div>

                            <p class="text-muted small">

                                Klik tombol di bawah jika pesanan
                                sudah Anda terima.

                            </p>


                            <form
                                action="{{ route(
                                    'customer.orders.received',
                                    $order
                                ) }}"
                                method="POST">

                                @csrf

                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="btn btn-main w-100"
                                    onclick="return confirm(
                                        'Apakah pesanan sudah Anda terima?'
                                    )">

                                    Pesanan Diterima

                                </button>

                            </form>

                        </div>

                    </div>

                @endif


                {{-- ==========================================
                    PESANAN SELESAI
                =========================================== --}}
                @if($order->status_pesanan === 'selesai')

                    <div class="order-card mb-4">

                        <div class="p-4 text-center">

                            <div style="font-size: 40px;">
                                ✓
                            </div>

                            <h5 class="fw-bold mt-2">

                                Pesanan Selesai

                            </h5>

                            <p class="text-muted mb-0">

                                Terima kasih telah berbelanja
                                di toko kami.

                            </p>

                        </div>

                    </div>

                @endif


                {{-- ==========================================
                    KEMBALI
                =========================================== --}}
                <a
                    href="{{ route('customer.orders') }}"
                    class="btn btn-outline-main w-100">

                    ← Kembali ke Pesanan Saya

                </a>

            </div>

        </div>

    </div>

</div>

@endsection