@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<style>

    * {
        box-sizing: border-box;
    }

    .dashboard-header {
        margin-bottom: 28px;
    }

    .dashboard-header h1 {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
        color: #30261d;
    }

    .dashboard-header p {
        margin: 7px 0 0;
        color: #82796f;
        font-size: 14px;
    }


    /* ==========================================
       STATISTIK
    ========================================== */

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #eee6dc;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 16px rgba(70, 50, 30, 0.06);
    }

    .stat-label {
        color: #82796f;
        font-size: 13px;
        margin-bottom: 10px;
    }

    .stat-number {
        color: #30261d;
        font-size: 29px;
        font-weight: 700;
    }


    /* ==========================================
       SECTION TITLE
    ========================================== */

    .section-title {
        margin-bottom: 16px;
    }

    .section-title h2 {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #30261d;
    }

    .section-title p {
        margin: 5px 0 0;
        font-size: 13px;
        color: #82796f;
    }


    /* ==========================================
       LAPORAN
    ========================================== */

    .report-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    .report-card {
        background: #ffffff;
        border: 1px solid #eee6dc;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(70, 50, 30, 0.06);
        overflow: hidden;
    }

    .report-card-header {
        padding: 22px 24px 5px;
    }

    .report-card-header h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #30261d;
    }

    .report-card-header p {
        margin: 5px 0 0;
        font-size: 12px;
        color: #82796f;
    }

    .bar-chart {
        height: 310px;
        padding: 15px 25px 25px;
    }

    .pie-chart {
        height: 310px;
        padding: 20px;
    }


    /* ==========================================
       PESANAN & STOK
    ========================================== */

    .bottom-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .dashboard-card {
        background: #ffffff;
        border: 1px solid #eee6dc;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(70, 50, 30, 0.06);
        overflow: hidden;
    }

    .card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #eee6dc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 17px;
        font-weight: 700;
        color: #30261d;
    }

    .card-subtitle {
        margin-top: 5px;
        color: #82796f;
        font-size: 12px;
    }

    .view-all {
        color: #4b3621;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .view-all:hover {
        text-decoration: underline;
    }


    /* ==========================================
       TABLE PESANAN
    ========================================== */

    .table-wrapper {
        overflow-x: auto;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-table th {
        padding: 14px 24px;
        text-align: left;
        background: #fcfaf7;
        color: #82796f;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .order-table td {
        padding: 16px 24px;
        border-top: 1px solid #f0ebe4;
        color: #40372e;
        font-size: 13px;
    }

    .order-number {
        font-weight: 700;
    }

    .order-description {
        display: block;
        margin-top: 4px;
        color: #968d84;
        font-size: 11px;
    }

    .order-total {
        font-weight: 700;
        white-space: nowrap;
    }


    /* ==========================================
       STATUS
    ========================================== */

    .status {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-pending {
        background: #fff3cd;
        color: #8a6500;
    }

    .status-lunas {
        background: #e7f5e9;
        color: #28753b;
    }

    .status-batal {
        background: #fde8e8;
        color: #a52828;
    }


    /* ==========================================
       STOK
    ========================================== */

    .stock-list {
        padding: 5px 24px 15px;
    }

    .stock-item {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 15px 0;
        border-bottom: 1px solid #f0ebe4;
    }

    .stock-item:last-child {
        border-bottom: none;
    }

    .product-image {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        overflow: hidden;
        background: #f4efe8;
        flex-shrink: 0;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .product-info {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-brand {
        margin-top: 4px;
        color: #968d84;
        font-size: 11px;
    }

    .stock-number {
        text-align: right;
    }

    .stock-value {
        font-size: 16px;
        font-weight: 700;
    }

    .stock-label {
        color: #968d84;
        font-size: 10px;
    }

    .stock-danger {
        color: #b42318;
    }

    .stock-warning {
        color: #9a6700;
    }


    /* ==========================================
       EMPTY
    ========================================== */

    .empty-state {
        padding: 45px 20px;
        text-align: center;
    }

    .empty-icon {
        font-size: 34px;
        margin-bottom: 10px;
    }

    .empty-title {
        margin-bottom: 5px;
        font-weight: 700;
        color: #30261d;
    }

    .empty-text {
        color: #82796f;
        font-size: 12px;
    }


    /* ==========================================
       RESPONSIVE
    ========================================== */

    @media (max-width: 1100px) {

        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .report-grid {
            grid-template-columns: 1fr;
        }

        .bottom-grid {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 600px) {

        .stat-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header h1 {
            font-size: 25px;
        }

    }

</style>


{{-- ==========================================
     HEADER
========================================== --}}

<div class="dashboard-header">

    <h1>
        Dashboard
    </h1>

    <p>
        Selamat datang di Parfum Store Admin.
    </p>

</div>


{{-- ==========================================
     STATISTIK
========================================== --}}

<div class="stat-grid">

    <div class="stat-card">

        <div class="stat-label">
            Total Produk
        </div>

        <div class="stat-number">
            {{ $jumlahProduk }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Total Kategori
        </div>

        <div class="stat-number">
            {{ $jumlahKategori }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Total Merek
        </div>

        <div class="stat-number">
            {{ $jumlahMerek }}
        </div>

    </div>


    <div class="stat-card">

        <div class="stat-label">
            Total Pesanan
        </div>

        <div class="stat-number">
            {{ $jumlahPesanan }}
        </div>

    </div>

</div>


{{-- ==========================================
     LAPORAN DATABASE
========================================== --}}

<div class="section-title">

    <h2>
        Laporan Database
    </h2>

    <p>
        Ringkasan data produk dan pesanan berdasarkan database.
    </p>

</div>


<div class="report-grid">


    {{-- DIAGRAM BATANG --}}

    <div class="report-card">

        <div class="report-card-header">

            <h3>
                Produk per Kategori
            </h3>

            <p>
                Jumlah produk berdasarkan kategori
            </p>

        </div>

        <div class="bar-chart">

            <canvas id="produkKategoriChart"></canvas>

        </div>

    </div>


    {{-- DIAGRAM LINGKARAN --}}

    <div class="report-card">

        <div class="report-card-header">

            <h3>
                Status Pesanan
            </h3>

            <p>
                Distribusi status pesanan
            </p>

        </div>

        <div class="pie-chart">

            <canvas id="statusPesananChart"></canvas>

        </div>

    </div>

</div>


{{-- ==========================================
     PESANAN + STOK
========================================== --}}

<div class="bottom-grid">


    {{-- PESANAN TERBARU --}}

    <div class="dashboard-card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Pesanan Terbaru
                </div>

                <div class="card-subtitle">
                    5 pesanan terakhir
                </div>

            </div>

            <a
                href="{{ route('orders.index') }}"
                class="view-all"
            >
                Lihat Semua
            </a>

        </div>


        @if($pesananTerbaru->count() > 0)

            <div class="table-wrapper">

                <table class="order-table">

                    <thead>

                        <tr>

                            <th>
                                Pesanan
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($pesananTerbaru as $pesanan)

                            <tr>

                                <td>

                                    <span class="order-number">
                                        #{{ $pesanan->id }}
                                    </span>

                                    <span class="order-description">
                                        Pesanan pelanggan
                                    </span>

                                </td>


                                <td>

                                    {{ $pesanan->created_at->format('d M Y') }}

                                    <span class="order-description">
                                        {{ $pesanan->created_at->format('H:i') }}
                                    </span>

                                </td>


                                <td>

                                    <span class="order-total">
                                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                    </span>

                                </td>


                                <td>

                                    @if($pesanan->status === 'Lunas')

                                        <span class="status status-lunas">
                                            Lunas
                                        </span>

                                    @elseif($pesanan->status === 'Batal')

                                        <span class="status status-batal">
                                            Batal
                                        </span>

                                    @else

                                        <span class="status status-pending">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    📦
                </div>

                <div class="empty-title">
                    Belum ada pesanan
                </div>

                <div class="empty-text">
                    Pesanan pelanggan akan muncul di sini.
                </div>

            </div>

        @endif

    </div>


    {{-- STOK RENDAH --}}

    <div class="dashboard-card">

        <div class="card-header">

            <div>

                <div class="card-title">
                    Stok Rendah
                </div>

                <div class="card-subtitle">
                    Produk dengan stok ≤ 5
                </div>

            </div>

            <a
                href="{{ route('products.index') }}"
                class="view-all"
            >
                Produk
            </a>

        </div>


        @if($stokRendah->count() > 0)

            <div class="stock-list">

                @foreach($stokRendah as $product)

                    <div class="stock-item">

                        <div class="product-image">

                            @if($product->foto)

                                <img
                                    src="{{ asset('storage/' . $product->foto) }}"
                                    alt="{{ $product->nama_produk }}"
                                >

                            @else

                                <div class="product-placeholder">
                                    📦
                                </div>

                            @endif

                        </div>


                        <div class="product-info">

                            <div class="product-name">
                                {{ $product->nama_produk }}
                            </div>

                            <div class="product-brand">
                                {{ $product->brand->nama_merek ?? 'Tanpa merek' }}
                            </div>

                        </div>


                        <div class="stock-number">

                            <div class="
                                stock-value
                                {{ $product->stok <= 2 ? 'stock-danger' : 'stock-warning' }}
                            ">

                                {{ $product->stok }}

                            </div>

                            <div class="stock-label">
                                unit
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">
                    ✓
                </div>

                <div class="empty-title">
                    Stok Aman
                </div>

                <div class="empty-text">
                    Tidak ada produk dengan stok rendah.
                </div>

            </div>

        @endif

    </div>

</div>


{{-- ==========================================
     CHART.JS
========================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const kategoriLabels = @json($kategoriLabels);
    const kategoriData = @json($kategoriData);

    const statusLabels = @json($statusLabels);
    const statusData = @json($statusData);


    // ==========================================
    // DIAGRAM BATANG
    // ==========================================

    const produkKategoriChart =
        document.getElementById('produkKategoriChart');

    new Chart(produkKategoriChart, {

        type: 'bar',

        data: {

            labels: kategoriLabels,

            datasets: [

                {
                    label: 'Jumlah Produk',

                    data: kategoriData,

                    borderWidth: 1,

                    borderRadius: 6

                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {
                        precision: 0
                    }

                }

            }

        }

    });


    // ==========================================
    // DIAGRAM LINGKARAN
    // ==========================================

    const statusPesananChart =
        document.getElementById('statusPesananChart');

    new Chart(statusPesananChart, {

        type: 'pie',

        data: {

            labels: statusLabels,

            datasets: [

                {
                    data: statusData,

                    borderWidth: 2
                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    position: 'bottom'

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            const total =
                                context.dataset.data.reduce(
                                    (sum, value) => sum + value,
                                    0
                                );

                            const value = context.parsed;

                            const percentage = total > 0
                                ? ((value / total) * 100).toFixed(1)
                                : 0;

                            return context.label
                                + ': '
                                + value
                                + ' ('
                                + percentage
                                + '%)';

                        }

                    }

                }

            }

        }

    });

</script>

@endsection