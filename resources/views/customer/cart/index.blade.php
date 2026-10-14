```blade
@extends('layouts.customer')

@section('title', 'Keranjang Belanja')

@section('content')

@php
    // Hanya menghitung subtotal dari produk yang masih tersedia.
    $subtotalKeranjang = $carts->sum(function ($cart) {
        if (!$cart->product) {
            return 0;
        }

        return (int) $cart->product->harga * (int) $cart->jumlah;
    });

    $totalItem = $carts->sum('jumlah');
@endphp

<style>
    .cart-page {
        min-height: 70vh;
        padding-top: 35px;
        padding-bottom: 60px;
        color: #333;
    }

    .cart-title {
        color: #26352c;
        font-weight: 800;
    }

    .cart-card {
        background: #fff;
        border: 1px solid #ece9e1;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .035);
    }

    .cart-product {
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .cart-product:first-child {
        padding-top: 0;
    }

    .cart-product:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .cart-image {
        width: 100%;
        height: 130px;
        object-fit: cover;
        border-radius: 10px;
        background: #f4f2ed;
    }

    .cart-image-placeholder {
        width: 100%;
        height: 130px;
        border-radius: 10px;
        background: #f4f2ed;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #888;
        font-size: 12px;
        text-align: center;
        padding: 8px;
    }

    .cart-brand {
        color: #52745a;
        font-size: 12px;
        font-weight: 700;
    }

    .cart-product-name {
        color: #26352c;
        font-size: 17px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .cart-price {
        color: #555;
        font-size: 14px;
    }

    .cart-qty-input {
        max-width: 100px;
    }

    .cart-subtotal {
        color: #26352c;
        font-weight: 800;
        white-space: nowrap;
    }

    .cart-summary {
        position: sticky;
        top: 20px;
    }

    .cart-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        border-radius: 10px;
        padding: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .cart-btn-primary {
        background: #52745a;
        border: 1px solid #52745a;
        color: #fff;
    }

    .cart-btn-primary:hover {
        background: #426149;
        border-color: #426149;
        color: #fff;
    }

    .cart-btn-outline {
        background: #fff;
        border: 1px solid #d8d5cd;
        color: #444;
    }

    .cart-btn-outline:hover {
        background: #f5f3ee;
        color: #26352c;
    }

    .cart-delete-btn {
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .cart-alert {
        border-radius: 10px;
    }

    .cart-empty-icon {
        font-size: 55px;
        margin-bottom: 12px;
    }

    @media (max-width: 767px) {
        .cart-page {
            padding-top: 24px;
            padding-bottom: 40px;
        }

        .cart-image,
        .cart-image-placeholder {
            height: 100px;
        }

        .cart-product-name {
            font-size: 15px;
        }

        .cart-summary {
            position: static;
        }

        .cart-qty-input {
            max-width: 90px;
        }
    }
</style>

<div class="container cart-page">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="cart-title mb-1">Keranjang Belanja</h2>

        <p class="text-muted mb-0">
            Periksa kembali produk yang ingin Anda beli.
        </p>
    </div>

    {{-- NOTIFIKASI BERHASIL --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show cart-alert"
             role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup">
            </button>
        </div>
    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show cart-alert"
             role="alert">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup">
            </button>
        </div>
    @endif

    {{-- NOTIFIKASI INFO --}}
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show cart-alert"
             role="alert">
            {{ session('info') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup">
            </button>
        </div>
    @endif

    {{-- ERROR VALIDASI --}}
    @if($errors->any())
        <div class="alert alert-danger cart-alert">
            <strong>Periksa kembali data Anda:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($carts->count() > 0)

        <div class="row g-4">

            {{-- DAFTAR PRODUK --}}
            <div class="col-lg-8">

                <div class="card cart-card">
                    <div class="card-body p-4">

                        @foreach($carts as $cart)

                            <div class="cart-product">
                                <div class="row align-items-center g-3">

                                    {{-- FOTO PRODUK --}}
                                    <div class="col-4 col-md-3">

                                        @if($cart->product && $cart->product->foto)

                                            <img
                                                src="{{ asset('storage/' . $cart->product->foto) }}"
                                                alt="{{ $cart->product->nama_produk }}"
                                                class="cart-image"
                                                loading="lazy">

                                        @else

                                            <div class="cart-image-placeholder">
                                                Produk tidak tersedia
                                            </div>

                                        @endif

                                    </div>

                                    {{-- INFORMASI PRODUK --}}
                                    <div class="col-8 col-md-5">

                                        @if($cart->product)

                                            <div class="cart-brand">
                                                {{ $cart->product->brand->nama_merek ?? 'Tanpa Merek' }}
                                            </div>

                                            <div class="cart-product-name mt-1 mb-2">
                                                {{ $cart->product->nama_produk }}
                                            </div>

                                            <div class="cart-price">
                                                Rp {{ number_format((float) $cart->product->harga, 0, ',', '.') }}
                                            </div>

                                            @if((int) $cart->product->stok <= 0)
                                                <div class="text-danger small mt-2">
                                                    Stok habis
                                                </div>
                                            @elseif((int) $cart->jumlah > (int) $cart->product->stok)
                                                <div class="text-danger small mt-2">
                                                    Jumlah melebihi stok tersedia
                                                    ({{ $cart->product->stok }})
                                                </div>
                                            @else
                                                <div class="text-success small mt-2">
                                                    Stok tersedia: {{ $cart->product->stok }}
                                                </div>
                                            @endif

                                        @else

                                            <div class="cart-product-name">
                                                Produk tidak ditemukan
                                            </div>

                                            <div class="text-muted small mt-2">
                                                Hapus produk ini dari keranjang untuk melanjutkan belanja.
                                            </div>

                                        @endif

                                    </div>

                                    {{-- UBAH JUMLAH --}}
                                    <div class="col-6 col-md-2">

                                        @if($cart->product && (int) $cart->product->stok > 0)

                                            <form
                                                action="{{ route('cart.update', $cart) }}"
                                                method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <label
                                                    for="jumlah-{{ $cart->id }}"
                                                    class="form-label small text-muted">
                                                    Jumlah
                                                </label>

                                                <input
                                                    type="number"
                                                    id="jumlah-{{ $cart->id }}"
                                                    name="jumlah"
                                                    value="{{ $cart->jumlah }}"
                                                    min="1"
                                                    max="{{ $cart->product->stok }}"
                                                    class="form-control cart-qty-input"
                                                    required>

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-secondary mt-2">
                                                    Perbarui
                                                </button>

                                            </form>

                                        @elseif($cart->product)

                                            <span class="text-danger small">
                                                Stok habis
                                            </span>

                                        @endif

                                    </div>

                                    {{-- SUBTOTAL DAN HAPUS --}}
                                    <div class="col-6 col-md-2 text-end">

                                        <div class="cart-subtotal mb-2">
                                            Rp
                                            {{ number_format(
                                                $cart->product
                                                    ? (float) $cart->product->harga * (int) $cart->jumlah
                                                    : 0,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </div>

                                        <form
                                            action="{{ route('cart.destroy', ['cart' => $cart->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-outline-danger cart-delete-btn">
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

            </div>

            {{-- RINGKASAN BELANJA --}}
            <div class="col-lg-4">

                <div class="card cart-card cart-summary">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-4">
                            Ringkasan Belanja
                        </h5>

                        <div class="d-flex justify-content-between gap-3 mb-3">
                            <span class="text-muted">Total Produk</span>

                            <span class="fw-semibold text-end">
                                {{ $totalItem }} item
                            </span>
                        </div>

                        <div class="d-flex justify-content-between gap-3 mb-3">
                            <span class="text-muted">Subtotal</span>

                            <span class="fw-bold text-end">
                                Rp {{ number_format($subtotalKeranjang, 0, ',', '.') }}
                            </span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                            <span class="fw-bold">Total</span>

                            <span class="fw-bold text-success fs-5 text-end">
                                Rp {{ number_format($subtotalKeranjang, 0, ',', '.') }}
                            </span>
                        </div>

                        @php
                            $adaProdukTidakValid = $carts->contains(function ($cart) {
                                return !$cart->product
                                    || (int) $cart->product->stok < 1
                                    || (int) $cart->jumlah > (int) $cart->product->stok;
                            });
                        @endphp

                        @if(!$adaProdukTidakValid)

                            <a
                                href="{{ route('checkout') }}"
                                class="cart-btn cart-btn-primary">
                                Lanjut ke Checkout
                            </a>

                        @else

                            <div class="alert alert-warning small">
                                Periksa jumlah dan stok produk sebelum melanjutkan checkout.
                                Hapus produk yang tidak tersedia atau perbarui jumlahnya.
                            </div>

                            <button
                                type="button"
                                class="cart-btn cart-btn-primary border-0"
                                disabled
                                style="opacity:.6;cursor:not-allowed;">
                                Lanjut ke Checkout
                            </button>

                        @endif

                        <a
                            href="{{ route('store.home') }}"
                            class="cart-btn cart-btn-outline mt-2">
                            &larr; Lanjut Belanja
                        </a>

                    </div>
                </div>

            </div>

        </div>

    @else

        {{-- KERANJANG KOSONG --}}
        <div class="card cart-card">
            <div class="card-body text-center py-5">

                <div class="cart-empty-icon">🛒</div>

                <h4 class="fw-bold">
                    Keranjang Masih Kosong
                </h4>

                <p class="text-muted mb-4">
                    Belum ada produk yang ditambahkan ke keranjang.
                </p>

                <a
                    href="{{ route('store.home') }}"
                    class="btn btn-success px-4 py-2"
                    style="border-radius:10px;font-weight:600;">
                    Mulai Belanja
                </a>

            </div>
        </div>

    @endif

</div>

@endsection
```
