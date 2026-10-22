
@extends('admin.layout')

@section('content')
<div class="page-header">
    <div>
        <h1>Detail Pembelian</h1>
        <p>Informasi lengkap transaksi barang masuk.</p>
    </div>
    <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">
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
            <strong>Nomor Pembelian</strong>
            <p>{{ $purchase->purchase_number }}</p>
        </div>
        <div>
            <strong>Tanggal</strong>
            <p>{{ $purchase->purchase_date->format('d F Y') }}</p>
        </div>
        <div>
            <strong>Supplier</strong>
            <p>{{ $purchase->supplier->name ?? '-' }}</p>
        </div>
        <div>
            <strong>Status</strong>
            <p>{{ ucfirst($purchase->status) }}</p>
        </div>
        <div>
            <strong>Kontak Supplier</strong>
            <p>{{ $purchase->supplier->contact_person ?? '-' }}</p>
        </div>
        <div>
            <strong>Nomor Telepon</strong>
            <p>{{ $purchase->supplier->phone ?? '-' }}</p>
        </div>
    </div>

    <div style="margin-top:16px">
        <strong>Catatan</strong>
        <p>{{ $purchase->notes ?: 'Tidak ada catatan.' }}</p>
    </div>
</div>

<div class="panel">
    <h2>Rincian Produk</h2>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>SKU</th>
                    <th>Jumlah</th>
                    <th>Harga per Unit</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchase->items as $item)
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
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align:right">Total Pembelian</th>
                    <th>
                        Rp {{ number_format((float) $purchase->total_amount, 0, ',', '.') }}
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div style="display:flex;gap:10px;flex-wrap:wrap">
    <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">
        Kembali
    </a>

    <form action="{{ route('admin.purchases.destroy', $purchase) }}"
          method="POST"
          onsubmit="return confirm('Yakin ingin menghapus transaksi ini dan mengurangi stok sesuai jumlah pembelian?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Pembelian</button>
    </form>
</div>
@endsection
