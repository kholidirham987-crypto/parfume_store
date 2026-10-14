@extends('layouts.admin')

@section('title', 'Edit Customer')

@section('content')

<div class="page-header">
    <div>
        <h1>Edit Customer</h1>
        <p>Perbarui informasi akun customer.</p>
    </div>
</div>

<div class="card form-card">

    <form action="{{ route('customers.update', $customer) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Customer</label>

            <input
                type="text"
                name="name"
                value="{{ old('name', $customer->name) }}"
                required
            >
        </div>

        <div class="form-group">
            <label>Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email', $customer->email) }}"
                required
            >
        </div>

        <div class="form-group">
            <label>Password Baru</label>

            <input
                type="password"
                name="password"
                placeholder="Kosongkan jika tidak ingin mengubah password"
            >
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password baru"
            >
        </div>

        <div class="form-actions">

            <a href="{{ route('customers.index') }}" class="btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn-primary">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection