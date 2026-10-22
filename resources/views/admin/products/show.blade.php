
@extends('admin.layout')

@section('title', 'Detail Produk')
@section('page-heading', 'Detail Produk')
@section('page-description', 'Informasi lengkap produk di inventaris Veloura.')

@section('content')
<section class="panel">
    <div class="toolbar">
        <h2 class="panel-title">{{ $product->name }}</h2>
        <span class="count">{{ $product->stock <= $product->minimum_stock ? 'Stok Menipis' : 'Stok Aman' }}</span>
    </div>

    <div class="detail-grid">
        <div><div class="detail-label">SKU</div><div class="detail-value">{{ $product->sku }}</div></div>
        <div><div class="detail-label">Kategori</div><div class="detail-value">{{ $product->category?->name ?? '—' }}</div></div>
        <div><div class="detail-label">Harga Beli</div><div class="detail-value">Rp {{ number_format((float)$product->purchase_price, 0, ',', '.') }}</div></div>
        <div><div class="detail-label">Harga Jual</div><div class="detail-value">Rp {{ number_format((float)$product->selling_price, 0, ',', '.') }}</div></div>
        <div><div class="detail-label">Stok Saat Ini</div><div class="detail-value">{{ $product->stock }}</div></div>
        <div><div class="detail-label">Stok Minimum</div><div class="detail-value">{{ $product->minimum_stock }}</div></div>
        <div style="grid-column:1/-1">
            <div class="detail-label">Deskripsi</div>
            <div class="detail-value">{{ $product->description ?: 'Tidak ada deskripsi.' }}</div>
        </div>
    </div>

    <div class="actions" style="margin-top:25px">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">Edit Produk</a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-light">Kembali</a>
    </div>
</section>
@endsection
