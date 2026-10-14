@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('content')

<style>
    .category-detail-wrapper {
        max-width: 950px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin: 0 0 6px;
        font-size: 28px;
        color: #3b2a1d;
    }

    .page-header p {
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
        cursor: pointer;
        border: 1px solid transparent;
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
        box-shadow: 0 6px 20px rgba(75,54,33,.08);
        overflow: hidden;
    }

    .detail-header {
        padding: 25px 30px;
        background: #faf7f2;
        border-bottom: 1px solid #e7ddd2;
    }

    .category-badge {
        display: inline-flex;
        padding: 7px 13px;
        border-radius: 20px;
        background: #f1e8dc;
        color: #6a4d31;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .detail-header h2 {
        margin: 0;
        color: #3b2a1d;
        font-size: 26px;
    }

    .detail-body {
        padding: 30px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .info-item {
        padding: 17px;
        border: 1px solid #e7ddd2;
        border-radius: 11px;
        background: #fff;
    }

    .info-label {
        display: block;
        margin-bottom: 7px;
        color: #8a7d72;
        font-size: 12px;
    }

    .info-value {
        color: #40362e;
        font-size: 15px;
        font-weight: 600;
    }

    .product-count {
        color: #416044;
    }

    .description-box {
        border-top: 1px solid #eee6de;
        padding-top: 25px;
    }

    .description-box h3 {
        margin: 0 0 12px;
        color: #4b3621;
        font-size: 17px;
    }

    .description {
        color: #665a50;
        font-size: 14px;
        line-height: 1.8;
        white-space: pre-line;
    }

    .empty-description {
        color: #9a8d82;
        font-style: italic;
    }

    .product-section {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #eee6de;
    }

    .product-section h3 {
        margin: 0 0 15px;
        color: #4b3621;
        font-size: 17px;
    }

    .product-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .product-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 13px 15px;
        border: 1px solid #e7ddd2;
        border-radius: 9px;
        background: #faf8f5;
    }

    .product-name {
        color: #40362e;
        font-size: 13px;
        font-weight: 600;
    }

    .product-price {
        color: #6a4d31;
        font-size: 12px;
        white-space: nowrap;
    }

    .empty-products {
        padding: 20px;
        border-radius: 10px;
        background: #faf8f5;
        border: 1px dashed #d8cec4;
        color: #8a7d72;
        font-size: 13px;
        text-align: center;
    }

    @media(max-width: 768px) {

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .product-list {
            grid-template-columns: 1fr;
        }

        .detail-body {
            padding: 20px;
        }

        .detail-header {
            padding: 20px;
        }
    }
</style>


<div class="category-detail-wrapper">

    {{-- HEADER --}}
    <div class="page-header">

        <div>
            <h1>Detail Kategori</h1>

            <p>
                Informasi lengkap kategori produk.
            </p>
        </div>

        <div class="header-actions">

            <a
                href="{{ route('categories.index') }}"
                class="btn btn-back"
            >
                ← Kembali
            </a>

            <a
                href="{{ route('categories.edit', $category) }}"
                class="btn btn-edit"
            >
                Edit Kategori
            </a>

        </div>

    </div>


    {{-- CARD --}}
    <div class="detail-card">

        <div class="detail-header">

            <span class="category-badge">
                Kategori Produk
            </span>

            <h2>
                {{ $category->nama_kategori }}
            </h2>

        </div>


        <div class="detail-body">

            {{-- INFORMASI --}}
            <div class="info-grid">

                <div class="info-item">

                    <span class="info-label">
                        ID Kategori
                    </span>

                    <span class="info-value">
                        #{{ $category->id }}
                    </span>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Nama Kategori
                    </span>

                    <span class="info-value">
                        {{ $category->nama_kategori }}
                    </span>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Jumlah Produk
                    </span>

                    <span class="info-value product-count">
                        {{ $category->products->count() }} produk
                    </span>

                </div>

            </div>


            {{-- DESKRIPSI --}}
            <div class="description-box">

                <h3>
                    Deskripsi Kategori
                </h3>

                @if($category->deskripsi)

                    <div class="description">
                        {{ $category->deskripsi }}
                    </div>

                @else

                    <div class="description empty-description">
                        Belum ada deskripsi untuk kategori ini.
                    </div>

                @endif

            </div>


            {{-- PRODUK DALAM KATEGORI --}}
            <div class="product-section">

                <h3>
                    Produk dalam Kategori
                </h3>

                @if($category->products->count() > 0)

                    <div class="product-list">

                        @foreach($category->products as $product)

                            <div class="product-item">

                                <span class="product-name">
                                    {{ $product->nama_produk }}
                                </span>

                                <span class="product-price">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="empty-products">
                        Belum ada produk yang menggunakan kategori ini.
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection