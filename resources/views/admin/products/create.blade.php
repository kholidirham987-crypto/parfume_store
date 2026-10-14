@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')

<style>
    .product-form-wrapper {
        max-width: 1000px;
        margin: 0 auto;
    }

    .page-header {
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

    .form-card {
        background: #ffffff;
        border: 1px solid #e7ddd2;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(75, 54, 33, 0.08);
        overflow: hidden;
    }

    .form-card-header {
        padding: 22px 28px;
        background: #faf7f2;
        border-bottom: 1px solid #e8ded3;
    }

    .form-card-header h2 {
        margin: 0;
        font-size: 18px;
        color: #4b3621;
    }

    .form-card-header p {
        margin: 5px 0 0;
        color: #817366;
        font-size: 13px;
    }

    .form-body {
        padding: 30px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #3f3329;
    }

    .required {
        color: #b42318;
    }

    .form-control,
    .form-select,
    .form-textarea {
        width: 100%;
        border: 1px solid #d8cec4;
        border-radius: 9px;
        background: #fff;
        color: #332a23;
        font-size: 14px;
        padding: 12px 14px;
        outline: none;
        transition: 0.2s;
        font-family: inherit;
    }

    .form-control,
    .form-select {
        height: 46px;
    }

    .form-textarea {
        min-height: 130px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-control:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: #8a6a4a;
        box-shadow: 0 0 0 3px rgba(138, 106, 74, 0.12);
    }

    .form-control::placeholder,
    .form-textarea::placeholder {
        color: #aaa19a;
    }

    .input-help {
        margin-top: 6px;
        font-size: 12px;
        color: #8a7d72;
    }

    /* Upload */
    .upload-box {
        border: 2px dashed #d8cec4;
        border-radius: 12px;
        padding: 24px;
        background: #fcfaf7;
        text-align: center;
        transition: 0.2s;
    }

    .upload-box:hover {
        border-color: #8a6a4a;
        background: #faf6f0;
    }

    .upload-icon {
        font-size: 34px;
        margin-bottom: 8px;
    }

    .upload-title {
        font-size: 14px;
        font-weight: 600;
        color: #4b3621;
        margin-bottom: 4px;
    }

    .upload-info {
        font-size: 12px;
        color: #8a7d72;
        margin-bottom: 15px;
    }

    .file-input {
        width: 100%;
        max-width: 420px;
        margin: 0 auto;
        display: block;
        border: 1px solid #d8cec4;
        border-radius: 8px;
        padding: 9px;
        background: #fff;
        font-size: 13px;
    }

    /* Error */
    .alert-error {
        background: #fff1f0;
        border: 1px solid #f2c7c3;
        color: #a12626;
        border-radius: 10px;
        padding: 16px 18px;
        margin-bottom: 22px;
    }

    .alert-error strong {
        display: block;
        margin-bottom: 7px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 20px;
    }

    .field-error {
        color: #b42318;
        font-size: 12px;
        margin-top: 6px;
    }

    /* Buttons */
    .form-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #eee6de;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 20px;
        border-radius: 9px;
        border: 1px solid transparent;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        font-family: inherit;
    }

    .btn-secondary {
        background: #fff;
        color: #5d5046;
        border-color: #d8cec4;
    }

    .btn-secondary:hover {
        background: #f5f0ea;
    }

    .btn-primary {
        background: #4b3621;
        color: #fff;
        border-color: #4b3621;
    }

    .btn-primary:hover {
        background: #392818;
        border-color: #392818;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .form-body {
            padding: 20px;
        }

        .form-card-header {
            padding: 20px;
        }

        .form-footer {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="product-form-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <h1>Tambah Produk</h1>
        <p>Tambahkan produk parfum baru ke dalam katalog toko.</p>
    </div>

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="alert-error">
            <strong>Data belum dapat disimpan.</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM CARD --}}
    <div class="form-card">

        <div class="form-card-header">
            <h2>Informasi Produk</h2>
            <p>Isi data produk dengan lengkap sebelum menyimpan.</p>
        </div>

        <div class="form-body">

            <form action="{{ route('products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-grid">

                    {{-- KATEGORI --}}
                    <div class="form-group">

                        <label for="category_id" class="form-label">
                            Kategori <span class="required">*</span>
                        </label>

                        <select
                            name="category_id"
                            id="category_id"
                            class="form-select"
                            required
                        >
                            <option value="">
                                -- Pilih Kategori --
                            </option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- MEREK --}}
                    <div class="form-group">

                        <label for="brand_id" class="form-label">
                            Merek <span class="required">*</span>
                        </label>

                        <select
                            name="brand_id"
                            id="brand_id"
                            class="form-select"
                            required
                        >
                            <option value="">
                                -- Pilih Merek --
                            </option>

                            @foreach($brands as $brand)
                                <option
                                    value="{{ $brand->id }}"
                                    {{ old('brand_id') == $brand->id ? 'selected' : '' }}
                                >
                                    {{ $brand->nama_merek }}
                                </option>
                            @endforeach
                        </select>

                        @error('brand_id')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- NAMA PRODUK --}}
                    <div class="form-group full">

                        <label for="nama_produk" class="form-label">
                            Nama Produk <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_produk"
                            id="nama_produk"
                            class="form-control"
                            value="{{ old('nama_produk') }}"
                            placeholder="Contoh: Oud Luxury"
                            required
                        >

                        @error('nama_produk')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- HARGA --}}
                    <div class="form-group">

                        <label for="harga" class="form-label">
                            Harga <span class="required">*</span>
                        </label>

                        <input
                            type="number"
                            name="harga"
                            id="harga"
                            class="form-control"
                            value="{{ old('harga') }}"
                            placeholder="Contoh: 150000"
                            min="0"
                            required
                        >

                        <div class="input-help">
                            Masukkan harga dalam Rupiah.
                        </div>

                        @error('harga')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- STOK --}}
                    <div class="form-group">

                        <label for="stok" class="form-label">
                            Stok <span class="required">*</span>
                        </label>

                        <input
                            type="number"
                            name="stok"
                            id="stok"
                            class="form-control"
                            value="{{ old('stok') }}"
                            placeholder="Contoh: 20"
                            min="0"
                            required
                        >

                        <div class="input-help">
                            Jumlah stok produk yang tersedia.
                        </div>

                        @error('stok')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- FOTO --}}
                    <div class="form-group full">

                        <label class="form-label">
                            Foto Produk
                        </label>

                        <div class="upload-box">

                            <div class="upload-icon">
                                📷
                            </div>

                            <div class="upload-title">
                                Upload Foto Produk
                            </div>

                            <div class="upload-info">
                                Format JPG, JPEG atau PNG. Maksimal 2 MB.
                            </div>

                            <input
                                type="file"
                                name="foto"
                                class="file-input"
                                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                            >

                        </div>

                        @error('foto')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group full">

                        <label for="deskripsi" class="form-label">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            id="deskripsi"
                            class="form-textarea"
                            placeholder="Tuliskan deskripsi produk..."
                        >{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="form-footer">

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-secondary"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Simpan Produk
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection