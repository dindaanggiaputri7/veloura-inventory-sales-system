
@extends('admin.layout')

@section('title', 'Detail Supplier')
@section('page-heading', 'Detail Supplier')
@section('page-description', 'Informasi pemasok yang terdaftar.')

@section('content')
<section class="panel">
    <div class="toolbar">
        <h2 class="panel-title">{{ $supplier->name }}</h2>
        <span class="count">{{ $supplier->purchases_count }} transaksi pembelian</span>
    </div>

    <div class="detail-grid">
        <div>
            <div class="detail-label">Nama Supplier</div>
            <div class="detail-value">{{ $supplier->name }}</div>
        </div>
        <div>
            <div class="detail-label">Nama Kontak</div>
            <div class="detail-value">{{ $supplier->contact_person ?: '—' }}</div>
        </div>
        <div>
            <div class="detail-label">Nomor Telepon</div>
            <div class="detail-value">{{ $supplier->phone ?: '—' }}</div>
        </div>
        <div>
            <div class="detail-label">Tanggal Terdaftar</div>
            <div class="detail-value">{{ $supplier->created_at?->format('d M Y') ?? '—' }}</div>
        </div>
        <div style="grid-column:1/-1">
            <div class="detail-label">Alamat</div>
            <div class="detail-value">{{ $supplier->address ?: 'Alamat belum diisi.' }}</div>
        </div>
    </div>

    <div class="actions" style="margin-top:25px">
        <a class="btn btn-primary" href="{{ route('admin.suppliers.edit', $supplier) }}">Edit Supplier</a>
        <a class="btn btn-light" href="{{ route('admin.suppliers.index') }}">Kembali</a>
    </div>
</section>
@endsection
