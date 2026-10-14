@extends('layouts.customer')

@section('title', 'Parfum Store')

@section('content')

<div class="container py-5">

    {{-- =========================================================
        HERO
    ========================================================== --}}
    <div class="row align-items-center mb-5">

        <div class="col-lg-7">

            <span class="badge bg-success-subtle text-success mb-3">
                Premium Fragrance
            </span>

            <h1 class="display-5 fw-bold">
                Temukan Aroma
                <span class="text-success">Favoritmu</span>
            </h1>

            <p class="text-muted fs-5">
                Koleksi parfum pilihan dengan aroma elegan
                untuk menemani setiap momen.
            </p>

        </div>

    </div>


    {{-- =========================================================
        HEADER PRODUK
    ========================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Koleksi Parfum
            </h3>

            <p class="text-muted mb-0">
                Temukan parfum yang sesuai dengan karakter Anda.
            </p>
        </div>

    </div>


    {{-- =========================================================
        PESAN SUCCESS / ERROR
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>

    @endif


    {{-- =========================================================
        PRODUK
    ========================================================== --}}

    @if($products->count() > 0)

        <div class="row g-4">

            @foreach($products as $product)

                <div class="col-6 col-md-4 col-lg-3">

                    <div class="card h-100 border-0 shadow-sm"
                         style="border-radius: 14px; overflow: hidden;">

                        {{-- FOTO PRODUK --}}
                        @if($product->foto)

                            <img
                                src="{{ asset('storage/' . $product->foto) }}"
                                class="card-img-top"
                                style="height: 260px; object-fit: cover;"
                                alt="{{ $product->nama_produk }}">

                        @else

                            <div
                                class="d-flex align-items-center justify-content-center bg-light"
                                style="height: 260px;">

                                <span class="text-muted">
                                    Tidak ada foto
                                </span>

                            </div>

                        @endif


                        {{-- INFORMASI PRODUK --}}
                        <div class="card-body d-flex flex-column">

                            {{-- MEREK --}}
                            <small class="text-success fw-semibold">
                                {{ $product->brand->nama_merek ?? 'Tanpa Merek' }}
                            </small>


                            {{-- NAMA PRODUK --}}
                            <h5 class="fw-bold mt-2">
                                {{ $product->nama_produk }}
                            </h5>


                            {{-- DESKRIPSI --}}
                            <p class="text-muted small">
                                {{ Str::limit($product->deskripsi, 70) }}
                            </p>


                            {{-- HARGA --}}
                            <div class="fw-bold fs-5 mb-3">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </div>


                            {{-- STOK --}}
                            <small class="text-muted mb-3">
                                Stok: {{ $product->stok }}
                            </small>


                            {{-- =================================================
                                TOMBOL KERANJANG
                            ================================================== --}}
                            <div class="d-grid mt-auto">

                                @auth

                                    {{-- CUSTOMER SUDAH LOGIN --}}
                                    <form
                                        action="{{ route('cart.add', $product) }}"
                                        method="POST">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-success w-100">

                                            🛒 Tambah ke Keranjang

                                        </button>

                                    </form>

                                @else

                                    {{-- BELUM LOGIN --}}
                                    <a
                                        href="{{ route('login') }}"
                                        class="btn btn-outline-success w-100">

                                        Login untuk Membeli

                                    </a>

                                @endauth

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- =========================================================
            PAGINATION
        ========================================================== --}}

        <div class="mt-5">

            {{ $products->links() }}

        </div>

    @else

        {{-- =========================================================
            PRODUK KOSONG
        ========================================================== --}}

        <div class="text-center py-5">

            <h5>
                Produk tidak ditemukan
            </h5>

            <p class="text-muted">
                Coba gunakan kata pencarian yang berbeda.
            </p>

        </div>

    @endif

</div>

@endsection