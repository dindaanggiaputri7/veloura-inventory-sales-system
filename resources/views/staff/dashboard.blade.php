@extends('staff.layout')

@section('title', 'Dashboard Staff')
@section('page-heading', 'Dashboard Staff')
@section('page-description', 'Ringkasan inventaris, penjualan, pesanan Customer, dan pembelian Veloura.')

@push('styles')
<style>
.staff-dashboard{display:flex;flex-direction:column;gap:20px}
.staff-welcome{display:flex;justify-content:space-between;align-items:center;gap:18px;padding:23px 26px;border-radius:14px;background:linear-gradient(115deg,#57222f,#804653);color:#fff;box-shadow:0 8px 22px rgba(82,34,47,.10)}
.staff-welcome-kicker{margin:0 0 8px;color:#edcfd4;font-size:10px;font-weight:800;letter-spacing:1.7px;text-transform:uppercase}
.staff-welcome h2{margin:0 0 8px;color:#fff;font-size:23px;font-weight:800}
.staff-welcome p{margin:0;color:#f3e4e5;font-size:12px;line-height:1.7}
.staff-welcome-date{flex-shrink:0;padding:12px 15px;border:1px solid rgba(255,255,255,.18);border-radius:10px;background:rgba(255,255,255,.08);font-size:11px;color:#f3e4e5}
.staff-welcome-date strong{display:block;margin-top:5px;color:#fff;font-size:12px}
.staff-section-heading{display:flex;justify-content:space-between;align-items:flex-end;gap:12px;margin:3px 0 13px}
.staff-section-heading h3{margin:0;font-size:16px;font-weight:750;color:#38252b}
.staff-section-heading p{margin:5px 0 0;color:#99878b;font-size:11px;line-height:1.5}
.staff-section-heading a,.staff-link{color:#722d40;font-weight:700;font-size:11px;text-decoration:none;white-space:nowrap}
.staff-section-heading a:hover,.staff-link:hover{text-decoration:underline}
.staff-stat-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
.staff-stat-card{display:flex;align-items:flex-start;gap:12px;min-width:0;min-height:108px;padding:18px 16px;background:#fff;border:1px solid #eadbd6;border-radius:12px;box-shadow:0 3px 12px rgba(66,35,42,.025)}
.staff-stat-icon{display:grid;place-items:center;flex:0 0 39px;width:39px;height:39px;border-radius:10px;background:#f6e8e8;color:#702d40;font-size:19px}
.staff-stat-label{margin:2px 0 7px;color:#99878b;font-size:11px}
.staff-stat-value{font-size:24px;font-weight:800;line-height:1.15;letter-spacing:-.4px;overflow-wrap:anywhere;color:#57222f}
.staff-stat-note{margin-top:7px;color:#a08e92;font-size:10px;line-height:1.5}
.staff-dashboard-grid{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(280px,1fr);gap:16px;align-items:stretch}
.staff-dashboard-card{min-width:0;padding:19px;background:#fff;border:1px solid #eadbd6;border-radius:12px;box-shadow:0 3px 12px rgba(66,35,42,.025)}
.staff-chart-legend{display:flex;gap:15px;flex-wrap:wrap;margin:4px 0 12px;color:#88777b;font-size:11px}
.staff-legend-dot{display:inline-block;width:8px;height:8px;margin-right:6px;border-radius:50%}
.staff-chart{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:10px;align-items:end;height:170px;padding-top:8px}
.staff-chart-day{display:flex;flex-direction:column;justify-content:flex-end;align-items:center;height:100%;min-width:0}
.staff-chart-bars{display:flex;align-items:flex-end;justify-content:center;gap:3px;width:100%;height:130px;border-bottom:1px solid #f0e5e2}
.staff-chart-bar{width:min(21px,31%);min-height:2px;border-radius:5px 5px 0 0}
.staff-chart-label{margin-top:8px;color:#99878b;font-size:10px}
.staff-chart-date{color:#b09da1;font-size:9px;margin-top:3px}
.staff-chart-foot{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px;margin-top:15px;padding-top:13px;border-top:1px solid #f2e9e6;color:#99878b;font-size:10px}
.staff-chart-foot strong{display:block;margin-top:5px;color:#57222f;font-size:13px;overflow-wrap:anywhere}
.staff-chart-foot span{display:block;margin-top:4px;font-size:10px;line-height:1.4}
.staff-data-table{width:100%;border-collapse:collapse;font-size:11px}
.staff-data-table th{padding:10px 8px;text-align:left;color:#806d72;background:#fcf8f5;font-weight:700;white-space:nowrap;font-size:10px}
.staff-data-table td{padding:11px 8px;border-bottom:1px solid #f2e9e6;vertical-align:middle}
.staff-data-table tr:last-child td{border-bottom:0}
.staff-table-wrap{width:100%;overflow-x:auto}
.staff-product-name{color:#483238;font-weight:700}
.staff-muted{margin-top:4px;color:#a08d92;font-size:10px}
.staff-pill{display:inline-block;padding:4px 7px;border-radius:20px;background:#f7eeee;color:#762f43;font-size:10px;white-space:nowrap}
.staff-status{display:inline-block;padding:5px 8px;border-radius:20px;background:#fbefdd;color:#8a4b31;font-size:10px;white-space:nowrap}
.staff-status.completed,.staff-status.delivered{background:#e8f5eb;color:#286a45}
.staff-status.cancelled{background:#fff0ee;color:#a13c45}
.staff-status.processing{background:#f3eafa;color:#765078}
.staff-empty{padding:23px 10px;text-align:center;color:#99878b;font-size:11px}
.staff-bottom-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
.staff-quick-links{display:flex;flex-wrap:wrap;gap:8px;margin-top:14px}
.staff-quick-link{display:inline-flex;align-items:center;gap:6px;padding:9px 11px;border:1px solid #eadbd6;border-radius:8px;color:#57222f;text-decoration:none;font-size:11px;font-weight:700;background:#fff}
.staff-quick-link:hover{background:#f8efed}
.staff-order-row{padding:12px 0;border-bottom:1px solid #f2e9e6}
.staff-order-row:last-child{border-bottom:0}
.staff-order-title{display:flex;justify-content:space-between;align-items:flex-start;gap:10px}
.staff-order-title strong{font-size:11px;overflow-wrap:anywhere}
.staff-order-meta{display:flex;justify-content:space-between;align-items:center;gap:8px;margin-top:8px;color:#99878b;font-size:10px}
@media(max-width:1150px){.staff-stat-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.staff-dashboard-grid{grid-template-columns:1fr}}
@media(max-width:700px){.staff-bottom-grid{grid-template-columns:1fr}.staff-welcome{align-items:flex-start;flex-direction:column;padding:20px}.staff-welcome h2{font-size:20px}.staff-welcome-date{width:100%;box-sizing:border-box}.staff-stat-grid{gap:10px}.staff-stat-card{gap:9px;padding:13px 10px;min-height:auto}.staff-stat-icon{flex-basis:32px;width:32px;height:32px}.staff-stat-value{font-size:20px}.staff-stat-note{font-size:9px}.staff-dashboard-card{padding:14px}.staff-chart{gap:4px}.staff-chart-bars{gap:2px}.staff-chart-bar{width:30%}.staff-chart-foot{gap:7px}.staff-chart-foot strong{font-size:11px}}
@media(max-width:430px){.staff-stat-grid{grid-template-columns:1fr}.staff-chart-legend{gap:8px}.staff-chart-label{font-size:9px}}
</style>
@endpush

@section('content')
<div class="staff-dashboard">
    <section class="staff-welcome">
        <div>
            <div class="staff-welcome-kicker">VELOURA INVENTORY &amp; SALES</div>
            <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
            <p>Pantau inventaris, penjualan langsung, pesanan Customer, dan pembelian stok dalam satu tempat.</p>
        </div>

    </section>

    <section>
        <div class="staff-section-heading">
            <div><h3>Ringkasan Sistem</h3><p>Total transaksi dan kondisi inventaris, menggunakan perhitungan yang sama dengan Dashboard Admin.</p></div>
        </div>
        <div class="staff-stat-grid">
            <article class="staff-stat-card">
                <div class="staff-stat-icon">◇</div>
                <div><div class="staff-stat-label">Total Produk</div><div class="staff-stat-value">{{ number_format($totalProducts, 0, ',', '.') }}</div><div class="staff-stat-note">Produk terdaftar dalam sistem</div></div>
            </article>
            <article class="staff-stat-card">
                <div class="staff-stat-icon">⚠</div>
                <div><div class="staff-stat-label">Stok Menipis</div><div class="staff-stat-value">{{ number_format($lowStockProducts, 0, ',', '.') }}</div><div class="staff-stat-note">Produk pada atau di bawah stok minimum</div></div>
            </article>
            <article class="staff-stat-card">
                <div class="staff-stat-icon">▣</div>
                <div><div class="staff-stat-label">Pembelian Stok</div><div class="staff-stat-value">{{ number_format($totalPurchases, 0, ',', '.') }}</div><div class="staff-stat-note">Total pembelian yang tidak dibatalkan</div></div>
            </article>
            <article class="staff-stat-card">
                <div class="staff-stat-icon">↗</div>
                <div><div class="staff-stat-label">Total Penjualan</div><div class="staff-stat-value">{{ number_format($totalSales, 0, ',', '.') }}</div><div class="staff-stat-note">Langsung + pesanan Customer lunas</div></div>
            </article>
        </div>
    </section>

    <section class="staff-dashboard-grid">
        <article class="staff-dashboard-card">
            <div class="staff-section-heading">
                <div><h3>Grafik Aktivitas Transaksi</h3><p>Nilai transaksi selama tujuh hari terakhir, dipisahkan berdasarkan jenis.</p></div>
                <a href="{{ route('staff.transactions.index') }}">Riwayat transaksi →</a>
            </div>
            <div class="staff-chart-legend">
                <span><i class="staff-legend-dot" style="background:#713044"></i>Penjualan langsung</span>
                <span><i class="staff-legend-dot" style="background:#b7798b"></i>Pesanan Customer lunas</span>
                <span><i class="staff-legend-dot" style="background:#d9a7a9"></i>Pembelian stok</span>
            </div>
            <div class="staff-chart" role="img" aria-label="Grafik penjualan langsung, pesanan Customer lunas, dan pembelian stok tujuh hari terakhir">
                @foreach($chartDays as $day)
                    <div class="staff-chart-day">
                        <div class="staff-chart-bars">
                            <div class="staff-chart-bar" title="Penjualan langsung {{ $day['date'] }}: Rp {{ number_format($day['sales'],0,',','.') }}" style="height:{{ max(2, ($day['sales'] / $chartMax) * 125) }}px;background:#713044"></div>
                            <div class="staff-chart-bar" title="Pesanan Customer lunas {{ $day['date'] }}: Rp {{ number_format($day['orders'],0,',','.') }}" style="height:{{ max(2, ($day['orders'] / $chartMax) * 125) }}px;background:#b7798b"></div>
                            <div class="staff-chart-bar" title="Pembelian stok {{ $day['date'] }}: Rp {{ number_format($day['purchases'],0,',','.') }}" style="height:{{ max(2, ($day['purchases'] / $chartMax) * 125) }}px;background:#d9a7a9"></div>
                        </div>
                        <div class="staff-chart-label">{{ $day['label'] }}</div>
                        <div class="staff-chart-date">{{ $day['date'] }}</div>
                    </div>
                @endforeach
            </div>
            <div class="staff-chart-foot">
                <div>Penjualan langsung<strong>Rp {{ number_format($totalDirectSalesAmount,0,',','.') }}</strong><span>{{ number_format($totalDirectSalesCount,0,',','.') }} transaksi</span></div>
                <div>Pesanan Customer lunas<strong>Rp {{ number_format($totalOnlineOrdersAmount,0,',','.') }}</strong><span>{{ number_format($totalOnlineOrdersCount,0,',','.') }} pesanan</span></div>
                <div>Pembelian stok<strong>Rp {{ number_format($totalPurchasesAmount,0,',','.') }}</strong><span>{{ number_format($totalPurchases,0,',','.') }} transaksi</span></div>
            </div>
        </article>

        <article class="staff-dashboard-card">
            <div class="staff-section-heading">
                <div><h3>Pesanan Perlu Diproses</h3><p>{{ number_format($pendingOrders,0,',','.') }} pesanan belum selesai · {{ number_format($unpaidOrders,0,',','.') }} belum dibayar</p></div>
                <a href="{{ route('staff.customer-orders.index') }}">Lihat semua →</a>
            </div>
            @forelse($recentOrders as $order)
                <div class="staff-order-row">
                    <div class="staff-order-title">
                        <strong>{{ $order->order_number }}</strong>
                        <span class="staff-status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div style="margin-top:6px;font-size:11px;color:#483238">{{ $order->customer_name ?: 'Customer' }} · Rp {{ number_format((float)$order->total,0,',','.') }}</div>
                    <div class="staff-order-meta">
                        <span>Pembayaran: {{ ucfirst($order->payment_status) }}</span>
                        <a class="staff-link" href="{{ route('staff.customer-orders.show',$order->id) }}">Periksa pesanan →</a>
                    </div>
                </div>
            @empty
                <div class="staff-empty">Tidak ada pesanan yang perlu diproses saat ini.</div>
            @endforelse
        </article>
    </section>

    <section class="staff-dashboard-card">
        <div class="staff-section-heading">
            <div><h3>Transaksi Penjualan Terbaru</h3><p>Penjualan langsung dan pesanan Customer yang sudah dibayar ditampilkan bersama, dengan jenis transaksi yang tetap dibedakan.</p></div>
            <a href="{{ route('staff.transactions.index') }}">Lihat semua transaksi →</a>
        </div>
        <div class="staff-table-wrap">
            <table class="staff-data-table">
                <thead><tr><th>No.</th><th>Nomor Transaksi</th><th>Tanggal</th><th>Pelanggan</th><th>Jenis</th><th>Item</th><th>Total</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($recentSales as $sale)
                    @php
                        $statusClass = strtolower((string)$sale->status);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><div class="staff-product-name">{{ $sale->sale_number }}</div><div class="staff-muted">{{ $sale->payment_method ? strtoupper($sale->payment_method) : 'Metode pembayaran tidak tersedia' }}</div></td>
                        <td>{{ \Illuminate\Support\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                        <td>{{ $sale->customer_name ?: 'Pelanggan umum' }}</td>
                        <td>{{ $sale->source_type === 'online' ? 'Pesanan Customer' : 'Penjualan langsung' }}</td>
                        <td>{{ number_format((int)$sale->items_count,0,',','.') }}</td>
                        <td style="font-weight:700;white-space:nowrap">Rp {{ number_format((float)$sale->total_amount,0,',','.') }}</td>
                        <td><span class="staff-status {{ $statusClass }}">{{ ucfirst($sale->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="staff-empty">Belum ada transaksi penjualan selesai atau pesanan online lunas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="staff-quick-links">
            <a class="staff-quick-link" href="{{ route('staff.sales.index') }}">＋ Catat Penjualan Langsung</a>
            <a class="staff-quick-link" href="{{ route('staff.customer-orders.index') }}">▣ Catat / Proses Pesanan Customer</a>
            <a class="staff-quick-link" href="{{ route('staff.transactions.index') }}">◷ Buka Riwayat Semua Transaksi</a>
        </div>
    </section>

    <section class="staff-bottom-grid">
        <article class="staff-dashboard-card">
            <div class="staff-section-heading"><div><h3>Produk Stok Menipis</h3><p>Prioritas pemeriksaan persediaan.</p></div><a href="{{ route('staff.products.index') }}">Lihat produk →</a></div>
            <div class="staff-table-wrap">
                <table class="staff-data-table">
                    <thead><tr><th>Produk</th><th>Stok</th><th>Minimum</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($lowStockList as $product)
                        <tr>
                            <td><div class="staff-product-name">{{ $product->name }}</div><div class="staff-muted">{{ $product->sku }}</div></td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->minimum_stock }}</td>
                            <td><span class="staff-status {{ (int)$product->stock === 0 ? 'cancelled' : '' }}">{{ (int)$product->stock === 0 ? 'Habis' : 'Menipis' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="staff-empty">Semua produk berada di atas batas stok minimum.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="staff-dashboard-card">
            <div class="staff-section-heading"><div><h3>Pembelian Stok Terbaru</h3><p>Barang masuk dari supplier.</p></div><a href="{{ route('staff.purchases.index') }}">Lihat semua →</a></div>
            <div class="staff-table-wrap">
                <table class="staff-data-table">
                    <thead><tr><th>Nomor</th><th>Supplier</th><th>Tanggal</th><th>Total</th></tr></thead>
                    <tbody>
                    @forelse($recentPurchases as $purchase)
                        <tr>
                            <td><div class="staff-product-name">{{ $purchase->purchase_number }}</div></td>
                            <td>{{ $purchase->supplier->name ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}</td>
                            <td style="font-weight:700;white-space:nowrap">Rp {{ number_format((float)$purchase->total_amount,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="staff-empty">Belum ada transaksi pembelian stok.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:12px;padding:12px;border-radius:8px;background:#fcf8f5;color:#806d72;font-size:11px">Total pembelian tercatat <strong style="display:block;margin-top:4px;color:#57222f;font-size:16px">Rp {{ number_format($totalPurchasesAmount,0,',','.') }}</strong></div>
        </article>
    </section>

    <section class="staff-dashboard-card">
        <div class="staff-section-heading"><div><h3>Akses Cepat</h3><p>Pilih pekerjaan Staff yang ingin dilakukan.</p></div></div>
        <div class="staff-quick-links">
            <a class="staff-quick-link" href="{{ route('staff.sales.index') }}">＋ Catat Penjualan Langsung</a>
            <a class="staff-quick-link" href="{{ route('staff.customer-orders.index') }}">▣ Kelola Pesanan Customer</a>
            <a class="staff-quick-link" href="{{ route('staff.purchases.index') }}">＋ Catat Pembelian Stok</a>
            <a class="staff-quick-link" href="{{ route('staff.products.index') }}">◇ Periksa Produk dan Stok</a>
            <a class="staff-quick-link" href="{{ route('staff.transactions.index') }}">◷ Riwayat Transaksi</a>
        </div>
    </section>
</div>
@endsection
