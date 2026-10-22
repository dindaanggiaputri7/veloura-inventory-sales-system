
@extends('admin.layout')

@section('title', 'Detail Kategori')
@section('page-heading', 'Detail Kategori')
@section('page-description', 'Lihat informasi kategori yang tersimpan.')

@section('content')
<section class="panel">
    <div class="toolbar">
        <h2 class="panel-title">Informasi Kategori</h2>
        <span class="count">{{ $category->products_count }} produk</span>
    </div>

    <div class="detail-grid">
        <div>
            <div class="detail-label">Nama Kategori</div>
            <div class="detail-value"><strong>{{ $category->name }}</strong></div>
        </div>
        <div>
            <div class="detail-label">Jumlah Produk</div>
            <div class="detail-value">{{ $category->products_count }}</div>
        </div>
        <div>
            <div class="detail-label">Dibuat Pada</div>
            <div class="detail-value">{{ $category->created_at?->format('d M Y, H:i') ?? '—' }}</div>
        </div>
        <div>
            <div class="detail-label">Terakhir Diperbarui</div>
            <div class="detail-value">{{ $category->updated_at?->format('d M Y, H:i') ?? '—' }}</div>
        </div>
        <div style="grid-column:1/-1">
            <div class="detail-label">Deskripsi</div>
            <div class="detail-value">{{ $category->description ?: 'Tidak ada deskripsi.' }}</div>
        </div>
    </div>

    <div class="actions" style="margin-top:25px">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Edit Kategori</a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Kembali</a>
    </div>
</section>
@endsection
