
@extends('admin.layout')

@section('title', 'Manajemen Supplier')
@section('page-heading', 'Manajemen Supplier')
@section('page-description', 'Kelola informasi pemasok produk Veloura.')

@section('content')
<section class="panel">
    <div class="toolbar">
        <div>
            <h2 class="panel-title">Daftar Supplier</h2>
            <p class="muted">Total supplier: {{ $suppliers->total() }}</p>
        </div>
        <a class="btn btn-primary" href="{{ route('admin.suppliers.create') }}">+ Tambah Supplier</a>
    </div>

    <form method="GET" action="{{ route('admin.suppliers.index') }}" class="toolbar">
        <div class="search">
            <input name="search" value="{{ $search }}" placeholder="Cari nama, kontak, atau telepon...">
            <button class="btn btn-primary" type="submit">Cari</button>
            <a href="{{ route('admin.suppliers.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Telepon</th>
                    <th>Jumlah Pembelian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($suppliers as $supplier)
                <tr>
                    <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                    <td><strong>{{ $supplier->name }}</strong></td>
                    <td>{{ $supplier->contact_person ?: '—' }}</td>
                    <td>{{ $supplier->phone ?: '—' }}</td>
                    <td><span class="count">{{ $supplier->purchases_count }} transaksi</span></td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-light" href="{{ route('admin.suppliers.show', $supplier) }}">Detail</a>
                            <a class="btn btn-primary" href="{{ route('admin.suppliers.edit', $supplier) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;padding:30px">Belum ada supplier.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $suppliers->links() }}</div>
</section>
@endsection
