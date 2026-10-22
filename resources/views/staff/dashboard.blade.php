
@extends('staff.layout')

@section('title', 'Dashboard Staff')
@section('page-heading', 'Dashboard Staff')
@section('page-description', 'Pantau stok dan aktivitas operasional Veloura.')

@section('content')

<style>
    .staff-dashboard { color: #3c292e; }
    .staff-dashboard * { box-sizing: border-box; }

    .staff-dashboard .welcome {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding: 24px 25px;
        margin-bottom: 24px;
        color: white;
        background: linear-gradient(115deg, #57222f, #804653);
        border-radius: 13px;
        box-shadow: 0 8px 22px rgba(82,34,47,.09);
    }

    .staff-dashboard .eyebrow {
        margin: 0 0 9px;
        color: #edcfd4;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
    }

    .staff-dashboard .welcome h2 {
        margin: 0 0 9px;
        color: white;
        font-size: 22px;
    }

    .staff-dashboard .welcome p {
        margin: 0;
        color: #f3e4e5;
        font-size: 12px;
        line-height: 1.7;
    }

    .staff-dashboard .date-box {
        flex-shrink: 0;
        padding: 13px 15px;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 10px;
        background: rgba(255,255,255,.09);
    }

    .staff-dashboard .date-box small {
        display: block;
        margin-bottom: 7px;
        color: #e8cbd0;
        font-size: 10px;
    }

    .staff-dashboard .date-box strong { font-size: 12px; }

    .staff-dashboard .section-heading {
        margin: 24px 0 13px;
    }

    .staff-dashboard .section-heading h2 {
        margin: 0;
        font-size: 16px;
    }

    .staff-dashboard .section-heading p {
        margin: 5px 0 0;
        color: #99878b;
        font-size: 11px;
    }

    .staff-dashboard .stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
    }

    .staff-dashboard .stat-card {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        min-width: 0;
        padding: 17px 14px;
        border: 1px solid #eee2dd;
        border-radius: 12px;
        background: white;
        box-shadow: 0 3px 12px rgba(68,33,42,.025);
    }

    .staff-dashboard .stat-icon {
        display: grid;
        place-items: center;
        flex: 0 0 38px;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #f6e8e7;
        color: #692b3b;
        font-size: 17px;
    }

    .staff-dashboard .stat-label {
        margin: 2px 0 8px;
        color: #95838a;
        font-size: 11px;
    }

    .staff-dashboard .stat-value {
        margin: 0;
        color: #52232e;
        font-size: 24px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .staff-dashboard .stat-note {
        margin: 6px 0 0;
        color: #a18f94;
        font-size: 10px;
        line-height: 1.5;
    }

    .staff-dashboard .columns {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(0, 1fr);
        gap: 15px;
        margin-top: 18px;
    }

    .staff-dashboard .panel {
        min-width: 0;
        padding: 18px;
        border: 1px solid #eee2dd;
        border-radius: 12px;
        background: white;
        box-shadow: 0 3px 12px rgba(68,33,42,.025);
    }

    .staff-dashboard .panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 16px;
    }

    .staff-dashboard .panel-heading h3 {
        margin: 0;
        font-size: 14px;
    }

    .staff-dashboard .panel-heading p {
        margin: 5px 0 0;
        color: #a08d92;
        font-size: 10px;
        line-height: 1.5;
    }

    .staff-dashboard .tag {
        padding: 6px 8px;
        border-radius: 6px;
        color: #742f41;
        background: #f7efeb;
        font-size: 10px;
        white-space: nowrap;
    }

    .staff-dashboard .chart-total {
        margin-bottom: 10px;
    }

    .staff-dashboard .chart-total strong {
        color: #54232f;
        font-size: 23px;
    }

    .staff-dashboard .chart-total span {
        display: block;
        margin-top: 4px;
        color: #9a878d;
        font-size: 10px;
    }

    .staff-dashboard .chart {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 9px;
        height: 165px;
        padding-top: 8px;
        border-bottom: 1px solid #eee4e0;
    }

    .staff-dashboard .chart-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        height: 100%;
        min-width: 0;
    }

    .staff-dashboard .bar-area {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        width: 100%;
        height: 125px;
    }

    .staff-dashboard .bar {
        width: min(27px, 75%);
        min-height: 4px;
        border-radius: 5px 5px 0 0;
        background: linear-gradient(180deg, #a96678, #632b3b);
    }

    .staff-dashboard .bar.today {
        background: linear-gradient(180deg, #d7a0a8, #8a4255);
    }

    .staff-dashboard .day-label {
        padding: 8px 0;
        color: #98858b;
        font-size: 10px;
    }

    .staff-dashboard .table-scroll { width: 100%; overflow-x: auto; }

    .staff-dashboard table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    .staff-dashboard th {
        padding: 10px 8px;
        color: #99868b;
        background: #fcf8f5;
        font-size: 10px;
        text-align: left;
        white-space: nowrap;
    }

    .staff-dashboard td {
        padding: 12px 8px;
        border-bottom: 1px solid #f1e8e4;
        vertical-align: middle;
    }

    .staff-dashboard tbody tr:last-child td { border-bottom: none; }

    .staff-dashboard .product-name {
        color: #483238;
        font-weight: 700;
    }

    .staff-dashboard .muted {
        margin-top: 4px;
        color: #a08d92;
        font-size: 10px;
    }

    .staff-dashboard .badge {
        display: inline-block;
        padding: 5px 8px;
        border-radius: 20px;
        background: #fff0ee;
        color: #a13c45;
        font-size: 10px;
        white-space: nowrap;
    }

    .staff-dashboard .badge.success {
        background: #e8f5eb;
        color: #286a45;
    }

    .staff-dashboard .badge.other {
        background: #f3eafa;
        color: #765078;
    }

    .staff-dashboard .empty {
        padding: 22px 10px;
        color: #9b898e;
        text-align: center;
        line-height: 1.7;
    }

    .staff-dashboard .quick-links {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 13px;
    }

    .staff-dashboard .quick-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 13px;
        border: 1px solid #eadbd6;
        border-radius: 8px;
        background: white;
        color: #642a3a;
        font-size: 11px;
        font-weight: 700;
    }

    .staff-dashboard .quick-link:hover { background: #f4e6e4; }

    @media (max-width: 1150px) {
        .staff-dashboard .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .staff-dashboard .columns { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .staff-dashboard .welcome { align-items: flex-start; flex-direction: column; padding: 20px; }
        .staff-dashboard .date-box { width: 100%; }
        .staff-dashboard .stats { gap: 9px; }
        .staff-dashboard .stat-card { gap: 8px; padding: 13px 10px; }
        .staff-dashboard .stat-icon { flex-basis: 32px; width: 32px; height: 32px; }
        .staff-dashboard .stat-value { font-size: 20px; }
        .staff-dashboard .panel { padding: 13px; }
    }
</style>

<div class="staff-dashboard">

    <section class="welcome">
        <div>
            <div class="eyebrow">VELOURA INVENTORY &amp; SALES</div>
            <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
            <p>
                Pantau stok, layani transaksi penjualan, dan pastikan
                operasional Veloura berjalan dengan baik.
            </p>
        </div>
    </section>

    <div class="section-heading">
        <h2>Ringkasan Operasional</h2>
        <p>Kondisi inventaris dan transaksi saat ini.</p>
    </div>

    <section class="stats">
        <article class="stat-card">
            <div class="stat-icon">▦</div>
            <div>
                <p class="stat-label">Total Produk</p>
                <p class="stat-value">{{ number_format($totalProducts, 0, ',', '.') }}</p>
                <p class="stat-note">Produk terdaftar</p>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-icon">⚠</div>
            <div>
                <p class="stat-label">Stok Menipis</p>
                <p class="stat-value">{{ number_format($lowStockProducts, 0, ',', '.') }}</p>
                <p class="stat-note">Produk perlu diperiksa</p>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-icon">▣</div>
            <div>
                <p class="stat-label">Penjualan Hari Ini</p>
                <p class="stat-value">{{ number_format($todaySalesCount, 0, ',', '.') }}</p>
                <p class="stat-note">Transaksi hari ini</p>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-icon">↗</div>
            <div>
                <p class="stat-label">Total Penjualan</p>
                <p class="stat-value">{{ number_format($totalSales, 0, ',', '.') }}</p>
                <p class="stat-note">Transaksi tercatat</p>
            </div>
        </article>
    </section>

    @php
        $salesByDay = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);

            return [
                'label' => $date->format('d/m'),
                'amount' => \App\Models\Sale::whereDate(
                    'sale_date',
                    $date->toDateString()
                )->count(),
            ];
        });

        $chartMax = max(1, $salesByDay->max('amount'));
    @endphp

    <section class="columns">
        <article class="panel">
            <div class="panel-heading">
                <div>
                    <h3>Penjualan 7 Hari Terakhir</h3>
                    <p>Jumlah transaksi per hari.</p>
                </div>
            </div>

            <div class="chart-total">
                <strong>{{ $salesByDay->sum('amount') }}</strong>
                <span>Total transaksi selama tujuh hari terakhir</span>
            </div>

            <div class="chart">
                @foreach ($salesByDay as $index => $day)
                    @php
                        $barHeight = $day['amount'] > 0
                            ? max(8, ($day['amount'] / $chartMax) * 115)
                            : 4;
                    @endphp

                    <div class="chart-column"
                         title="{{ $day['label'] }}: {{ $day['amount'] }} transaksi">
                        <div class="bar-area">
                            <div class="bar {{ $index === 6 ? 'today' : '' }}"
                                 style="height: {{ $barHeight }}px"></div>
                        </div>
                        <div class="day-label">{{ $day['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="panel" id="produk">
            <div class="panel-heading">
                <div>
                    <h3>Produk Stok Menipis</h3>
                    <p>Prioritas pemeriksaan persediaan.</p>
                </div>
                <span class="tag">{{ $lowStockProducts }} produk</span>
            </div>

            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Stok</th>
                            <th>Minimum</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowStockList as $product)
                            <tr>
                                <td>
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="muted">{{ $product->sku ?? '-' }}</div>
                                </td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->minimum_stock }}</td>
                                <td>
                                    <span class="badge">
                                        {{ $product->stock <= 0 ? 'Habis' : 'Menipis' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty">
                                    Tidak ada produk yang stoknya menipis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>

    <section class="panel" id="transaksi" style="margin-top:18px">
        <div class="panel-heading">
            <div>
                <h3>Transaksi Penjualan Terbaru</h3>
                <p>Ringkasan transaksi yang sudah tercatat.</p>
            </div>
            <span class="tag">{{ $totalSales }} transaksi</span>
        </div>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentSales as $sale)
                        @php
                            $status = strtolower((string) $sale->status);
                            $badgeClass = $status === 'completed'
                                ? 'success'
                                : 'other';
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="product-name">{{ $sale->sale_number }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                            <td>{{ $sale->customer_name ?: 'Pelanggan umum' }}</td>
                            <td style="white-space:nowrap;font-weight:700">
                                Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada transaksi penjualan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="panel" style="margin-top:18px">
        <div class="panel-heading">
            <div>
                <h3>Produk Terlaris</h3>
                <p>Produk dengan jumlah penjualan tertinggi.</p>
            </div>
        </div>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bestSellingProducts as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="product-name">
                                {{ $item->product?->name ?? 'Produk tidak tersedia' }}
                            </td>
                            <td>{{ number_format($item->total_sold, 0, ',', '.') }} unit</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="empty">
                                Data produk terlaris muncul setelah ada penjualan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="section-heading">
        <h2>Akses Cepat</h2>
        <p>Pintasan ke informasi operasional.</p>
    </div>

    <div class="quick-links">
        <a href="#produk" class="quick-link">▦ Periksa Stok</a>
        <a href="#transaksi" class="quick-link">↗ Lihat Transaksi</a>
    </div>

</div>

@endsection
