
@extends('admin.layout')

@section('title', 'Kategori')
@section('page-heading', 'Manajemen Kategori')
@section('page-description', 'Kelola dan atur kategori produk Veloura.')

@section('content')
<section class="panel">
    <div class="toolbar">
        <div>
            <h2 class="panel-title">Daftar Kategori</h2>
            <p class="muted">Kategori terdaftar: {{ $categories->total() }}</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    <form action="{{ route('admin.categories.index') }}" method="GET" class="toolbar">
        <div class="search">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau deskripsi...">
            <button class="btn btn-primary" type="submit">Cari</button>
            @if ($search !== '')
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Reset</a>
            @endif
        </div>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->description ?: '—' }}</td>
                        <td><span class="count">{{ $category->products_count }} produk</span></td>
                        <td>
                            <div class="actions">
                                <a class="btn btn-light" href="{{ route('admin.categories.show', $category) }}">Detail</a>
                                <a class="btn btn-primary" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:30px">
                            Belum ada kategori. Klik Tambah Kategori untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $categories->links() }}</div>
</section>
@endsection
