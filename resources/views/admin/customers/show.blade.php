@extends('layouts.admin')

@section('title', 'Detail Customer')

@section('content')

<div class="page-header">
    <div>
        <h1>Detail Customer</h1>
        <p>Informasi akun customer.</p>
    </div>

    <a href="{{ route('customers.index') }}" class="btn-secondary">
        Kembali
    </a>
</div>

<div class="card">

    <div class="detail-row">
        <span>Nama</span>
        <strong>{{ $customer->name }}</strong>
    </div>

    <div class="detail-row">
        <span>Email</span>
        <strong>{{ $customer->email }}</strong>
    </div>

    <div class="detail-row">
        <span>Role</span>
        <strong>Customer</strong>
    </div>

    <div class="detail-row">
        <span>Bergabung</span>
        <strong>{{ $customer->created_at->format('d F Y') }}</strong>
    </div>

</div>

@endsection