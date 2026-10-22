
@extends('admin.layout')

@section('title', 'Manajemen Produk')
@section('page-heading', 'Manajemen Produk')
@section('page-description', 'Kelola katalog, harga, kategori, dan stok Veloura.')

@section('content')
<section class="panel">
    <div class="toolbar">
        <div>
            <h2 class="panel-title">Daftar Produk</h2>
            <p class="muted">Total produk: {{ $products->total() }}</p>
        </div>
        <a class="btn btn-primary" href="{{ route('admin.products.create') }}">+ Tambah Produk</a>
    </div>

    <form method="GET" action="{{ route('admin.products.index') }}" class="toolbar">
        <div class="search">
            <input name="search" value="{{ $search }}" placeholder="Cari nama produk atau SKU...">
            <select name="category_id" style="width:200px;padding:11px;border:1px solid #e4d8d2;border-radius:8px">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string)$categoryId === (string)$category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-primary">Cari</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th><th>SKU</th><th>Nama Produk</th><th>Kategori</th>
                    <th>Harga Jual</th><th>Stok</th><th>Status Stok</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $products->firstItem() + $loop->index }}</td>
                    <td>{{ $product->sku }}</td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category?->name ?? '—' }}</td>
                    <td>Rp {{ number_format((float)$product->selling_price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if ($product->stock <= $product->minimum_stock)
                            <span class="count" style="background:#fbe9e7;color:#a22c36">Menipis</span>
                        @else
                            <span class="count">Aman</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-light" href="{{ route('admin.products.show', $product) }}">Detail</a>
                            <a class="btn btn-primary" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;padding:30px">Produk belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $products->links() }}</div>
</section>
@endsection
