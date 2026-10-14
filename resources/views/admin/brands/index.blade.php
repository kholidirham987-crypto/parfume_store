
@extends('layouts.admin')

@section('title', 'Merek')

@section('content')

<style>
    .brand-page {
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
        color: #fff;
        padding: 11px 18px;
        border-radius: 9px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #4b3621;
        white-space: nowrap;
        transition: .2s;
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

    .brand-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .brand-table th {
        background: #f5efe8;
        color: #5a4838;
        font-size: 13px;
        font-weight: 700;
        padding: 14px 18px;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #dfd4c9;
    }

    .brand-table td {
        padding: 15px 18px;
        border-bottom: 1px solid #eee7df;
        color: #40362e;
        font-size: 14px;
        vertical-align: middle;
    }

    .brand-table tbody tr:hover {
        background: #fcfaf7;
    }

    .brand-table tbody tr:last-child td {
        border-bottom: none;
    }

    .number {
        width: 65px;
        color: #817366;
        font-weight: 600;
    }

    .brand-name {
        font-weight: 600;
        color: #3b2a1d;
    }

    .product-count {
        display: inline-flex;
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
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: .2s;
        font-family: inherit;
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

    .alert-success {
        margin-bottom: 20px;
        padding: 13px 16px;
        border: 1px solid #c9e4ce;
        border-radius: 9px;
        background: #edf8ef;
        color: #286438;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-add {
            width: 100%;
        }

        .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }
</style>

<div class="brand-page">

    <div class="page-header">
        <div>
            <h1>Merek</h1>
            <p>Kelola daftar merek parfum yang tersedia di toko.</p>
        </div>

        <a href="{{ route('brands.create') }}" class="btn-add">
            <span class="btn-add-icon">+</span>
            <span>Tambah Merek</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">

        <div class="table-header">
            <h2>Daftar Merek</h2>

            <span>
                Total {{ $brands->count() }} merek
            </span>
        </div>

        @if($brands->count() > 0)

            <div class="table-wrapper">
                <table class="brand-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Merek</th>
                            <th>Jumlah Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td class="number">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <div class="brand-name">
                                        {{ $brand->nama_merek }}
                                    </div>
                                </td>

                                <td>
                                    <span class="product-count">
                                        {{ $brand->products_count }} produk
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">

                                        <a
                                            href="{{ route('brands.show', $brand) }}"
                                            class="action-btn btn-detail">
                                            Detail
                                        </a>

                                        <a
                                            href="{{ route('brands.edit', $brand) }}"
                                            class="action-btn btn-edit">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('brands.destroy', $brand) }}"
                                            method="POST"
                                            style="margin: 0;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus merek ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
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
                <div class="empty-icon">🏷️</div>

                <h3>Belum Ada Merek</h3>

                <p>
                    Silakan tambahkan merek parfum pertama Anda.
                </p>
            </div>

        @endif

    </div>

</div>

@endsection
