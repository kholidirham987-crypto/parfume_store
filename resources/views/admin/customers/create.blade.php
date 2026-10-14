@extends('layouts.admin')

@section('title', 'Tambah Customer')

@section('content')

<div class="page-header">
    <div>
        <h1>Tambah Customer</h1>
        <p>Buat akun customer baru.</p>
    </div>
</div>

<div class="card form-card">

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Customer</label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Masukkan nama customer"
                required
            >

            @error('name')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="contoh@email.com"
                required
            >

            @error('email')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Minimal 8 karakter"
                required
            >

            @error('password')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                required
            >
        </div>

        <div class="form-actions">

            <a href="{{ route('customers.index') }}" class="btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn-primary">
                Simpan Customer
            </button>

        </div>

    </form>

</div>

@endsection