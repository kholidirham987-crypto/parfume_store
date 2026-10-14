@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')

<style>
    .category-page {
        width: 100%;
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
        font-weight: 700;
        color: #3b2a1d;
    }

    .page-header p {
        margin: 0;
        color: #7b6b5d;
        font-size: 14px;
    }

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
        transition: .2s;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #392818;
        color: #fff;
    }

    .btn-add-icon {
        font-size: 18px;
        line-height: 1;
    }

    .table-card {
        background: #fff;
        border: 1px solid #e7ddd2;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(75, 54, 33, .07);
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

    .category-table {
        width: 100%;
        border-collapse: collapse;
    }

    .category-table th {
        background: #f5efe8;
        color: #5a4838;
        font-size: 13px;
        font-weight: 700;
        padding: 14px 20px;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #dfd4c9;
    }

    .category-table td {
        padding: 15px 20px;
        border-bottom: 1px solid #eee7df;
        color: #40362e;
        font-size: 14px;
        vertical-align: middle;
    }

    .category-table tbody tr:hover {
        background: #fcfaf7;
    }

    .category-table tbody tr:last-child td {
        border-bottom: none;
    }

    .number {
        width: 70px;
        color: #817366;
        font-weight: 600;
    }

    .category-name {
        font-weight: 600;
        color: #3b2a1d;
    }

    .category-description {
        color: #8a7d72;
        font-size: 12px;
        margin-top: 4px;
    }

    .product-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 35px;
        padding: 5px 10px;
        border-radius: 20px;
        background: #f1e8dc;
        color: #6a4d31;
        font-size: 12px;
        font-weight: 600;
    }

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
        min-width: 68px;
        height: 34px;
        padding: 0 10px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid transparent;
        cursor: pointer;
        transition: .2s;
    }

    .btn-detail {
        background: #f4f0eb;
        color: #5c4b3b;
        border-color: #d9cec2;
    }

    .btn-detail:hover {
        background: #e9e1d8;
        color: #3f3023;
    }

    .btn-edit {
        background: #eee9df;
        color: #6a512f;
        border-color: #d8cbb8;
    }

    .btn-edit:hover {
        background: #e4dacb;
        color: #4f3b22;
    }

    .btn-delete {
        background: #fff0ef;
        color: #b42318;
        border-color: #f0c8c4;
    }

    .btn-delete:hover {
        background: #fce1df;
        color: #921b12;
    }

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

        .category-table {
            min-width: 700px;
        }
    }
</style>


<div class="category-page">

    {{-- HEADER --}}
    <div class="page-header">

        <div>
            <h1>Kategori</h1>

            <p>
                Kelola kategori produk parfum yang tersedia di toko.
            </p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="btn-add">

            <span class="btn-add-icon">+</span>

            <span>
                Tambah Kategori
            </span>

        </a>

    </div>


    {{-- TABLE --}}
    <div class="table-card">

        <div class="table-header">

            <h2>
                Daftar Kategori
            </h2>

            <span>
                Total {{ $categories->count() }} kategori
            </span>

        </div>


        @if($categories->count() > 0)

            <div class="table-wrapper">

                <table class="category-table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Produk</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($categories as $category)

                            <tr>

                                {{-- NOMOR --}}
                                <td class="number">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- NAMA --}}
                                <td>

                                    <div class="category-name">
                                        {{ $category->nama_kategori }}
                                    </div>

                                    @if(!empty($category->deskripsi))

                                        <div class="category-description">
                                            {{ Str::limit($category->deskripsi, 60) }}
                                        </div>

                                    @endif

                                </td>


                                {{-- JUMLAH PRODUK --}}
                                <td>

                                    <span class="product-count">

                                        {{ $category->products_count ?? $category->products->count() }}

                                        produk

                                    </span>

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <div class="action-buttons">

                                        <a href="{{ route('categories.show', $category) }}"
                                           class="action-btn btn-detail">
                                            Detail
                                        </a>


                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="action-btn btn-edit">
                                            Edit
                                        </a>


                                        <form action="{{ route('categories.destroy', $category) }}"
                                              method="POST"
                                              style="margin: 0;"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="action-btn btn-delete">
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
                    📂
                </div>

                <h3>
                    Belum Ada Kategori
                </h3>

                <p>
                    Silakan tambahkan kategori produk pertama Anda.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection