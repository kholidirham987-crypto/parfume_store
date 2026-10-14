@extends('layouts.admin')

@section('content')
<div class="report-page">

    {{-- HEADER --}}
    <div class="report-header">
        <div>
            <div class="report-eyebrow">ADMINISTRASI / LAPORAN</div>
            <h1>Laporan Penjualan</h1>
            <p>Pantau performa transaksi dan penjualan parfum Anda.</p>
        </div>

        <button type="button" class="report-print" onclick="window.print()">
            <i class="bi bi-printer"></i>
            Cetak Laporan
        </button>
    </div>

    {{-- FILTER PERIODE --}}
    <section class="report-panel report-filter">
        <div class="panel-heading">
            <div class="panel-icon">
                <i class="bi bi-calendar3"></i>
            </div>
            <div>
                <h2>Periode Laporan</h2>
                <p>Pilih rentang tanggal transaksi yang ingin ditampilkan.</p>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.reports.index') }}"
              class="filter-form">
            <div class="filter-field">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input id="tanggal_mulai" type="date" name="tanggal_mulai"
                       value="{{ $tanggalMulai }}" required>
            </div>

            <div class="filter-field">
                <label for="tanggal_akhir">Tanggal Akhir</label>
                <input id="tanggal_akhir" type="date" name="tanggal_akhir"
                       value="{{ $tanggalAkhir }}" required>
            </div>

            <button type="submit" class="filter-submit">
                <i class="bi bi-funnel"></i>
                Terapkan
            </button>

            <a href="{{ route('admin.reports.index') }}" class="filter-reset">
                Reset
            </a>
        </form>

        @if ($errors->any())
            <div class="report-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- RINGKASAN --}}
    <div class="report-section-title">
        <div>
            <h2>Ringkasan Penjualan</h2>
            <p>Data berdasarkan periode yang dipilih.</p>
        </div>
        <span class="period-badge">
            <i class="bi bi-calendar-check"></i>
            {{ \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') }}
            –
            {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}
        </span>
    </div>

    <div class="report-stats">
        <article class="stat-card stat-revenue">
            <div class="stat-top">
                <span>Total Penjualan</span>
                <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
            </div>
            <div class="stat-value">
                Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
            </div>
            <div class="stat-foot">
                <i class="bi bi-check-circle"></i>
                Dari pesanan selesai
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span>Transaksi Selesai</span>
                <div class="stat-icon"><i class="bi bi-bag-check"></i></div>
            </div>
            <div class="stat-value">{{ number_format($jumlahTransaksi) }}</div>
            <div class="stat-foot">Pesanan berhasil diselesaikan</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <span>Rata-rata Transaksi</span>
                <div class="stat-icon"><i class="bi bi-calculator"></i></div>
            </div>
            <div class="stat-value">
                Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}
            </div>
            <div class="stat-foot">Nilai rata-rata per pesanan</div>
        </article>

        <article class="stat-card stat-pending">
            <div class="stat-top">
                <span>Menunggu Verifikasi</span>
                <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
            </div>
            <div class="stat-value">{{ number_format($menungguVerifikasi) }}</div>
            <div class="stat-foot">Perlu pemeriksaan admin</div>
        </article>
    </div>

    {{-- GRAFIK DAN PEMBAYARAN --}}
    <div class="report-section-title">
        <div>
            <h2>Analisis Penjualan</h2>
            <p>Tren transaksi selesai dan metode pembayaran.</p>
        </div>
    </div>

    <div class="report-analysis">
        <section class="report-panel chart-panel">
            <div class="panel-heading">
                <div class="panel-icon"><i class="bi bi-bar-chart-line"></i></div>
                <div>
                    <h2>Tren Penjualan Harian</h2>
                    <p>Nilai penjualan pada setiap tanggal.</p>
                </div>
            </div>

            @if ($transaksiHarian->isEmpty())
                <div class="report-empty">
                    <i class="bi bi-bar-chart"></i>
                    <strong>Belum ada data penjualan</strong>
                    <span>Pilih periode lain untuk melihat transaksi.</span>
                </div>
            @else
                @php
                    $nilaiMaksimum = max(1, $transaksiHarian->max('total'));
                @endphp

                <div class="chart-area">
                    @foreach ($transaksiHarian as $data)
                        <div class="chart-column">
                            <div class="chart-number">
                                {{ $data['jumlah'] }}
                            </div>
                            <div class="chart-bar-wrap">
                                <div class="chart-bar"
                                     style="height: {{ max(5, ($data['total'] / $nilaiMaksimum) * 150) }}px"
                                     title="Rp {{ number_format($data['total'], 0, ',', '.') }}">
                                </div>
                            </div>
                            <div class="chart-date">
                                {{ \Carbon\Carbon::parse($data['tanggal'])->format('d/m') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="chart-legend">
                    <span class="legend-dot"></span>
                    Total penjualan per hari
                    <span class="legend-note">Angka di atas batang = jumlah transaksi</span>
                </div>
            @endif
        </section>

        <section class="report-panel payment-panel">
            <div class="panel-heading">
                <div class="panel-icon"><i class="bi bi-credit-card"></i></div>
                <div>
                    <h2>Metode Pembayaran</h2>
                    <p>Nilai penjualan berdasarkan metode.</p>
                </div>
            </div>

            @php
                $totalMetode = $totalDana + $totalCod;
                $persenDana = $totalMetode > 0 ? ($totalDana / $totalMetode) * 100 : 0;
                $persenCod = $totalMetode > 0 ? ($totalCod / $totalMetode) * 100 : 0;
            @endphp

            <div class="payment-summary">
                <div class="payment-row">
                    <div class="payment-label">
                        <span class="payment-dot dana-dot"></span>
                        <span>DANA</span>
                    </div>
                    <strong>Rp {{ number_format($totalDana, 0, ',', '.') }}</strong>
                </div>
                <div class="payment-track">
                    <div class="payment-fill dana-fill"
                         style="width: {{ $persenDana }}%"></div>
                </div>

                <div class="payment-row">
                    <div class="payment-label">
                        <span class="payment-dot cod-dot"></span>
                        <span>COD</span>
                    </div>
                    <strong>Rp {{ number_format($totalCod, 0, ',', '.') }}</strong>
                </div>
                <div class="payment-track">
                    <div class="payment-fill cod-fill"
                         style="width: {{ $persenCod }}%"></div>
                </div>
            </div>

            <div class="payment-total">
                <span>Total kedua metode</span>
                <strong>Rp {{ number_format($totalMetode, 0, ',', '.') }}</strong>
            </div>
        </section>
    </div>

    {{-- TABEL TRANSAKSI --}}
    <section class="report-panel transaction-panel">
        <div class="transaction-heading">
            <div class="panel-heading">
                <div class="panel-icon"><i class="bi bi-receipt"></i></div>
                <div>
                    <h2>Riwayat Transaksi</h2>
                    <p>Daftar pesanan yang sudah selesai pada periode ini.</p>
                </div>
            </div>

            <span class="transaction-count">
                {{ $pesananSelesai->count() }} transaksi
            </span>
        </div>

        <div class="table-responsive">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Metode</th>
                        <th class="text-end">Total</th>
                        <th class="no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesananSelesai as $order)
                        <tr>
                            <td class="row-number">{{ $loop->iteration }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td><span class="order-code">{{ $order->kode_pesanan }}</span></td>
                            <td>
                                <div class="customer-name">
                                    {{ $order->user->name ?? $order->nama_penerima }}
                                </div>
                                <small class="customer-subtitle">
                                    {{ $order->nama_penerima }}
                                </small>
                            </td>
                            <td>
                                <span class="payment-badge">
                                    {{ strtoupper($order->metode_pembayaran) }}
                                </span>
                            </td>
                            <td class="text-end amount-cell">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="no-print">
                                <a href="{{ route('orders.show', $order) }}"
                                   class="detail-button" title="Lihat detail pesanan">
                                    <i class="bi bi-eye"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="table-empty">
                                    <i class="bi bi-inbox"></i>
                                    <strong>Belum ada transaksi selesai</strong>
                                    <span>Data akan muncul setelah pesanan berstatus selesai.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($pesananSelesai->isNotEmpty())
                    <tfoot>
                        <tr>
                            <td colspan="5">Total Penjualan</td>
                            <td class="text-end">
                                Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                            </td>
                            <td class="no-print"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </section>

</div>

<style>
.report-page {
    --report-brown: #6f4e37;
    --report-brown-dark: #4d3528;
    --report-cream: #f7f2eb;
    --report-border: #ebe4dc;
    --report-text: #332820;
    --report-muted: #897d73;
    color: var(--report-text);
    padding-bottom: 30px;
}
.report-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 26px;
}
.report-eyebrow {
    color: var(--report-brown);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.5px;
    margin-bottom: 7px;
}
.report-header h1 {
    font-size: clamp(24px, 3vw, 30px);
    font-weight: 800;
    letter-spacing: -.7px;
    margin: 0 0 7px;
}
.report-header p, .panel-heading p, .report-section-title p {
    color: var(--report-muted);
    font-size: 13px;
    margin: 0;
}
.report-print, .filter-submit {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    border: 0;
    border-radius: 10px;
    background: var(--report-brown);
    color: white;
    padding: 11px 16px;
    font-size: 13px;
    font-weight: 700;
    transition: background .2s, transform .2s;
}
.report-print:hover, .filter-submit:hover {
    background: var(--report-brown-dark);
    color: white;
    transform: translateY(-1px);
}
.report-panel {
    background: #fff;
    border: 1px solid var(--report-border);
    border-radius: 15px;
    box-shadow: 0 4px 18px rgba(62, 43, 29, .035);
}
.report-filter { padding: 20px; margin-bottom: 27px; }
.panel-heading {
    display: flex;
    align-items: center;
    gap: 12px;
}
.panel-icon {
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    display: grid;
    place-items: center;
    border-radius: 12px;
    background: var(--report-cream);
    color: var(--report-brown);
    font-size: 18px;
}
.panel-heading h2 {
    font-size: 15px;
    font-weight: 800;
    margin: 0 0 5px;
}
.filter-form {
    display: grid;
    grid-template-columns: minmax(150px, 1fr) minmax(150px, 1fr) auto auto;
    align-items: end;
    gap: 13px;
    margin-top: 21px;
}
.filter-field label {
    display: block;
    margin-bottom: 7px;
    font-size: 12px;
    font-weight: 700;
}
.filter-field input {
    width: 100%;
    min-height: 43px;
    padding: 9px 11px;
    border: 1px solid #ded5cc;
    border-radius: 9px;
    color: var(--report-text);
    background: #fff;
    font-size: 13px;
}
.filter-field input:focus {
    outline: none;
    border-color: var(--report-brown);
    box-shadow: 0 0 0 3px rgba(111, 78, 55, .1);
}
.filter-reset {
    min-height: 43px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 15px;
    border: 1px solid #ded5cc;
    border-radius: 9px;
    color: var(--report-brown);
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
}
.filter-reset:hover { background: var(--report-cream); }
.report-error {
    margin-top: 15px;
    padding: 12px;
    border-radius: 8px;
    background: #fff0ef;
    color: #a12b26;
    font-size: 13px;
}
.report-section-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin: 0 0 15px;
}
.report-section-title h2 {
    font-size: 17px;
    font-weight: 800;
    margin: 0 0 5px;
}
.period-badge, .transaction-count {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 11px;
    border-radius: 8px;
    background: var(--report-cream);
    color: var(--report-brown);
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}
.report-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 15px;
    margin-bottom: 28px;
}
.stat-card {
    min-width: 0;
    padding: 19px;
    border: 1px solid var(--report-border);
    border-radius: 15px;
    background: #fff;
    box-shadow: 0 4px 18px rgba(62, 43, 29, .035);
}
.stat-revenue {
    background: linear-gradient(135deg, #6f4e37, #4d3528);
    border-color: transparent;
    color: #fff;
}
.stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    color: var(--report-muted);
    font-size: 12px;
    font-weight: 700;
}
.stat-revenue .stat-top, .stat-revenue .stat-foot { color: #eaded4; }
.stat-icon {
    width: 36px;
    height: 36px;
    flex: 0 0 36px;
    display: grid;
    place-items: center;
    border-radius: 10px;
    background: var(--report-cream);
    color: var(--report-brown);
    font-size: 17px;
}
.stat-revenue .stat-icon {
    background: rgba(255,255,255,.14);
    color: #fff;
}
.stat-value {
    overflow-wrap: anywhere;
    margin: 19px 0 12px;
    font-size: clamp(17px, 1.7vw, 23px);
    line-height: 1.3;
    font-weight: 800;
    letter-spacing: -.5px;
}
.stat-foot {
    color: var(--report-muted);
    font-size: 11px;
}
.stat-pending .stat-icon { background: #fff3df; color: #9b681b; }
.report-analysis {
    display: grid;
    grid-template-columns: minmax(0, 1.5fr) minmax(280px, 1fr);
    gap: 17px;
    margin-bottom: 28px;
}
.chart-panel, .payment-panel { padding: 21px; min-width: 0; }
.chart-area {
    display: flex;
    align-items: end;
    gap: 13px;
    min-height: 205px;
    padding: 20px 5px 0;
    overflow-x: auto;
}
.chart-column {
    flex: 1 0 42px;
    min-width: 42px;
    text-align: center;
}
.chart-number {
    min-height: 18px;
    margin-bottom: 5px;
    color: var(--report-muted);
    font-size: 10px;
    font-weight: 700;
}
.chart-bar-wrap {
    display: flex;
    align-items: end;
    justify-content: center;
    height: 155px;
    border-bottom: 1px solid var(--report-border);
    background: repeating-linear-gradient(
        to top, transparent 0, transparent 37px, #f2eee9 38px
    );
}
.chart-bar {
    width: min(30px, 75%);
    min-height: 5px;
    border-radius: 6px 6px 0 0;
    background: linear-gradient(180deg, #b08a68, #6f4e37);
    transition: opacity .2s;
}
.chart-bar:hover { opacity: .72; }
.chart-date {
    margin-top: 9px;
    color: var(--report-muted);
    font-size: 10px;
}
.chart-legend {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 18px;
    color: var(--report-muted);
    font-size: 11px;
}
.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--report-brown);
}
.legend-note { margin-left: auto; }
.report-empty, .table-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 35px 15px;
    color: var(--report-muted);
    text-align: center;
    font-size: 12px;
}
.report-empty i, .table-empty i { font-size: 27px; color: #b6a596; }
.report-empty strong, .table-empty strong { color: var(--report-text); font-size: 13px; }
.payment-summary { margin-top: 28px; }
.payment-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 11px;
    font-size: 12px;
}
.payment-row strong { font-size: 12px; }
.payment-label { display: flex; align-items: center; gap: 8px; }
.payment-dot { width: 9px; height: 9px; border-radius: 50%; }
.dana-dot { background: #3687d8; }
.cod-dot { background: #6f4e37; }
.payment-track {
    height: 8px;
    overflow: hidden;
    border-radius: 99px;
    background: #f0ebe6;
    margin-bottom: 25px;
}
.payment-fill { height: 100%; border-radius: inherit; }
.dana-fill { background: #3687d8; }
.cod-fill { background: #6f4e37; }
.payment-total {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding-top: 17px;
    border-top: 1px solid var(--report-border);
    font-size: 11px;
    color: var(--report-muted);
}
.payment-total strong { color: var(--report-text); font-size: 13px; }
.transaction-panel { overflow: hidden; }
.transaction-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 21px;
}
.report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}
.report-table thead { background: #f8f5f1; }
.report-table th {
    padding: 14px 16px;
    color: #796b60;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .45px;
    white-space: nowrap;
    border-top: 1px solid var(--report-border);
    border-bottom: 1px solid var(--report-border);
}
.report-table td {
    padding: 15px 16px;
    border-bottom: 1px solid #f0ebe6;
    vertical-align: middle;
}
.report-table tbody tr:hover { background: #fdfbf9; }
.row-number { color: #a09285; }
.order-code { color: var(--report-brown); font-weight: 800; white-space: nowrap; }
.customer-name { font-weight: 700; color: var(--report-text); }
.customer-subtitle { display: block; margin-top: 4px; color: var(--report-muted); }
.payment-badge {
    display: inline-block;
    padding: 5px 8px;
    border-radius: 6px;
    background: var(--report-cream);
    color: var(--report-brown);
    font-size: 10px;
    font-weight: 800;
}
.amount-cell { white-space: nowrap; font-weight: 800; }
.detail-button {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 10px;
    border: 1px solid #dfd2c6;
    border-radius: 8px;
    color: var(--report-brown);
    text-decoration: none;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}
.detail-button:hover { background: var(--report-cream); color: var(--report-brown-dark); }
.report-table tfoot td {
    padding: 17px 16px;
    background: #f8f5f1;
    border-top: 1px solid var(--report-border);
    font-weight: 800;
}
@media (max-width: 1200px) {
    .report-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 900px) {
    .report-analysis { grid-template-columns: 1fr; }
    .filter-form { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .filter-submit, .filter-reset { min-height: 43px; }
}
@media (max-width: 576px) {
    .report-header { align-items: flex-start; flex-direction: column; }
    .report-print { width: 100%; }
    .report-filter, .chart-panel, .payment-panel { padding: 15px; }
    .filter-form { grid-template-columns: 1fr; }
    .report-stats { grid-template-columns: 1fr; gap: 10px; }
    .stat-card { padding: 16px; }
    .report-section-title { align-items: flex-start; flex-direction: column; }
    .transaction-heading { align-items: flex-start; flex-direction: column; padding: 16px; }
    .legend-note { width: 100%; margin-left: 15px; }
}
@media print {
    body { background: #fff !important; }
    .report-page { padding: 0 !important; }
    .report-print, .report-filter, .no-print, nav, aside,
    .sidebar, .filter-form, .report-eyebrow { display: none !important; }
    .report-panel, .stat-card {
        box-shadow: none !important;
        break-inside: avoid;
    }
    .report-stats { grid-template-columns: repeat(4, 1fr) !important; }
    .report-analysis { grid-template-columns: 1.5fr 1fr !important; }
    .report-table { font-size: 10px; }
    .report-table th, .report-table td { padding: 8px; }
}
</style>
@endsection
