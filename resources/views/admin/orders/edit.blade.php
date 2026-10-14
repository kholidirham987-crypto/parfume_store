@extends('layouts.admin')

@section('title', 'Edit Status Pesanan')

@section('content')

<style>
    .page-header {
        margin-bottom: 24px;
    }

    .page-title {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        color: #4b3621;
    }

    .page-desc {
        margin-top: 5px;
        color: #7b6a58;
        font-size: 14px;
    }

    .status-card {
        max-width: 650px;
        background: #fffdf8;
        border: 1px solid #eadfce;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 5px 18px rgba(75,54,33,.06);
    }

    .order-info {
        background: #f7f0e6;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 22px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 7px 0;
        font-size: 14px;
    }

    .label {
        color: #776858;
    }

    .value {
        font-weight: 600;
        color: #4b3621;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #4b3621;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #d9cbb8;
        border-radius: 9px;
        box-sizing: border-box;
        background: white;
    }

    .button-row {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
    }

    .btn {
        padding: 11px 18px;
        border-radius: 9px;
        border: none;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-back {
        background: #eee5d8;
        color: #4b3621;
    }

    .btn-save {
        background: #4b3621;
        color: white;
    }
</style>

<div class="page-header">
    <h1 class="page-title">Edit Status Pesanan</h1>
    <p class="page-desc">
        Perbarui status pesanan pelanggan.
    </p>
</div>

<div class="status-card">

    <div class="order-info">
        <div class="info-row">
            <span class="label">Kode Pesanan</span>
            <span class="value">
                {{ $order->kode_pesanan ?? '#' . $order->id }}
            </span>
        </div>

        <div class="info-row">
            <span class="label">Penerima</span>
            <span class="value">
                {{ $order->nama_penerima }}
            </span>
        </div>

        <div class="info-row">
            <span class="label">Total</span>
            <span class="value">
                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="form-label">
            Status Pesanan
        </label>

        <select name="status" class="form-control" required>
            <option value="Pending"
                {{ $order->status === 'Pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="Lunas"
                {{ $order->status === 'Lunas' ? 'selected' : '' }}>
                Lunas
            </option>

            <option value="Batal"
                {{ $order->status === 'Batal' ? 'selected' : '' }}>
                Batal
            </option>
        </select>

        <div class="button-row">
            <a href="{{ route('orders.index') }}" class="btn btn-back">
                Batal
            </a>

            <button type="submit" class="btn btn-save">
                Simpan Status
            </button>
        </div>
    </form>

</div>

@endsection