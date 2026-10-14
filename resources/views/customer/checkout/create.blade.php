@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<style>
    .checkout-page {
        background: #f8f6f1;
        min-height: calc(100vh - 80px);
        padding: 35px 0 60px;
    }

    .checkout-container {
        max-width: 1180px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .checkout-title {
        margin-bottom: 25px;
    }

    .checkout-title h1 {
        font-size: 30px;
        font-weight: 700;
        color: #26352d;
        margin-bottom: 6px;
    }

    .checkout-title p {
        color: #777;
        margin: 0;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(320px, .8fr);
        gap: 25px;
        align-items: start;
    }

    .checkout-card {
        background: #fff;
        border: 1px solid #e7e1d8;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 5px 18px rgba(0,0,0,.04);
        margin-bottom: 20px;
    }

    .checkout-card h2 {
        font-size: 19px;
        color: #26352d;
        margin: 0 0 20px;
        font-weight: 700;
    }

    .section-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #315c45;
        color: #fff;
        font-size: 14px;
        margin-right: 8px;
    }

    .form-group {
        margin-bottom: 17px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: #34423a;
        font-weight: 600;
        font-size: 14px;
    }

    .form-control,
    .form-select {
        width: 100%;
        border: 1px solid #d9d4cb;
        border-radius: 10px;
        padding: 12px 13px;
        font-size: 14px;
        color: #333;
        background: #fff;
        outline: none;
        box-sizing: border-box;
        transition: .2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #315c45;
        box-shadow: 0 0 0 3px rgba(49,92,69,.10);
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .payment-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .payment-option {
        position: relative;
    }

    .payment-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .payment-label {
        display: block;
        border: 1px solid #ddd6cc;
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: .2s;
        background: #fff;
    }

    .payment-label:hover {
        border-color: #315c45;
    }

    .payment-option input:checked + .payment-label {
        border-color: #315c45;
        background: #f2f7f3;
        box-shadow: 0 0 0 2px rgba(49,92,69,.08);
    }

    .payment-name {
        display: block;
        font-weight: 700;
        color: #26352d;
        margin-bottom: 4px;
    }

    .payment-description {
        display: block;
        color: #777;
        font-size: 12px;
        line-height: 1.5;
    }

    .courier-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
        margin-bottom: 15px;
    }

    .courier-option {
        position: relative;
    }

    .courier-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .courier-label {
        display: block;
        text-align: center;
        padding: 13px 8px;
        border: 1px solid #ddd6cc;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        color: #444;
        transition: .2s;
    }

    .courier-option input:checked + .courier-label {
        background: #315c45;
        border-color: #315c45;
        color: #fff;
    }

    .product-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .product-item {
        display: flex;
        gap: 13px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee9e1;
    }

    .product-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .product-image {
        width: 65px;
        height: 65px;
        border-radius: 10px;
        background: #f3f0eb;
        overflow: hidden;
        flex-shrink: 0;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-weight: 600;
        color: #26352d;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .product-qty {
        color: #888;
        font-size: 13px;
    }

    .product-price {
        font-weight: 700;
        color: #315c45;
        white-space: nowrap;
        font-size: 14px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 9px 0;
        color: #666;
        font-size: 14px;
    }

    .summary-row.total {
        border-top: 1px solid #e7e1d8;
        margin-top: 10px;
        padding-top: 17px;
        color: #26352d;
        font-size: 19px;
        font-weight: 700;
    }

    .checkout-button {
        width: 100%;
        border: none;
        border-radius: 11px;
        padding: 14px;
        background: #315c45;
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        margin-top: 18px;
        transition: .2s;
    }

    .checkout-button:hover {
        background: #264a38;
    }

    .back-cart {
        display: block;
        text-align: center;
        color: #315c45;
        font-size: 14px;
        text-decoration: none;
        margin-top: 13px;
    }

    .alert {
        border-radius: 10px;
        padding: 13px 15px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-danger {
        background: #fff0f0;
        border: 1px solid #f0caca;
        color: #a33a3a;
    }

    .alert-success {
        background: #eff8f1;
        border: 1px solid #cde4d1;
        color: #2f6b3f;
    }

    .error-text {
        color: #b23b3b;
        font-size: 12px;
        margin-top: 5px;
    }

    .payment-info {
        background: #f7f3eb;
        border: 1px solid #e8dfd2;
        border-radius: 10px;
        padding: 13px;
        margin-top: 12px;
        color: #665c50;
        font-size: 13px;
        line-height: 1.6;
    }

    @media (max-width: 850px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .checkout-page {
            padding: 25px 0 45px;
        }

        .checkout-container {
            padding: 0 14px;
        }

        .checkout-card {
            padding: 18px;
            border-radius: 13px;
        }

        .checkout-title h1 {
            font-size: 25px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .payment-options {
            grid-template-columns: 1fr;
        }

        .courier-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="checkout-page">

    <div class="checkout-container">

        {{-- =====================================================
             TITLE
        ====================================================== --}}

        <div class="checkout-title">
            <h1>Checkout</h1>
            <p>Lengkapi informasi pengiriman dan pembayaran.</p>
        </div>


        {{-- =====================================================
             ALERT
        ====================================================== --}}

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- =====================================================
             VALIDATION ERROR
        ====================================================== --}}

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data Anda:</strong>

                <ul style="margin: 8px 0 0 18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form
            action="{{ route('checkout.store') }}"
            method="POST"
        >

            @csrf


            <div class="checkout-grid">

                {{-- =================================================
                     LEFT
                ================================================== --}}

                <div>

                    {{-- =============================================
                         DATA PENERIMA
                    ============================================== --}}

                    <div class="checkout-card">

                        <h2>
                            <span class="section-number">1</span>
                            Informasi Penerima
                        </h2>

                        <div class="form-group">

                            <label class="form-label">
                                Nama Penerima
                            </label>

                            <input
                                type="text"
                                name="nama_penerima"
                                class="form-control"
                                value="{{ old('nama_penerima', auth()->user()->name) }}"
                                placeholder="Masukkan nama penerima"
                                required
                            >

                            @error('nama_penerima')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                Nomor HP
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                class="form-control"
                                value="{{ old('no_hp') }}"
                                placeholder="Contoh: 081234567890"
                                required
                            >

                            @error('no_hp')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                Alamat Lengkap
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                placeholder="Nama jalan, nomor rumah, dusun, patokan, dan sebagainya"
                                required
                            >{{ old('alamat') }}</textarea>

                            @error('alamat')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="form-row">

                            <div class="form-group">

                                <label class="form-label">
                                    Kota / Kabupaten
                                </label>

                                <input
                                    type="text"
                                    name="kota"
                                    class="form-control"
                                    value="{{ old('kota') }}"
                                    placeholder="Contoh: Medan"
                                    required
                                >

                                @error('kota')
                                    <div class="error-text">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    Kecamatan
                                </label>

                                <input
                                    type="text"
                                    name="kecamatan"
                                    class="form-control"
                                    value="{{ old('kecamatan') }}"
                                    placeholder="Nama kecamatan"
                                    required
                                >

                                @error('kecamatan')
                                    <div class="error-text">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =============================================
                         KURIR
                    ============================================== --}}

                    <div class="checkout-card">

                        <h2>
                            <span class="section-number">2</span>
                            Pengiriman
                        </h2>


                        <label class="form-label">
                            Pilih Kurir
                        </label>


                        <div class="courier-grid">

                            <div class="courier-option">

                                <input
                                    type="radio"
                                    id="jne"
                                    name="kurir"
                                    value="JNE"
                                    {{ old('kurir') === 'JNE' ? 'checked' : '' }}
                                    required
                                >

                                <label
                                    for="jne"
                                    class="courier-label"
                                >
                                    JNE
                                </label>

                            </div>


                            <div class="courier-option">

                                <input
                                    type="radio"
                                    id="jnt"
                                    name="kurir"
                                    value="J&T"
                                    {{ old('kurir') === 'J&T' ? 'checked' : '' }}
                                >

                                <label
                                    for="jnt"
                                    class="courier-label"
                                >
                                    J&T
                                </label>

                            </div>


                            <div class="courier-option">

                                <input
                                    type="radio"
                                    id="sicepat"
                                    name="kurir"
                                    value="SiCepat"
                                    {{ old('kurir') === 'SiCepat' ? 'checked' : '' }}
                                >

                                <label
                                    for="sicepat"
                                    class="courier-label"
                                >
                                    SiCepat
                                </label>

                            </div>

                        </div>


                        <div class="form-group">

                            <label class="form-label">
                                Layanan Pengiriman
                            </label>

                            <select
                                name="layanan_kurir"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Pilih layanan
                                </option>

                                <option
                                    value="Reguler"
                                    {{ old('layanan_kurir') === 'Reguler' ? 'selected' : '' }}
                                >
                                    Reguler
                                </option>

                            </select>

                            @error('layanan_kurir')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="payment-info">
                            <strong>Ongkir:</strong>
                            Rp {{ number_format($ongkir, 0, ',', '.') }}

                            <br>

                            Ongkir sementara menggunakan tarif flat
                            untuk prototype.
                        </div>

                    </div>


                    {{-- =============================================
                         PEMBAYARAN
                    ============================================== --}}

                    <div class="checkout-card">

                        <h2>
                            <span class="section-number">3</span>
                            Metode Pembayaran
                        </h2>


                        <div class="payment-options">

                            {{-- DANA --}}

                            <div class="payment-option">

                                <input
                                    type="radio"
                                    id="dana"
                                    name="metode_pembayaran"
                                    value="dana"
                                    {{ old('metode_pembayaran') === 'dana' ? 'checked' : '' }}
                                    required
                                >

                                <label
                                    for="dana"
                                    class="payment-label"
                                >

                                    <span class="payment-name">
                                        DANA
                                    </span>

                                    <span class="payment-description">
                                        Transfer melalui DANA dan upload
                                        bukti pembayaran.
                                    </span>

                                </label>

                            </div>


                            {{-- COD --}}

                            <div class="payment-option">

                                <input
                                    type="radio"
                                    id="cod"
                                    name="metode_pembayaran"
                                    value="cod"
                                    {{ old('metode_pembayaran') === 'cod' ? 'checked' : '' }}
                                >

                                <label
                                    for="cod"
                                    class="payment-label"
                                >

                                    <span class="payment-name">
                                        COD
                                    </span>

                                    <span class="payment-description">
                                        Bayar ketika pesanan diterima.
                                    </span>

                                </label>

                            </div>

                        </div>


                    
                        <div class="payment-info">
                            <strong>Catatan pembayaran:</strong>

                            <p style="margin: 8px 0;">
                                Jika memilih DANA, silakan transfer ke nomor berikut:
                            </p>

                            <div style="
                                background: #fff;
                                border: 1px dashed #315c45;
                                border-radius: 8px;
                                padding: 12px;
                                margin: 10px 0;
                            ">
                                <div style="font-size: 12px; color: #777;">
                                    Nomor DANA
                                </div>

                                <strong style="
                                    font-size: 20px;
                                    color: #315c45;
                                    letter-spacing: 1px;
                                ">
                                    081260917565
                                </strong>
                            </div>

                            <p style="margin: 0;">
                                Setelah membuat pesanan, unggah bukti transfer
                                melalui halaman detail pesanan. Pesanan akan diproses
                                setelah pembayaran diverifikasi oleh admin.
                            </p>
                        </div>

                    {{-- =============================================
                         CATATAN
                    ============================================== --}}

                    <div class="checkout-card">

                        <h2>
                            <span class="section-number">4</span>
                            Catatan Pesanan
                        </h2>

                        <div class="form-group">

                            <label class="form-label">
                                Catatan untuk penjual
                                <span style="font-weight:400;color:#999;">
                                    (opsional)
                                </span>
                            </label>

                            <textarea
                                name="catatan_customer"
                                class="form-control"
                                placeholder="Contoh: Tolong hubungi saya sebelum paket dikirim."
                            >{{ old('catatan_customer') }}</textarea>

                            @error('catatan_customer')
                                <div class="error-text">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     RIGHT - RINGKASAN
                ================================================== --}}

                <div>

                    <div class="checkout-card">

                        <h2>
                            Ringkasan Pesanan
                        </h2>


                        <div class="product-list">

                            @foreach($carts as $cart)

                                <div class="product-item">

                                    <div class="product-image">

                                        @if($cart->product->foto)

                                            <img
                                                src="{{ asset('storage/' . $cart->product->foto) }}"
                                                alt="{{ $cart->product->nama_produk }}"
                                            >

                                        @endif

                                    </div>


                                    <div class="product-info">

                                        <div class="product-name">
                                            {{ $cart->product->nama_produk }}
                                        </div>

                                        <div class="product-qty">
                                            {{ $cart->jumlah }}
                                            ×
                                            Rp {{ number_format($cart->product->harga, 0, ',', '.') }}
                                        </div>

                                    </div>


                                    <div class="product-price">

                                        Rp
                                        {{ number_format($cart->total_harga, 0, ',', '.') }}

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        <div style="margin-top:20px;">

                            <div class="summary-row">

                                <span>
                                    Subtotal
                                </span>

                                <strong>
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </strong>

                            </div>


                            <div class="summary-row">

                                <span>
                                    Ongkir
                                </span>

                                <strong>
                                    Rp {{ number_format($ongkir, 0, ',', '.') }}
                                </strong>

                            </div>


                            <div class="summary-row total">

                                <span>
                                    Total
                                </span>

                                <span>
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="checkout-button"
                        >
                            Buat Pesanan
                        </button>


                        <a
                            href="{{ route('cart.index') }}"
                            class="back-cart"
                        >
                            ← Kembali ke Keranjang
                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection