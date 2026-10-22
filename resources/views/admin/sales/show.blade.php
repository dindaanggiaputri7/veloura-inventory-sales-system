
@extends('admin.layout')

@section('content')
<div class="page-header">
    <div>
        <h1>Detail Penjualan</h1>
        <p>Informasi lengkap transaksi penjualan.</p>
    </div>
    <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">
        Kembali ke Daftar
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="panel">
    <h2>Informasi Transaksi</h2>

    <div class="details-grid">
        <div>
            <strong>Nomor Transaksi</strong>
            <p>{{ $sale->sale_number }}</p>
        </div>
        <div>
            <strong>Tanggal Penjualan</strong>
            <p>{{ $sale->sale_date->format('d F Y') }}</p>
        </div>
        <div>
            <strong>Pelanggan</strong>
            <p>{{ $sale->customer_name ?: 'Pelanggan umum' }}</p>
        </div>
        <div>
            <strong>Status</strong>
            <p>{{ ucfirst($sale->status) }}</p>
        </div>
        <div>
            <strong>Metode Pembayaran</strong>
            <p>{{ strtoupper($sale->payment_method) }}</p>
        </div>
        <div>
            <strong>Jumlah Pembayaran</strong>
            <p>Rp {{ number_format((float) $sale->payment_amount, 0, ',', '.') }}</p>
        </div>
    </div>

    <div style="margin-top:16px">
        <strong>Catatan</strong>
        <p>{{ $sale->notes ?: 'Tidak ada catatan.' }}</p>
    </div>
</div>

<div class="panel">
    <h2>Rincian Produk</h2>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Jumlah</th>
                    <th>Harga per Unit</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sale->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product->name ?? 'Produk tidak tersedia' }}</td>
                        <td>{{ $item->product->sku ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Tidak ada item pada transaksi ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="max-width:360px;margin-left:auto">
        <p style="display:flex;justify-content:space-between;gap:12px">
            <span>Diskon</span>
            <strong>Rp {{ number_format((float) $sale->discount, 0, ',', '.') }}</strong>
        </p>
        <hr>
        <p style="display:flex;justify-content:space-between;gap:12px">
            <span>Total Penjualan</span>
            <strong>Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}</strong>
        </p>
    </div>
</div>

<div style="display:flex;gap:10px;flex-wrap:wrap">
    <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">
        Kembali
    </a>

    <form action="{{ route('admin.sales.destroy', $sale) }}"
          method="POST"
          onsubmit="return confirm('Hapus transaksi ini dan kembalikan stok produk?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Transaksi</button>
    </form>
</div>
@endsection
