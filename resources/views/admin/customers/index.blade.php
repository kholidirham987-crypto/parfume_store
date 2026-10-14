@extends('layouts.admin')

@section('title', 'Customer')

@section('content')

<div class="page-header">
    <div>
        <h1>Customer</h1>
        <p>Kelola akun customer Parfum Store.</p>
    </div>

    <a href="{{ route('customers.create') }}" class="btn-primary">
        + Tambah Customer
    </a>
</div>

<div class="card">

    <div class="card-header">
        <strong>Daftar Customer</strong>
        <span>{{ $customers->count() }} Customer</span>
    </div>

    @if($customers->count() > 0)

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $customer->name }}</strong>
                            </td>

                            <td>{{ $customer->email }}</td>

                            <td>
                                <span class="badge-customer">
                                    Customer
                                </span>
                            </td>

                            <td>
                                {{ $customer->created_at->format('d/m/Y') }}
                            </td>

                            <td>
                                <div class="action-group">

                                    <a href="{{ route('customers.show', $customer) }}"
                                       class="btn-view">
                                        Detail
                                    </a>

                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('customers.destroy', $customer) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus customer ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete">
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
            <h3>Belum ada customer</h3>
            <p>Silakan buat akun customer melalui tombol Tambah Customer.</p>

            <a href="{{ route('customers.create') }}" class="btn-primary">
                + Tambah Customer
            </a>
        </div>

    @endif

</div>

@endsection