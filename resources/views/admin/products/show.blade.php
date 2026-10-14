@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')

<style>
    .detail-wrapper {
        max-width: 1050px;
        margin: 0 auto;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .detail-header h1 {
        margin: 0 0 6px;
        font-size: 28px;
        color: #3b2a1d;
    }

    .detail-header p {
        margin: 0;
        color: #7b6b5d;
        font-size: 14px;
    }

    .header-actions {
        display: flex;
        gap: 9px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 17px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        font-family: inherit;
    }

    .btn-back {
        background: #fff;
        color: #5d5046;
        border-color: #d8cec4;
    }

    .btn-back:hover {
        background: #f5f0ea;
    }

    .btn-edit {
        background: #4b3621;
        color: #fff;
        border-color: #4b3621;
    }

    .btn-edit:hover {
        background: #392818;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e7ddd2;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(75, 54, 33, .08);
        overflow: hidden;
    }

    .detail-main {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 35px;
        padding: 30px;
    }

    /* FOTO */
    .photo-section {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .product-photo {
        width: 100%;
        height: 390px;
        object-fit: cover;
        border-radius: 14px;
        border: 1px solid #dfd5cb;
        background: #f7f3ed;
    }

    .no-photo {
        width: 100%;
        height: 390px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 14px;
        border: 1px solid #dfd5cb;
        background: #f7f3ed;
        color: #8a7d72;
        font-size: 14px;
    }

    .photo-caption {
        color: #8a7d72;
        font-size: 12px;
        text-align: center;
    }

    /* INFO */
    .product-info {
        min-width: 0;
    }

    .product-category {
        display: inline-flex;
        padding: 6px 11px;
        border-radius: 20px;
        background: #f1e8dc;
        color: #6a4d31;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .product-info h2 {
        margin: 0 0 8px;
        font-size: 27px;
        line-height: 1.3;
        color: #3b2a1d;
    }

    .brand-name {
        margin-bottom: 25px;
        color: #75685d;
        font-size: 14px;
    }

    .price-box {
        padding: 17px;
        border-radius: 11px;
        background: #faf7f2;
        border: 1px solid #e7ddd2;
        margin-bottom: 25px;
    }

    .price-label {
        display: block;
        color: #8a7d72;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .price {
        font-size: 25px;
        font-weight: 700;
        color: #4b3621;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 25px;
    }

    .info-item {
        padding: 14px;
        border: 1px solid #e7ddd2;
        border-radius: 10px;
        background: #fff;
    }

    .info-label {
        display: block;
        color: #8a7d72;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #40362e;
    }

    .stock-available {
        color: #416044;
    }

    .stock-empty {
        color: #b42318;
    }

    /* DESKRIPSI */
    .description-section {
        padding: 25px 30px 30px;
        border-top: 1px solid #e9e0d7;
    }

    .description-section h3 {
        margin: 0 0 12px;
        font-size: 17px;
        color: #4b3621;
    }

    .description-text {
        color: #665a50;
        font-size: 14px;
        line-height: 1.8;
        white-space: pre-line;
    }

    .empty-description {
        color: #9a8d82;
        font-style: italic;
    }

    @media (max-width: 850px) {

        .detail-main {
            grid-template-columns: 1fr;
        }

        .product-photo,
        .no-photo {
            height: 350px;
        }
    }

    @media (max-width: 600px) {

        .detail-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }

        .detail-main {
            padding: 20px;
        }

        .description-section {
            padding: 20px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .product-photo,
        .no-photo {
            height: 280px;
        }
    }
</style>

<div class="detail-wrapper">

    {{-- HEADER --}}
    <div class="detail-header">

        <div>
            <h1>Detail Produk</h1>
            <p>Informasi lengkap produk {{ $product->nama_produk }}.</p>
        </div>

        <div class="header-actions">

            <a href="{{ route('products.index') }}"
               class="btn btn-back">
                ← Kembali
            </a>

            <a href="{{ route('products.edit', $product) }}"
               class="btn btn-edit">
                Edit Produk
            </a>

        </div>

    </div>


    {{-- DETAIL CARD --}}
    <div class="detail-card">

        <div class="detail-main">

            {{-- FOTO --}}
            <div class="photo-section">

                @if($product->foto)

                    <img
                        src="{{ asset('storage/' . $product->foto) }}"
                        alt="{{ $product->nama_produk }}"
                        class="product-photo"
                    >

                @else

                    <div class="no-photo">
                        Foto produk belum tersedia
                    </div>

                @endif

                <div class="photo-caption">
                    Foto Produk
                </div>

            </div>


            {{-- INFORMASI --}}
            <div class="product-info">

                @if($product->category)

                    <span class="product-category">
                        {{ $product->category->nama_kategori }}
                    </span>

                @endif

                <h2>
                    {{ $product->nama_produk }}
                </h2>

                <div class="brand-name">
                    Merek:
                    <strong>
                        {{ $product->brand->nama_merek ?? '-' }}
                    </strong>
                </div>


                {{-- HARGA --}}
                <div class="price-box">

                    <span class="price-label">
                        Harga Produk
                    </span>

                    <span class="price">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </span>

                </div>


                {{-- INFORMASI --}}
                <div class="info-grid">

                    <div class="info-item">

                        <span class="info-label">
                            Kategori
                        </span>

                        <span class="info-value">
                            {{ $product->category->nama_kategori ?? '-' }}
                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            Merek
                        </span>

                        <span class="info-value">
                            {{ $product->brand->nama_merek ?? '-' }}
                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            Stok
                        </span>

                        <span class="info-value
                            {{ $product->stok > 0 ? 'stock-available' : 'stock-empty' }}">

                            @if($product->stok > 0)
                                {{ $product->stok }} unit tersedia
                            @else
                                Stok habis
                            @endif

                        </span>

                    </div>


                    <div class="info-item">

                        <span class="info-label">
                            ID Produk
                        </span>

                        <span class="info-value">
                            #{{ $product->id }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- DESKRIPSI --}}
        <div class="description-section">

            <h3>Deskripsi Produk</h3>

            @if($product->deskripsi)

                <div class="description-text">
                    {{ $product->deskripsi }}
                </div>

            @else

                <div class="description-text empty-description">
                    Belum ada deskripsi untuk produk ini.
                </div>

            @endif

        </div>

    </div>

</div>

@endsection