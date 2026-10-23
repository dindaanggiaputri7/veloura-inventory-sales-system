
@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('page-heading', 'Dashboard Admin')
@section('page-description', 'Ringkasan operasional dan aktivitas Veloura.')

@section('content')

<style>
    .dashboard-welcome {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 23px 26px;
        margin-bottom: 22px;
        overflow: hidden;
        color: white;
        background: linear-gradient(115deg, #57222f, #804653);
        border-radius: 14px;
        box-shadow: 0 8px 22px rgba(82, 34, 47, .10);
    }

    .welcome-eyebrow {
        margin: 0 0 8px;
        color: #edcfd4;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.7px;
    }

    .dashboard-welcome h2 {
        margin: 0 0 8px;
        color: white;
        font-size: 23px;
        font-weight: 750;
    }

    .welcome-description {
        margin: 0;
        color: #f3e4e5;
        font-size: 12px;
        line-height: 1.7;
    }

    .welcome-date {
        flex-shrink: 0;
        min-width: 130px;
        padding: 13px 15px;
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 11px;
        background: rgba(255,255,255,.09);
    }

    .welcome-date-label {
        margin-bottom: 6px;
        color: #e8cbd0;
        font-size: 10px;
    }

    .welcome-date strong {
        font-size: 12px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 25px 0 13px;
    }

    .section-heading h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 750;
    }

    .section-subtitle {
        margin-top: 5px;
        color: #99878b;
        font-size: 11px;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .stat-card {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-width: 0;
        padding: 18px 16px;
        border: 1px solid #eee2dd;
        border-radius: 12px;
        background: white;
        box-shadow: 0 3px 12px rgba(68, 33, 42, .025);
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(68, 33, 42, .06);
    }

    .stat-icon {
        display: grid;
        flex: 0 0 39px;
        width: 39px;
        height: 39px;
        place-items: center;
        color: #692b3b;
        background: #f6e8e7;
        border-radius: 10px;
    }

    .stat-icon svg {
        width: 19px;
        height: 19px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .stat-label {
        margin: 2px 0 8px;
        color: #95838a;
        font-size: 11px;
    }

    .stat-value {
        margin: 0;
        color: #52232e;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -.6px;
        overflow-wrap: anywhere;
    }

    .stat-note {
        margin: 7px 0 0;
        color: #a18f94;
        font-size: 10px;
        line-height: 1.5;
    }

    .dashboard-columns {
        display: grid;
        grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr);
        gap: 16px;
        align-items: stretch;
        margin-top: 20px;
    }

    .dashboard-panel {
        min-width: 0;
        padding: 19px;
        border: 1px solid #eee2dd;
        border-radius: 13px;
        background: white;
        box-shadow: 0 3px 12px rgba(68, 33, 42, .025);
    }

    .panel-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .panel-heading h3 {
        margin: 0;
        color: #3c292e;
        font-size: 14px;
        font-weight: 750;
    }

    .panel-heading p {
        margin: 5px 0 0;
        color: #a08d92;
        font-size: 10px;
        line-height: 1.5;
    }

    .text-link {
        color: #742f41;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .text-link:hover {
        text-decoration: underline;
    }

    .chart-summary {
        margin-bottom: 12px;
    }

    .chart-summary strong {
        color: #54232f;
        font-size: 23px;
    }

    .chart-summary span {
        display: block;
        margin-top: 4px;
        color: #9a878d;
        font-size: 10px;
    }

    .chart {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 10px;
        height: 170px;
        padding: 10px 0 0;
        border-bottom: 1px solid #eee4e0;
    }

    .chart-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        min-width: 0;
        height: 100%;
    }

    .chart-bar-area {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        width: 100%;
        height: 130px;
        border-bottom: 0;
    }

    .chart-bar {
        width: min(28px, 75%);
        min-height: 4px;
        border-radius: 5px 5px 0 0;
        background: linear-gradient(180deg, #a96678, #632b3b);
        transition: height .25s;
    }

    .chart-bar.today {
        background: linear-gradient(180deg, #d7a0a8, #8a4255);
    }

    .chart-label {
        padding: 8px 0 10px;
        color: #98858b;
        font-size: 10px;
    }

    .chart-label.today {
        color: #682b3b;
        font-weight: 800;
    }

    .table-scroll {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    .dashboard-table th {
        padding: 10px 8px;
        color: #99868b;
        background: #fcf8f5;
        font-size: 10px;
        font-weight: 700;
        text-align: left;
        white-space: nowrap;
    }

    .dashboard-table td {
        padding: 12px 8px;
        border-bottom: 1px solid #f1e8e4;
        vertical-align: middle;
    }

    .dashboard-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .product-name {
        color: #483238;
        font-weight: 700;
    }

    .small-muted {
        margin-top: 4px;
        color: #a08d92;
        font-size: 10px;
    }

    .stock-badge {
        display: inline-block;
        padding: 5px 8px;
        color: #a13c45;
        background: #fff0ee;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 750;
        white-space: nowrap;
    }

    .stock-badge.safe {
        color: #34704b;
        background: #e9f5ed;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 8px;
        color: #8a4b31;
        background: #fbefdd;
        border-radius: 20px;
        font-size: 10px;
        white-space: nowrap;
    }

    .status-badge.completed {
        color: #286a45;
        background: #e8f5eb;
    }

    .status-badge.other {
        color: #765078;
        background: #f3eafa;
    }

    .recent-panel {
        margin-top: 18px;
    }

    .empty-message {
        padding: 22px 12px;
        color: #9b898e;
        font-size: 12px;
        text-align: center;
    }

    .quick-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 19px;
    }

    .quick-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 12px;
        color: #642a3a;
        background: white;
        border: 1px solid #eadbd6;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        transition: background .2s;
    }

    .quick-link:hover {
        background: #f4e6e4;
    }

    @media (max-width: 1150px) {
        .dashboard-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-columns {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .dashboard-welcome {
            align-items: flex-start;
            flex-direction: column;
            padding: 20px;
        }

        .welcome-date {
            width: 100%;
        }

        .dashboard-stats {
            gap: 10px;
        }

        .stat-card {
            gap: 9px;
            padding: 13px 10px;
        }

        .stat-icon {
            flex-basis: 32px;
            width: 32px;
            height: 32px;
        }

        .stat-value {
            font-size: 20px;
        }

        .stat-label {
            font-size: 10px;
        }

        .stat-note {
            font-size: 9px;
        }

        .dashboard-panel {
            padding: 14px;
        }

        .chart {
            gap: 5px;
        }

        .panel-heading {
            flex-wrap: wrap;
        }
    }
</style>

{{-- BANNER SAMBUTAN --}}
<section class="dashboard-welcome">
    <div>
        <p class="welcome-eyebrow">VELOURA INVENTORY &amp; SALES</p>

        <h2>Selamat datang, {{ Auth::user()->name }}!</h2>

        <p class="welcome-description">
            Pantau inventaris dan aktivitas bisnis Veloura dalam satu tempat.
        </p>
    </div>
</section>

{{-- STATISTIK UTAMA --}}
<div class="section-heading">
    <div>
        <h2>Ringkasan Sistem</h2>
        <div class="section-subtitle">Kondisi inventaris dan transaksi saat ini.</div>
    </div>
</div>

<section class="dashboard-stats">
    <article class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="m12 3 9 5-9 5-9-5 9-5Z"/>
                <path d="m3 8 9 5 9-5M3 8v9l9 5 9-5V8M12 13v9"/>
            </svg>
        </div>
        <div>
            <p class="stat-label">Total Produk</p>
            <p class="stat-value">{{ number_format($totalProducts, 0, ',', '.') }}</p>
            <p class="stat-note">Produk terdaftar</p>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 9v4M12 17h.01"/>
                <path d="m10.3 3.9-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.7-3.1l-8-14a2 2 0 0 0-3.4 0Z"/>
            </svg>
        </div>
        <div>
            <p class="stat-label">Stok Menipis</p>
            <p class="stat-value">{{ number_format($lowStockProducts, 0, ',', '.') }}</p>
            <p class="stat-note">Perlu diperiksa</p>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M3 3h2l2.4 12.4a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 8H6"/>
                <circle cx="10" cy="21" r="1"/>
                <circle cx="18" cy="21" r="1"/>
            </svg>
        </div>
        <div>
            <p class="stat-label">Pembelian</p>
            <p class="stat-value">{{ number_format($totalPurchases, 0, ',', '.') }}</p>
            <p class="stat-note">Total transaksi tercatat</p>
        </div>
    </article>

    <article class="stat-card">
        <div class="stat-icon">
            <svg viewBox="0 0 24 24">
                <path d="M3 3v18h18"/>
                <path d="m7 14 4-4 4 3 6-7"/>
            </svg>
        </div>
        <div>
            <p class="stat-label">Penjualan</p>
            <p class="stat-value">{{ number_format($totalSales, 0, ',', '.') }}</p>
            <p class="stat-note">Total transaksi tercatat</p>
        </div>
    </article>
</section>

{{-- GRAFIK DAN STOK --}}
<section class="dashboard-columns">

    <article class="dashboard-panel">
        <div class="panel-heading">
            <div>
                <h3>Grafik Penjualan</h3>
                <p>Nilai penjualan tujuh hari terakhir.</p>
            </div>

            <a href="{{ route('admin.sales.index') }}" class="text-link">
                Lihat semua →
            </a>
        </div>

        <div class="chart-summary">
            <strong>
                Rp {{ number_format(array_sum(array_column($salesChart, 'amount')), 0, ',', '.') }}
            </strong>
            <span>Total penjualan tujuh hari terakhir</span>
        </div>

        <div class="chart" role="img" aria-label="Grafik nilai penjualan selama tujuh hari">
            @foreach ($salesChart as $index => $day)
                @php
                    $barHeight = $chartMax > 0
                        ? max(4, ($day['amount'] / $chartMax) * 120)
                        : 4;
                @endphp

                <div class="chart-column"
                     title="{{ $day['date'] }}: Rp {{ number_format($day['amount'], 0, ',', '.') }}">
                    <div class="chart-bar-area">
                        <div
                            class="chart-bar {{ $index === count($salesChart) - 1 ? 'today' : '' }}"
                            style="height: {{ $barHeight }}px"
                        ></div>
                    </div>

                    <div class="chart-label {{ $index === count($salesChart) - 1 ? 'today' : '' }}">
                        {{ $day['label'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </article>

    <article class="dashboard-panel">
        <div class="panel-heading">
            <div>
                <h3>Produk Stok Menipis</h3>
                <p>Prioritas pemeriksaan persediaan.</p>
            </div>

            <a href="{{ route('admin.products.index') }}" class="text-link">
                Lihat semua →
            </a>
        </div>

        @if ($lowStockList->isEmpty())
            <div class="empty-message">
                <div style="font-size:25px;margin-bottom:8px">✓</div>
                Semua produk berada di atas batas stok minimum.
            </div>
        @else
            <div class="table-scroll">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Stok</th>
                            <th>Minimum</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($lowStockList as $product)
                            <tr>
                                <td>
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="small-muted">{{ $product->sku }}</div>
                                </td>

                                <td>{{ $product->stock }}</td>

                                <td>{{ $product->minimum_stock }}</td>

                                <td>
                                    <span class="stock-badge">
                                        {{ $product->stock == 0 ? 'Habis' : 'Menipis' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </article>

</section>

{{-- TRANSAKSI TERBARU --}}
<section class="dashboard-panel recent-panel">
    <div class="panel-heading">
        <div>
            <h3>Transaksi Penjualan Terbaru</h3>
            <p>Pantau transaksi yang baru dicatat dalam sistem.</p>
        </div>

        <a href="{{ route('admin.sales.index') }}" class="text-link">
            Lihat semua transaksi →
        </a>
    </div>

    @if ($recentSales->isEmpty())
        <div class="empty-message">
            Belum ada transaksi penjualan.
            Transaksi yang dibuat akan muncul di bagian ini.
        </div>
    @else
        <div class="table-scroll">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Jumlah Item</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($recentSales as $sale)
                        @php
                            $saleStatus = strtolower((string) $sale->status);
                            $statusClass = $saleStatus === 'completed'
                                ? 'completed'
                                : 'other';
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <span class="product-name">
                                    {{ $sale->sale_number }}
                                </span>

                                <div class="small-muted">
                                    {{ $sale->source_type === 'online'
                                        ? 'Pesanan Customer'
                                        : 'Penjualan langsung' }}
                                </div>
                            </td>

                            <td>
                                {{ \Illuminate\Support\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                            </td>

                            <td>{{ $sale->customer_name ?: 'Pelanggan umum' }}</td>

                            <td>{{ $sale->items_count }}</td>

                            <td style="font-weight:700;white-space:nowrap">
                                Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

{{-- AKSES CEPAT --}}
<div class="section-heading">
    <div>
        <h2>Akses Cepat</h2>
        <div class="section-subtitle">Buka modul yang sering digunakan.</div>
    </div>
</div>

<div class="quick-links">
    <a href="{{ route('admin.products.index') }}" class="quick-link">
        + Kelola Produk
    </a>

    <a href="{{ route('admin.suppliers.index') }}" class="quick-link">
        + Kelola Supplier
    </a>

</div>

@endsection
