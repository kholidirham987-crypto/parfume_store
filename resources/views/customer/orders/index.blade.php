@extends('layouts.customer')

@section('title', 'Pesanan Saya')

@section('content')

<style>
    .orders-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 35px 15px 60px;
    }

    .orders-header {
        margin-bottom: 25px;
    }

    .orders-header h2 {
        font-size: 28px;
        font-weight: 700;
        color: #24352a;
        margin-bottom: 6px;
    }

    .orders-header p {
        color: #777;
        margin: 0;
        font-size: 14px;
    }

    /* FILTER */
    .order-filter {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .order-filter a {
        text-decoration: none;
        padding: 9px 17px;
        border-radius: 9px;
        border: 1px solid #e2e2e2;
        background: #fff;
        color: #555;
        font-size: 14px;
        font-weight: 600;
        transition: .2s ease;
    }

    .order-filter a:hover {
        border-color: #6d8f72;
        color: #486b4e;
    }

    .order-filter a.active {
        background: #4f7456;
        border-color: #4f7456;
        color: #fff;
    }

    /* ALERT */
    .order-alert {
        border-radius: 10px;
        padding: 13px 16px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* CARD */
    .order-card {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 15px;
        margin-bottom: 18px;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(0,0,0,.035);
        transition: .2s ease;
    }

    .order-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,.07);
    }

    .order-top {
        padding: 17px 20px;
        border-bottom: 1px solid #eeeeee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .order-code {
        font-size: 14px;
        font-weight: 700;
        color: #28382c;
    }

    .order-date {
        color: #888;
        font-size: 12px;
        margin-top: 3px;
    }

    /* STATUS */
    .status-badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-waiting {
        background: #fff4d6;
        color: #9a6b00;
    }

    .status-process {
        background: #e8f2ff;
        color: #32689d;
    }

    .status-shipped {
        background: #eee8ff;
        color: #644ca1;
    }

    .status-success {
        background: #e5f5e9;
        color: #347044;
    }

    .status-cancel {
        background: #fde8e8;
        color: #a13c3c;
    }

    .status-default {
        background: #eeeeee;
        color: #666;
    }

    /* BODY */
    .order-body {
        padding: 20px;
    }

    .order-product {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .product-image {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        object-fit: cover;
        background: #f5f5f5;
        flex-shrink: 0;
    }

    .product-image-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 10px;
        background: #f3f3f3;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 12px;
        text-align: center;
        flex-shrink: 0;
    }

    .product-name {
        font-size: 15px;
        font-weight: 650;
        color: #303b32;
        margin-bottom: 4px;
    }

    .product-detail {
        color: #888;
        font-size: 13px;
    }

    .more-items {
        color: #6a806e;
        font-size: 13px;
        margin-top: 7px;
    }

    /* BOTTOM */
    .order-bottom {
        border-top: 1px solid #eeeeee;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
    }

    .payment-info {
        font-size: 13px;
        color: #777;
    }

    .payment-info strong {
        color: #333;
    }

    .order-total {
        text-align: right;
    }

    .order-total-label {
        color: #888;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .order-total-value {
        color: #2d4632;
        font-size: 18px;
        font-weight: 700;
    }

    .detail-button {
        display: inline-block;
        text-decoration: none;
        padding: 9px 17px;
        border-radius: 9px;
        border: 1px solid #4f7456;
        color: #4f7456;
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        transition: .2s ease;
    }

    .detail-button:hover {
        background: #4f7456;
        color: #fff;
    }

    /* EMPTY */
    .empty-orders {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 15px;
        padding: 55px 25px;
        text-align: center;
    }

    .empty-orders h4 {
        color: #333;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-orders p {
        color: #888;
        font-size: 14px;
        margin-bottom: 22px;
    }

    /* HOME CTA */
    .home-cta {
        text-align: center;
        margin-top: 35px;
        padding-top: 28px;
        border-top: 1px solid #eeeeee;
    }

    .home-cta-text {
        color: #777;
        font-size: 14px;
        margin-bottom: 14px;
    }

    .home-button {
        display: inline-block;
        text-decoration: none;
        background: #4f7456;
        color: #fff;
        padding: 12px 28px;
        border-radius: 11px;
        font-size: 14px;
        font-weight: 650;
        box-shadow: 0 5px 15px rgba(79,116,86,.18);
        transition: .2s ease;
    }

    .home-button:hover {
        background: #3f6246;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(79,116,86,.24);
    }

    /* MOBILE */
    @media (max-width: 600px) {

        .orders-page {
            padding-top: 25px;
        }

        .orders-header h2 {
            font-size: 24px;
        }

        .order-top {
            align-items: flex-start;
            flex-direction: column;
        }

        .order-bottom {
            align-items: flex-start;
            flex-direction: column;
        }

        .order-total {
            text-align: left;
        }

        .detail-button {
            width: 100%;
            text-align: center;
        }

        .home-button {
            width: 100%;
            text-align: center;
        }
    }
</style>


<div class="orders-page">

    {{-- HEADER --}}
    <div class="orders-header">
        <h2>Pesanan Saya</h2>
        <p>Lihat status dan riwayat seluruh pesanan Anda.</p>
    </div>


    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success order-alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger order-alert">
            {{ session('error') }}
        </div>
    @endif


    {{-- FILTER STATUS --}}
    <div class="order-filter">

        <a href="{{ route('customer.orders') }}"
           class="{{ !request('status') ? 'active' : '' }}">
            Semua
        </a>

        <a href="{{ route('customer.orders', ['status' => 'menunggu_verifikasi']) }}"
           class="{{ request('status') === 'menunggu_verifikasi' ? 'active' : '' }}">
            Menunggu
        </a>

        <a href="{{ route('customer.orders', ['status' => 'diproses']) }}"
           class="{{ request('status') === 'diproses' ? 'active' : '' }}">
            Diproses
        </a>

        <a href="{{ route('customer.orders', ['status' => 'dikirim']) }}"
           class="{{ request('status') === 'dikirim' ? 'active' : '' }}">
            Dikirim
        </a>

        <a href="{{ route('customer.orders', ['status' => 'selesai']) }}"
           class="{{ request('status') === 'selesai' ? 'active' : '' }}">
            Selesai
        </a>

    </div>


    {{-- DAFTAR PESANAN --}}
    @forelse($orders as $order)

        @php

            $status = strtolower($order->status_pesanan ?? '');

            if ($status === 'menunggu_verifikasi') {
                $statusText = 'Menunggu Verifikasi';
                $statusClass = 'status-waiting';

            } elseif ($status === 'diproses') {
                $statusText = 'Diproses';
                $statusClass = 'status-process';

            } elseif ($status === 'dikirim') {
                $statusText = 'Dalam Perjalanan';
                $statusClass = 'status-shipped';

            } elseif ($status === 'selesai') {
                $statusText = 'Selesai';
                $statusClass = 'status-success';

            } elseif ($status === 'dibatalkan') {
                $statusText = 'Dibatalkan';
                $statusClass = 'status-cancel';

            } else {
                $statusText = ucfirst(str_replace('_', ' ', $status));
                $statusClass = 'status-default';
            }

            $firstItem = $order->items->first();

        @endphp


        <div class="order-card">

            {{-- TOP --}}
            <div class="order-top">

                <div>
                    <div class="order-code">
                        {{ $order->kode_pesanan }}
                    </div>

                    <div class="order-date">
                        {{ $order->created_at?->format('d M Y, H:i') }}
                    </div>
                </div>

                <span class="status-badge {{ $statusClass }}">
                    {{ $statusText }}
                </span>

            </div>


            {{-- BODY --}}
            <div class="order-body">

                @if($firstItem && $firstItem->product)

                    <div class="order-product">

                        @if($firstItem->product->foto)

                            <img
                                src="{{ asset('storage/' . $firstItem->product->foto) }}"
                                alt="{{ $firstItem->product->nama_produk }}"
                                class="product-image">

                        @else

                            <div class="product-image-placeholder">
                                Tidak ada foto
                            </div>

                        @endif


                        <div>

                            <div class="product-name">
                                {{ $firstItem->product->nama_produk }}
                            </div>

                            <div class="product-detail">
                                {{ $firstItem->jumlah }} produk
                                ×
                                Rp{{ number_format($firstItem->harga, 0, ',', '.') }}
                            </div>

                            @if($order->items->count() > 1)

                                <div class="more-items">
                                    + {{ $order->items->count() - 1 }}
                                    produk lainnya
                                </div>

                            @endif

                        </div>

                    </div>

                @else

                    <div class="product-detail">
                        Detail produk tidak tersedia.
                    </div>

                @endif

            </div>


            {{-- BOTTOM --}}
            <div class="order-bottom">

                <div>

                    <div class="payment-info">
                        Pembayaran:
                        <strong>
                            {{ strtoupper($order->metode_pembayaran ?? '-') }}
                        </strong>
                    </div>

                    <div class="payment-info">
                        Kurir:
                        <strong>
                            {{ $order->kurir ?? '-' }}
                        </strong>
                    </div>

                </div>


                <div class="order-total">

                    <div class="order-total-label">
                        Total Pesanan
                    </div>

                    <div class="order-total-value">
                        Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                    </div>

                </div>


                <a
                    href="{{ route('customer.orders.show', $order) }}"
                    class="detail-button">
                    Lihat Detail Pesanan
                </a>

            </div>

        </div>

    @empty

        <div class="empty-orders">

            <h4>Belum Ada Pesanan</h4>

            <p>
                Pesanan yang Anda buat akan tersimpan dan dapat dilihat kembali di halaman ini.
            </p>

        </div>

    @endforelse


    {{-- KEMBALI KE BERANDA --}}
    <div class="home-cta">

        <div class="home-cta-text">
            Masih ingin menjelajahi koleksi parfum kami?
        </div>

        <a
            href="{{ route('store.home') }}"
            class="home-button">
            Kembali ke Beranda
        </a>

    </div>

</div>

@endsection