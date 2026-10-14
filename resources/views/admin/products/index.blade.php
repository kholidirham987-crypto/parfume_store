@extends('layouts.admin')

@section('title', 'Produk')

@section('content')

<style>
    .product-page {
        width: 100%;
    }

    /* HEADER */
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
        font-weight: 700;
        color: #3b2a1d;
    }

    .page-header p {
        margin: 0;
        color: #7b6b5d;
        font-size: 14px;
    }

    /* BUTTON TAMBAH */
    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        background: #4b3621;
        color: #ffffff;

        padding: 11px 18px;
        border-radius: 9px;

        text-decoration: none;
        font-size: 14px;
        font-weight: 600;

        border: 1px solid #4b3621;
        transition: 0.2s;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #392818;
        border-color: #392818;
        color: #ffffff;
    }

    .btn-add-icon {
        font-size: 18px;
        line-height: 1;
    }

    /* CARD TABLE */
    .table-card {
        background: #ffffff;
        border: 1px solid #e7ddd2;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(75, 54, 33, 0.07);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        background: #faf7f2;
        border-bottom: 1px solid #e7ddd2;
    }

    .table-header h2 {
        margin: 0;
        font-size: 17px;
        color: #4b3621;
    }

    .table-header span {
        font-size: 13px;
        color: #817366;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .product-table th {
        background: #f5efe8;
        color: #5a4838;
        font-size: 13px;
        font-weight: 700;
        padding: 14px 16px;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #dfd4c9;
    }

    .product-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #eee7df;
        color: #40362e;
        font-size: 14px;
        vertical-align: middle;
    }

    .product-table tbody tr:hover {
        background: #fcfaf7;
    }

    .product-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* FOTO */
    .product-image {
        width: 58px;
        height: 58px;
        object-fit: cover;
        border-radius: 9px;
        border: 1px solid #e0d6cc;
        background: #f7f3ed;
    }

    .no-image {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #f3eee8;
        border: 1px solid #e0d6cc;
        color: #9b8e82;
        font-size: 11px;
        text-align: center;
    }

    .product-name {
        font-weight: 600;
        color: #3b2a1d;
    }

    .product-description {
        color: #8a7d72;
        font-size: 12px;
        margin-top: 4px;
    }

    /* BADGE */
    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-category {
        background: #f1e8dc;
        color: #6a4d31;
    }

    .badge-brand {
        background: #e9f0e8;
        color: #416044;
    }

    .badge-stock {
        background: #edf3ea;
        color: #416044;
    }

    .badge-empty {
        background: #fdeaea;
        color: #a12626;
    }

    /* HARGA */
    .price {
        font-weight: 700;
        color: #4b3621;
        white-space: nowrap;
    }

    /* AKSI */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 7px;
        white-space: nowrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 70px;
        height: 34px;

        padding: 0 10px;

        border-radius: 7px;
        text-decoration: none;

        font-size: 12px;
        font-weight: 600;

        border: 1px solid transparent;
        cursor: pointer;

        transition: 0.2s;
    }

    /* DETAIL */
    .btn-detail {
        background: #f4f0eb;
        color: #5c4b3b;
        border-color: #d9cec2;
    }

    .btn-detail:hover {
        background: #e9e1d8;
        color: #3f3023;
    }

    /* EDIT */
    .btn-edit {
        background: #eee9df;
        color: #6a512f;
        border-color: #d8cbb8;
    }

    .btn-edit:hover {
        background: #e4dacb;
        color: #4f3b22;
    }

    /* HAPUS */
    .btn-delete {
        background: #fff0ef;
        color: #b42318;
        border-color: #f0c8c4;
    }

    .btn-delete:hover {
        background: #fce1df;
        color: #921b12;
    }

    /* EMPTY */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #817366;
    }

    .empty-icon {
        font-size: 40px;
        margin-bottom: 12px;
    }

    .empty-state h3 {
        margin: 0 0 6px;
        color: #4b3621;
        font-size: 18px;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-add {
            width: 100%;
        }

        .table-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }
    }
</style>


<div class="product-page">

    {{-- HEADER --}}
    <div class="page-header">

        <div>
            <h1>Produk</h1>
            <p>Kelola seluruh produk parfum yang tersedia di toko.</p>
        </div>

        {{-- TOMBOL TAMBAH DI KANAN --}}
        <a href="{{ route('products.create') }}" class="btn-add">
            <span class="btn-add-icon">+</span>
            <span>Tambah Produk</span>
        </a>

    </div>


    {{-- TABLE CARD --}}
    <div class="table-card">

        <div class="table-header">
            <h2>Daftar Produk</h2>

            <span>
                Total {{ $products->count() }} produk
            </span>
        </div>


        @if($products->count() > 0)

            <div class="table-wrapper">

                <table class="product-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Merek</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($products as $product)

                            <tr>

                                {{-- NO --}}
                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- FOTO --}}
                                <td>

                                    @if($product->foto)

                                        <img
                                            src="{{ asset('storage/' . $product->foto) }}"
                                            alt="{{ $product->nama_produk }}"
                                            class="product-image"
                                        >

                                    @else

                                        <div class="no-image">
                                            Tidak ada foto
                                        </div>

                                    @endif

                                </td>


                                {{-- PRODUK --}}
                                <td>

                                    <div class="product-name">
                                        {{ $product->nama_produk }}
                                    </div>

                                    @if($product->deskripsi)

                                        <div class="product-description">
                                            {{ Str::limit($product->deskripsi, 45) }}
                                        </div>

                                    @endif

                                </td>


                                {{-- KATEGORI --}}
                                <td>

                                    @if($product->category)

                                        <span class="badge badge-category">
                                            {{ $product->category->nama_kategori }}
                                        </span>

                                    @else

                                        -
                                        
                                    @endif

                                </td>


                                {{-- MEREK --}}
                                <td>

                                    @if($product->brand)

                                        <span class="badge badge-brand">
                                            {{ $product->brand->nama_merek }}
                                        </span>

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- HARGA --}}
                                <td>

                                    <span class="price">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </span>

                                </td>


                                {{-- STOK --}}
                                <td>

                                    @if($product->stok > 0)

                                        <span class="badge badge-stock">
                                            {{ $product->stok }}
                                        </span>

                                    @else

                                        <span class="badge badge-empty">
                                            Habis
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <div class="action-buttons">

                                        {{-- DETAIL --}}
                                        <a
                                            href="{{ route('products.show', $product) }}"
                                            class="action-btn btn-detail"
                                        >
                                            Detail
                                        </a>


                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('products.edit', $product) }}"
                                            class="action-btn btn-edit"
                                        >
                                            Edit
                                        </a>


                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('products.destroy', $product) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                                            style="margin: 0;"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn btn-delete"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    📦
                </div>

                <h3>Belum Ada Produk</h3>

                <p>
                    Silakan tambahkan produk pertama Anda.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection