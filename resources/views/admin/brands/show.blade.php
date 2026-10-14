@extends('layouts.admin')

@section('title', 'Detail Merek')

@section('content')

<style>
    .brand-detail-wrapper {
        max-width: 1000px;
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
        transition: .2s;
    }

    .btn-back {
        background: #fff;
        color: #5d5046;
        border-color: #d8cec4;
    }

    .btn-back:hover {
        background: #f5f0ea;
        color: #3f3023;
    }

    .btn-edit {
        background: #4b3621;
        color: #fff;
        border-color: #4b3621;
    }

    .btn-edit:hover {
        background: #392818;
        color: #fff;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e7ddd2;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(75, 54, 33, .08);
        overflow: hidden;
    }

    .detail-top {
        padding: 30px;
        background: #faf7f2;
        border-bottom: 1px solid #e7ddd2;
    }

    .brand-badge {
        display: inline-flex;
        padding: 7px 13px;
        border-radius: 20px;
        background: #e9f0e8;
        color: #416044;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .detail-top h2 {
        margin: 0;
        color: #3b2a1d;
        font-size: 28px;
        overflow-wrap: anywhere;
    }

    .detail-body {
        padding: 30px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
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
        overflow-wrap: anywhere;
    }

    .product-section {
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
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 14px 15px;
        border: 1px solid #e7ddd2;
        border-radius: 9px;
        background: #faf8f5;
    }

    .product-name {
        color: #40362e;
        font-size: 13px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .product-price {
        color: #6a4d31;
        font-size: 12px;
        white-space: nowrap;
    }

    .empty-products {
        padding: 20px;
        border: 1px dashed #d8cec4;
        border-radius: 10px;
        background: #faf8f5;
        color: #8a7d72;
        text-align: center;
        font-size: 13px;
    }

    @media (max-width: 768px) {
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

        .detail-body,
        .detail-top {
            padding: 20px;
        }

        .info-grid,
        .product-list {
            grid-template-columns: 1fr;
        }

        .product-item {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }
    }
</style>

<div class="brand-detail-wrapper">

    <div class="page-header">
        <div>
            <h1>Detail Merek</h1>

            <p>
                Informasi lengkap mengenai merek parfum.
            </p>
        </div>

        <div class="header-actions">
            <a
                href="{{ route('brands.index') }}"
                class="btn btn-back"
            >
                ← Kembali
            </a>

            <a
                href="{{ route('brands.edit', $brand) }}"
                class="btn btn-edit"
            >
                Edit Merek
            </a>
        </div>
    </div>

    <div class="detail-card">

        <div class="detail-top">
            <span class="brand-badge">
                Merek Parfum
            </span>

            <h2>{{ $brand->nama_merek }}</h2>
        </div>

        <div class="detail-body">

            {{-- INFORMASI MEREK --}}
            <div class="info-grid">

                <div class="info-item">
                    <span class="info-label">
                        ID Merek
                    </span>

                    <span class="info-value">
                        #{{ $brand->id }}
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        Nama Merek
                    </span>

                    <span class="info-value">
                        {{ $brand->nama_merek }}
                    </span>
                </div>

            </div>

            {{-- DAFTAR PRODUK --}}
            <div class="product-section">

                <h3>Produk dari Merek Ini</h3>

                @if($brand->products->count() > 0)

                    <div class="product-list">

                        @foreach($brand->products as $product)

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
                        Belum ada produk yang menggunakan merek ini.
                    </div>

                @endif

            </div>

        </div>
    </div>

</div>

@endsection
