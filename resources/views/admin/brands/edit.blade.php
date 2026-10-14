@extends('layouts.admin')

@section('title', 'Edit Merek')

@section('content')

<style>
    .brand-form-wrapper {
        max-width: 900px;
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

    .back-btn,
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 0 18px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        font-family: inherit;
    }

    .back-btn {
        background: #fff;
        color: #5d5046;
        border: 1px solid #d8cec4;
    }

    .back-btn:hover {
        background: #f5f0ea;
    }

    .form-card {
        background: #fff;
        border: 1px solid #e7ddd2;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(75, 54, 33, .08);
        overflow: hidden;
    }

    .form-header {
        padding: 22px 28px;
        background: #faf7f2;
        border-bottom: 1px solid #e7ddd2;
    }

    .form-header h2 {
        margin: 0;
        font-size: 18px;
        color: #4b3621;
    }

    .form-header p {
        margin: 5px 0 0;
        color: #817366;
        font-size: 13px;
    }

    .form-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #3f3329;
    }

    .required {
        color: #b42318;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        height: 46px;
        border: 1px solid #d8cec4;
        border-radius: 9px;
        background: #fff;
        color: #332a23;
        font-size: 14px;
        padding: 12px 14px;
        outline: none;
        font-family: inherit;
        transition: .2s;
    }

    .form-control:focus {
        border-color: #8a6a4a;
        box-shadow: 0 0 0 3px rgba(138, 106, 74, .12);
    }

    .field-error {
        margin-top: 6px;
        color: #b42318;
        font-size: 12px;
    }

    .alert-error {
        padding: 16px 18px;
        margin-bottom: 22px;
        border-radius: 10px;
        background: #fff1f0;
        border: 1px solid #f2c7c3;
        color: #a12626;
    }

    .alert-error strong {
        display: block;
        margin-bottom: 7px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 20px;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #eee6de;
    }

    .btn-cancel {
        background: #fff;
        color: #5d5046;
        border: 1px solid #d8cec4;
    }

    .btn-cancel:hover {
        background: #f5f0ea;
    }

    .btn-save {
        background: #4b3621;
        color: #fff;
        border: 1px solid #4b3621;
    }

    .btn-save:hover {
        background: #392818;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .back-btn {
            width: 100%;
        }

        .form-body {
            padding: 20px;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="brand-form-wrapper">

    <div class="page-header">
        <div>
            <h1>Edit Merek</h1>

            <p>
                Perbarui nama merek
                "{{ $brand->nama_merek }}".
            </p>
        </div>

        <a
            href="{{ route('brands.index') }}"
            class="back-btn"
        >
            ← Kembali ke Merek
        </a>
    </div>

    @if($errors->any())
        <div class="alert-error">
            <strong>Data belum dapat diperbarui.</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">

        <div class="form-header">
            <h2>Edit Informasi Merek</h2>

            <p>
                Periksa kembali nama merek sebelum menyimpan perubahan.
            </p>
        </div>

        <div class="form-body">

            <form
                action="{{ route('brands.update', $brand) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label
                        for="nama_merek"
                        class="form-label"
                    >
                        Nama Merek
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_merek"
                        id="nama_merek"
                        class="form-control"
                        value="{{ old('nama_merek', $brand->nama_merek) }}"
                        maxlength="255"
                        placeholder="Contoh: Dior"
                        required
                        autofocus
                    >

                    @error('nama_merek')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-footer">
                    <a
                        href="{{ route('brands.index') }}"
                        class="btn btn-cancel"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-save"
                    >
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
