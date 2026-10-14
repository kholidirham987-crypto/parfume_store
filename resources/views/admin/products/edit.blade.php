@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')

<style>
    .product-form-wrapper {
        max-width: 1000px;
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
        font-weight: 700;
        color: #3b2a1d;
    }

    .page-header p {
        margin: 0;
        color: #7b6b5d;
        font-size: 14px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 17px;
        border: 1px solid #d8cec4;
        border-radius: 9px;
        background: #fff;
        color: #5c4b3b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .back-button:hover {
        background: #f5f0ea;
    }

    .form-card {
        background: #fff;
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
        transition: .2s;
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
        box-shadow: 0 0 0 3px rgba(138, 106, 74, .12);
    }

    .current-photo {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 14px;
        margin-bottom: 12px;
        border: 1px solid #e2d8ce;
        border-radius: 10px;
        background: #faf8f5;
    }

    .current-photo img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #ddd2c7;
    }

    .current-photo-info {
        font-size: 13px;
        color: #76695e;
    }

    .current-photo-info strong {
        display: block;
        color: #4b3621;
        margin-bottom: 5px;
    }

    .file-input {
        width: 100%;
        border: 1px solid #d8cec4;
        border-radius: 9px;
        padding: 10px;
        background: #fff;
        font-size: 13px;
    }

    .input-help {
        margin-top: 6px;
        font-size: 12px;
        color: #8a7d72;
    }

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

    .form-footer {
        display: flex;
        justify-content: flex-end;
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
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        font-family: inherit;
    }

    .btn-cancel {
        background: #fff;
        color: #5d5046;
        border-color: #d8cec4;
    }

    .btn-cancel:hover {
        background: #f5f0ea;
    }

    .btn-save {
        background: #4b3621;
        color: #fff;
        border-color: #4b3621;
    }

    .btn-save:hover {
        background: #392818;
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

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .back-button {
            width: 100%;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="product-form-wrapper">

    <div class="page-header">
        <div>
            <h1>Edit Produk</h1>
            <p>Perbarui informasi produk {{ $product->nama_produk }}.</p>
        </div>

        <a href="{{ route('products.index') }}" class="back-button">
            ← Kembali ke Produk
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <strong>Data belum dapat diperbarui.</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">

        <div class="form-card-header">
            <h2>Informasi Produk</h2>
            <p>Periksa kembali data sebelum menyimpan perubahan.</p>
        </div>

        <div class="form-body">

            <form action="{{ route('products.update', $product) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-grid">

                    {{-- KATEGORI --}}
                    <div class="form-group">

                        <label for="category_id" class="form-label">
                            Kategori <span class="required">*</span>
                        </label>

                        <select name="category_id"
                                id="category_id"
                                class="form-select"
                                required>

                            <option value="">-- Pilih Kategori --</option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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

                        <select name="brand_id"
                                id="brand_id"
                                class="form-select"
                                required>

                            <option value="">-- Pilih Merek --</option>

                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->nama_merek }}
                                </option>
                            @endforeach

                        </select>

                        @error('brand_id')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- NAMA --}}
                    <div class="form-group full">

                        <label for="nama_produk" class="form-label">
                            Nama Produk <span class="required">*</span>
                        </label>

                        <input type="text"
                               name="nama_produk"
                               id="nama_produk"
                               class="form-control"
                               value="{{ old('nama_produk', $product->nama_produk) }}"
                               required>

                        @error('nama_produk')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- HARGA --}}
                    <div class="form-group">

                        <label for="harga" class="form-label">
                            Harga <span class="required">*</span>
                        </label>

                        <input type="number"
                               name="harga"
                               id="harga"
                               class="form-control"
                               value="{{ old('harga', $product->harga) }}"
                               min="0"
                               required>

                        @error('harga')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- STOK --}}
                    <div class="form-group">

                        <label for="stok" class="form-label">
                            Stok <span class="required">*</span>
                        </label>

                        <input type="number"
                               name="stok"
                               id="stok"
                               class="form-control"
                               value="{{ old('stok', $product->stok) }}"
                               min="0"
                               required>

                        @error('stok')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- FOTO --}}
                    <div class="form-group full">

                        <label class="form-label">
                            Foto Produk
                        </label>

                        @if($product->foto)
                            <div class="current-photo">

                                <img src="{{ asset('storage/' . $product->foto) }}"
                                     alt="{{ $product->nama_produk }}">

                                <div class="current-photo-info">
                                    <strong>Foto saat ini</strong>
                                    Pilih file baru di bawah jika ingin mengganti foto.
                                </div>

                            </div>
                        @endif

                        <input type="file"
                               name="foto"
                               class="file-input"
                               accept=".jpg,.jpeg,.png,image/jpeg,image/png">

                        <div class="input-help">
                            JPG, JPEG atau PNG. Maksimal 2 MB.
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

                        <textarea name="deskripsi"
                                  id="deskripsi"
                                  class="form-textarea"
                                  placeholder="Tuliskan deskripsi produk...">{{ old('deskripsi', $product->deskripsi) }}</textarea>

                        @error('deskripsi')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>

                </div>

                <div class="form-footer">

                    <a href="{{ route('products.index') }}"
                       class="btn btn-cancel">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-save">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection