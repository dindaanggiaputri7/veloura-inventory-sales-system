
@extends('staff.layout')

@section('title', 'Dashboard Staff')
@section('page-heading', 'Dashboard Staff')
@section('page-description', 'Ringkasan operasional dan aktivitas Veloura.')

@push('styles')
<style>
.staff-dashboard{display:flex;flex-direction:column;gap:20px}
.staff-welcome{padding:25px 27px;border-radius:15px;background:linear-gradient(115deg,#57222f,#804653);color:#fff;box-shadow:0 10px 25px rgba(87,34,47,.10)}
.staff-welcome-kicker{font-size:10px;font-weight:800;letter-spacing:1.6px;text-transform:uppercase;color:#f0d9dd}
.staff-welcome h2{margin:10px 0 7px;font-size:23px;line-height:1.3}
.staff-welcome p{margin:0;color:#f6e9eb;font-size:12px;line-height:1.6}
.staff-section-heading{display:flex;justify-content:space-between;align-items:flex-end;gap:12px;margin-bottom:12px}
.staff-section-heading h3{margin:0;font-size:16px;color:#38252b}
.staff-section-heading p{margin:5px 0 0;color:#99878b;font-size:11px}
.staff-section-heading a,.staff-dashboard-link{color:#722d40;font-weight:700;font-size:11px;text-decoration:none}
.staff-stat-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
.staff-stat-card{display:flex;align-items:flex-start;gap:12px;min-height:108px;padding:18px 16px;background:#fff;border:1px solid #eadbd6;border-radius:12px;box-shadow:0 3px 12px rgba(66,35,42,.025)}
.staff-stat-icon{display:grid;place-items:center;flex:0 0 39px;height:39px;border-radius:10px;background:#f6e8e8;color:#702d40;font-size:19px}
.staff-stat-label{margin:2px 0 7px;color:#99878b;font-size:11px}
.staff-stat-value{font-size:25px;font-weight:800;line-height:1.1;color:#57222f}
.staff-stat-note{margin-top:7px;color:#a08e92;font-size:10px;line-height:1.4}
.staff-dashboard-grid{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(280px,1fr);gap:16px}
.staff-dashboard-card{min-width:0;padding:20px;background:#fff;border:1px solid #eadbd6;border-radius:12px}
.staff-chart-legend{display:flex;gap:14px;flex-wrap:wrap;margin:16px 0 10px;color:#88777b;font-size:11px}
.staff-legend-dot{display:inline-block;width:8px;height:8px;margin-right:6px;border-radius:50%}
.staff-chart{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:12px;align-items:end;height:170px;padding-top:10px}
.staff-chart-day{display:flex;flex-direction:column;justify-content:flex-end;align-items:center;height:100%;min-width:0}
.staff-chart-bars{display:flex;align-items:flex-end;justify-content:center;gap:3px;width:100%;height:140px;border-bottom:1px solid #f0e5e2}
.staff-chart-bar{width:min(18px,30%);min-height:2px;border-radius:5px 5px 0 0;transition:height .2s}
.staff-chart-label{margin-top:8px;color:#99878b;font-size:10px}
.staff-chart-foot{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:15px;padding-top:13px;border-top:1px solid #f2e9e6;color:#99878b;font-size:11px}
.staff-chart-foot strong{display:block;margin-top:5px;color:#57222f;font-size:15px}
.staff-chart-foot span{display:block;margin-top:3px}
.staff-order{padding:12px 0;border-bottom:1px solid #f2e9e6}
.staff-order:last-child{border-bottom:0}
.staff-order-top,.staff-order-bottom{display:flex;justify-content:space-between;gap:10px;align-items:center}
.staff-order-number{font-size:11px;overflow-wrap:anywhere}
.staff-pill{display:inline-block;padding:4px 7px;border-radius:20px;background:#f7eeee;color:#762f43;font-size:10px;white-space:nowrap}
.staff-order-info{margin-top:6px;font-size:11px;color:#514149}
.staff-order-bottom{margin-top:8px}
.staff-order-payment{font-size:10px;color:#99878b}
.staff-data-table{width:100%;border-collapse:collapse;font-size:11px}
.staff-data-table th{padding:11px 9px;text-align:left;color:#806d72;background:#fcf8f5;font-weight:700;white-space:nowrap}
.staff-data-table td{padding:11px 9px;border-bottom:1px solid #f2e9e6;vertical-align:top}
.staff-data-table tbody tr:last-child td{border-bottom:0}
.staff-empty{padding:23px 10px;text-align:center;color:#99878b;font-size:11px}
.staff-table-wrap{overflow-x:auto}
.staff-bottom-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}
.staff-quick-links{display:flex;flex-wrap:wrap;gap:8px;margin-top:14px}
.staff-quick-link{padding:9px 11px;border:1px solid #eadbd6;border-radius:8px;color:#57222f;text-decoration:none;font-size:11px;font-weight:700}
.staff-quick-link:hover{background:#fcf5f5}
@media(max-width:1100px){.staff-stat-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.staff-dashboard-grid{grid-template-columns:1fr}}
@media(max-width:650px){.staff-stat-grid,.staff-bottom-grid{grid-template-columns:1fr}.staff-stat-card{min-height:auto}.staff-welcome{padding:21px}.staff-welcome h2{font-size:20px}.staff-chart{gap:5px}.staff-chart-bars{gap:2px}.staff-chart-bar{width:28%}.staff-dashboard-card{padding:15px}}
</style>
@endpush

@section('content')
<div class="staff-dashboard">

    <section class="staff-welcome">
        <div class="staff-welcome-kicker">Veloura Inventory &amp; Sales</div>
        <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
        <p>Pantau stok, penjualan langsung, pesanan Customer, dan pembelian stok dalam satu tempat.</p>
    </section>

    <section>
        <div class="staff-section-heading">
            <div>
                <h3>Ringkasan Operasional</h3>
                <p>Informasi utama aktivitas Staff.</p>
            </div>
        </div>

        <div class="staff-stat-grid">
            <article class="staff-stat-card">
                <div class="staff-stat-icon">◇</div>
                <div>
                    <div class="staff-stat-label">Total Produk</div>
                    <div class="staff-stat-value">{{ number_format($totalProducts) }}</div>
                    <div class="staff-stat-note">Produk terdaftar</div>
                </div>
            </article>

            <article class="staff-stat-card">
                <div class="staff-stat-icon">⚠</div>
                <div>
                    <div class="staff-stat-label">Stok Menipis</div>
                    <div class="staff-stat-value">{{ number_format($lowStockProducts) }}</div>
                    <div class="staff-stat-note">Produk pada atau di bawah stok minimum</div>
                </div>
            </article>

            <article class="staff-stat-card">
                <div class="staff-stat-icon">▣</div>
                <div>
                    <div class="staff-stat-label">Pesanan Perlu Diproses</div>
                    <div class="staff-stat-value">{{ number_format($pendingOrders) }}</div>
                    <div class="staff-stat-note">{{ number_format($unpaidOrders) }} pesanan belum dibayar</div>
                </div>
            </article>

            <article class="staff-stat-card">
                <div class="staff-stat-icon">↗</div>
                <div>
                    <div class="staff-stat-label">Penjualan Langsung Hari Ini</div>
                    <div class="staff-stat-value">{{ number_format($todaySalesCount) }}</div>
                    <div class="staff-stat-note">Rp {{ number_format($todaySalesAmount,0,',','.') }}</div>
                </div>
            </article>
        </div>
    </section>

    <section class="staff-dashboard-grid">
        <div class="staff-dashboard-card">
            <div class="staff-section-heading">
                <div>
                    <h3>Grafik Transaksi</h3>
                    <p>Perbandingan tiga jenis transaksi selama tujuh hari terakhir.</p>
                </div>
                <a href="{{ route('staff.transactions.index') }}">Riwayat transaksi →</a>
            </div>

            <div class="staff-chart-legend">
                <span><i class="staff-legend-dot" style="background:#713044"></i>Penjualan langsung</span>
                <span><i class="staff-legend-dot" style="background:#d9a7a9"></i>Pesanan Customer</span>
                <span><i class="staff-legend-dot" style="background:#c7a66b"></i>Pembelian stok</span>
            </div>

            <div class="staff-chart" role="img" aria-label="Grafik penjualan langsung, pesanan customer, dan pembelian stok selama tujuh hari">
                @foreach($chartDays as $day)
                    <div class="staff-chart-day">
                        <div class="staff-chart-bars">
                            <div
                                class="staff-chart-bar"
                                title="Penjualan langsung: Rp {{ number_format($day['sales'],0,',','.') }}"
                                style="height:{{ max(2,($day['sales']/$chartMax)*130) }}px;background:#713044">
                            </div>
                            <div
                                class="staff-chart-bar"
                                title="Pesanan Customer: Rp {{ number_format($day['orders'],0,',','.') }}"
                                style="height:{{ max(2,($day['orders']/$chartMax)*130) }}px;background:#d9a7a9">
                            </div>
                            <div
                                class="staff-chart-bar"
                                title="Pembelian stok: Rp {{ number_format($day['purchases'],0,',','.') }}"
                                style="height:{{ max(2,($day['purchases']/$chartMax)*130) }}px;background:#c7a66b">
                            </div>
                        </div>
                        <div class="staff-chart-label">{{ $day['label'] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="staff-chart-foot">
                <div>
                    Total penjualan langsung
                    <strong>Rp {{ number_format($totalSalesAmount,0,',','.') }}</strong>
                    <span>{{ number_format($totalSales) }} transaksi</span>
                </div>
                <div>
                    Total pesanan online dibayar
                    <strong>Rp {{ number_format($totalOnlineOrdersAmount,0,',','.') }}</strong>
                    <span>Pesanan online, bukan penjualan langsung</span>
                </div>
                <div>
                    Total pembelian stok
                    <strong>Rp {{ number_format($totalPurchasesAmount,0,',','.') }}</strong>
                    <span>{{ number_format($totalPurchases) }} transaksi</span>
                </div>
            </div>
        </div>

        <div class="staff-dashboard-card">
            <div class="staff-section-heading">
                <div>
                    <h3>Pesanan Perlu Diproses</h3>
                    <p>Pesanan online yang masih membutuhkan tindakan Staff.</p>
                </div>
                <a href="{{ route('staff.customer-orders.index') }}">Lihat semua →</a>
            </div>

            @forelse($recentOrders as $order)
                <div class="staff-order">
                    <div class="staff-order-top">
                        <strong class="staff-order-number">{{ $order->order_number }}</strong>
                        <span class="staff-pill">{{ ucfirst($order->status) }}</span>
                    </div>

                    <div class="staff-order-info">
                        {{ $order->customer_name ?: 'Customer' }}
                        · Rp {{ number_format((float)$order->total,0,',','.') }}
                    </div>

                    <div class="staff-order-bottom">
                        <span class="staff-order-payment">
                            Pembayaran: {{ ucfirst($order->payment_status) }}
                        </span>
                        <a class="staff-dashboard-link"
                           href="{{ route('staff.customer-orders.show',$order->id) }}">
                            Periksa →
                        </a>
                    </div>
                </div>
            @empty
                <div class="staff-empty">Tidak ada pesanan yang perlu diproses.</div>
            @endforelse
        </div>
    </section>

    <section class="staff-bottom-grid">
        <div class="staff-dashboard-card">
            <div class="staff-section-heading">
                <div>
                    <h3>Produk Stok Menipis</h3>
                    <p>Prioritas pemeriksaan persediaan.</p>
                </div>
                <a href="{{ route('staff.products.index') }}">Lihat produk →</a>
            </div>

            <div class="staff-table-wrap">
                <table class="staff-data-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Stok</th>
                            <th>Minimum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockList as $product)
                            <tr>
                                <td>
                                    {{ $product->name }}
                                    <div style="margin-top:4px;color:#99878b">
                                        {{ $product->sku }}
                                    </div>
                                </td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->minimum_stock }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="staff-empty">
                                    Semua produk berada di atas batas stok minimum.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="staff-dashboard-card">
            <div class="staff-section-heading">
                <div>
                    <h3>Pembelian Terbaru</h3>
                    <p>Stok masuk dari supplier.</p>
                </div>
                <a href="{{ route('staff.purchases.index') }}">Lihat semua →</a>
            </div>

            <div class="staff-table-wrap">
                <table class="staff-data-table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Supplier</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPurchases as $purchase)
                            <tr>
                                <td>
                                    {{ $purchase->purchase_number }}
                                    <div style="margin-top:4px;color:#99878b">
                                        {{ \Illuminate\Support\Carbon::parse($purchase->purchase_date)->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td>{{ $purchase->supplier->name ?? '-' }}</td>
                                <td>Rp {{ number_format((float)$purchase->total_amount,0,',','.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="staff-empty">
                                    Belum ada transaksi pembelian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="staff-dashboard-card">
        <div class="staff-section-heading">
            <div>
                <h3>Akses Cepat</h3>
                <p>Pintasan untuk pekerjaan operasional.</p>
            </div>
        </div>

        <div class="staff-quick-links">
            <a class="staff-quick-link" href="{{ route('staff.sales.index') }}">＋ Catat Penjualan Langsung</a>
            <a class="staff-quick-link" href="{{ route('staff.purchases.index') }}">＋ Catat Pembelian</a>
            <a class="staff-quick-link" href="{{ route('staff.customer-orders.index') }}">▣ Proses Pesanan Customer</a>
            <a class="staff-quick-link" href="{{ route('staff.transactions.index') }}">◷ Buka Riwayat Transaksi</a>
        </div>
    </section>

</div>
@endsection
