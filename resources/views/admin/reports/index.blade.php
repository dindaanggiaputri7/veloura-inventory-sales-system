@extends('admin.layout')

@section('title', 'Laporan')
@section('page-heading', 'Laporan')
@section('page-description', 'Ringkasan penjualan, pembelian, dan pesanan Customer Veloura.')

@section('content')
<style>
    .report-hero{padding:22px 24px;margin-bottom:18px;color:#fff;background:linear-gradient(115deg,#57222f,#804653);border-radius:14px}
    .report-hero h2{margin:0 0 6px;font-size:20px}.report-hero p{margin:0;color:#f0dfe2;font-size:12px}
    .report-filter{display:flex;align-items:end;gap:12px;flex-wrap:wrap}
    .report-filter .field{margin:0;min-width:170px;flex:1}
    .report-filter label{display:block;margin-bottom:7px;font-size:12px;font-weight:700}
    .report-filter input{width:100%;padding:10px;border:1px solid #e8d8d2;border-radius:8px;background:white}
    .report-stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-bottom:18px}
    .report-stat{padding:17px;border:1px solid #eee2dd;border-radius:12px;background:#fff}
    .report-stat span{display:block;color:#99868b;font-size:11px;margin-bottom:9px}
    .report-stat strong{display:block;color:#592534;font-size:22px;overflow-wrap:anywhere}
    .report-stat small{display:block;margin-top:6px;color:#a08d92;font-size:10px}
    .report-chart{display:flex;align-items:end;gap:7px;height:190px;padding:14px 0 0;overflow-x:auto;border-bottom:1px solid #eee4e0}
    .report-chart-col{display:flex;flex-direction:column;justify-content:end;align-items:center;min-width:24px;flex:1;height:100%}
    .report-bar-wrap{display:flex;align-items:end;justify-content:center;width:100%;height:145px}
    .report-bar{width:min(24px,75%);min-height:3px;background:linear-gradient(180deg,#b67b89,#632b3b);border-radius:5px 5px 0 0}
    .report-chart-label{padding:8px 0;color:#99868b;font-size:10px;white-space:nowrap}
    .report-note{color:#99868b;font-size:11px;line-height:1.6}
    .report-table{width:100%;border-collapse:collapse;font-size:12px}
    .report-table th{padding:11px 9px;background:#fcf8f5;color:#95848a;text-align:left;white-space:nowrap;font-size:10px}
    .report-table td{padding:12px 9px;border-bottom:1px solid #f1e8e4;vertical-align:top}
    .report-table tr:last-child td{border-bottom:0}
    .report-table-wrap{overflow-x:auto}
    .status-pill{display:inline-block;padding:5px 8px;border-radius:20px;background:#f5e9e6;color:#652a39;font-size:10px}
    @media(max-width:1000px){.report-stats{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:600px){.report-stats{grid-template-columns:1fr}.report-filter .field{min-width:100%}}
</style>

@if(session('success'))
    <div class="panel" style="padding:12px 16px;color:#26764b">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="panel" style="padding:12px 16px;color:#a43a42">{{ session('error') }}</div>
@endif

<section class="report-hero">
    <h2>Laporan Operasional Veloura</h2>
    <p>Gunakan rentang tanggal untuk melihat transaksi yang tidak dibatalkan. Laporan ini tidak mengubah data transaksi.</p>
</section>

<section class="panel">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="report-filter">
        <div class="field">
            <label for="start_date">Dari tanggal</label>
            <input id="start_date" type="date" name="start_date" value="{{ $startDate }}" required>
        </div>
        <div class="field">
            <label for="end_date">Sampai tanggal</label>
            <input id="end_date" type="date" name="end_date" value="{{ $endDate }}" required>
        </div>
        <button class="btn btn-primary" type="submit">Tampilkan Laporan</button>
        <button class="btn btn-light" type="button" onclick="window.print()">Cetak / Simpan PDF</button>
    </form>
</section>


<div class="report-stats">
    <div class="report-stat">
        <span>Total Penjualan (Langsung + Online)</span>
        <strong>Rp {{ number_format($salesAmount, 0, ',', '.') }}</strong>
        <small>{{ $totalSales }} transaksi yang memenuhi syarat</small>
    </div>

    <div class="report-stat">
        <span>Penjualan Langsung</span>
        <strong>Rp {{ number_format($directSalesAmount, 0, ',', '.') }}</strong>
        <small>{{ $totalDirectSales }} transaksi selesai</small>
    </div>

    <div class="report-stat">
        <span>Pembelian / Stock-in</span>
        <strong>Rp {{ number_format($purchasesAmount, 0, ',', '.') }}</strong>
        <small>{{ $totalPurchases }} transaksi tidak dibatalkan</small>
    </div>

    <div class="report-stat">
        <span>Pesanan Customer yang Dibayar</span>
        <strong>Rp {{ number_format($customerOrdersAmount, 0, ',', '.') }}</strong>
        <small>{{ $paidCustomerOrdersCount }} pesanan telah dibayar</small>
    </div>
</div>


<section class="panel">
    <h2 class="panel-title">Grafik Penjualan Langsung</h2>
    @if($days > 31)
        <p class="report-note">
            Grafik menggabungkan penjualan langsung yang selesai dan pesanan
            Customer yang sudah dibayar. Pesanan dibatalkan tidak dihitung.
        </p>
    @endif
    <div class="report-chart">
        @foreach($dailySales as $day)
            <div class="report-chart-col" title="{{ $day['label'] }} — Rp {{ number_format($day['amount'], 0, ',', '.') }}">
                <div class="report-bar-wrap">
                    <div class="report-bar" style="height:{{ $chartMax > 0 ? max(3, ($day['amount'] / $chartMax) * 140) : 3 }}px"></div>
                </div>
                <div class="report-chart-label">{{ $day['label'] }}</div>
            </div>
        @endforeach
    </div>
    <p class="report-note">Grafik memakai data dari tabel sales dan mengecualikan transaksi berstatus cancelled.</p>
</section>

<section class="panel">
    <h2 class="panel-title">Riwayat Penjualan Langsung</h2>
    <div class="report-table-wrap">
        <table class="report-table">
            <thead><tr><th>Nomor</th><th>Tanggal</th><th>Pelanggan</th><th>Metode</th><th>Status</th><th>Total</th><th>Detail</th></tr></thead>
            <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->sale_number }}</td>
                    <td>{{ $sale->sale_date?->format('d/m/Y') }}</td>
                    <td>{{ $sale->customer_name ?: 'Pelanggan umum' }}</td>
                    <td>{{ strtoupper($sale->payment_method) }}</td>
                    <td><span class="status-pill">{{ ucfirst($sale->status) }}</span></td>
                    <td>Rp {{ number_format((float)$sale->total_amount, 0, ',', '.') }}</td>
                    <td><a class="btn btn-light" href="{{ route('admin.sales.show', $sale) }}">Lihat</a></td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center">Tidak ada penjualan pada rentang tanggal ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $sales->links() }}</div>
</section>

<section class="panel">
    <h2 class="panel-title">Riwayat Pembelian / Stock-in</h2>
    <div class="report-table-wrap">
        <table class="report-table">
            <thead><tr><th>Nomor</th><th>Tanggal</th><th>Supplier</th><th>Status</th><th>Total</th><th>Detail</th></tr></thead>
            <tbody>
            @forelse($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->purchase_number }}</td>
                    <td>{{ $purchase->purchase_date?->format('d/m/Y') }}</td>
                    <td>{{ $purchase->supplier?->name ?? '—' }}</td>
                    <td><span class="status-pill">{{ ucfirst($purchase->status) }}</span></td>
                    <td>Rp {{ number_format((float)$purchase->total_amount, 0, ',', '.') }}</td>
                    <td><a class="btn btn-light" href="{{ route('admin.purchases.show', $purchase) }}">Lihat</a></td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center">Tidak ada pembelian pada rentang tanggal ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $purchases->links() }}</div>
</section>

<section class="panel">
    <h2 class="panel-title">Riwayat Pesanan Customer</h2>
    <div class="report-table-wrap">
        <table class="report-table">
            <thead><tr><th>Nomor Pesanan</th><th>Tanggal</th><th>Customer</th><th>Pembayaran</th><th>Status Pesanan</th><th>Total</th></tr></thead>
            <tbody>
            @forelse($customerOrders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td><span class="status-pill">{{ ucfirst($order->payment_status) }}</span></td>
                    <td><span class="status-pill">{{ ucfirst($order->status) }}</span></td>
                    <td>Rp {{ number_format((float)$order->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center">Tidak ada pesanan Customer pada rentang tanggal ini.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $customerOrders->links() }}</div>
</section>

<style>
@media print {
    .sidebar,.topbar,.report-filter button,.btn,.pagination{display:none!important}
    .main{margin:0!important;padding:0!important}
    body{background:#fff}
    .panel,.report-hero{break-inside:avoid;box-shadow:none}
}
</style>
@endsection
