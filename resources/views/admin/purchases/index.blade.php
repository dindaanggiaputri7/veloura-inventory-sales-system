
@extends('admin.layout')

@section('content')
<style>
    .purchase-page {
        color: #39242a;
    }

    .purchase-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        margin-bottom: 26px;
    }

    .purchase-heading h1 {
        margin: 0 0 7px;
        font-size: 30px;
        line-height: 1.3;
        font-weight: 750;
        letter-spacing: -.5px;
        color: #39242a;
    }

    .purchase-heading p {
        margin: 0;
        color: #88777d;
        font-size: 14px;
        line-height: 1.7;
    }

    .purchase-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 43px;
        padding: 0 17px;
        border: 1px solid transparent;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background .2s, border-color .2s, transform .2s;
    }

    .purchase-btn:hover {
        transform: translateY(-1px);
    }

    .purchase-btn-primary {
        color: #fff;
        background: #5b2632;
        border-color: #5b2632;
    }

    .purchase-btn-primary:hover {
        background: #763746;
    }

    .purchase-btn-secondary {
        color: #5b2632;
        background: #fff;
        border-color: #e8d8d3;
    }

    .purchase-btn-secondary:hover {
        background: #faf1ed;
    }

    .purchase-btn-danger {
        color: #a72c3b;
        background: #fff4f3;
        border-color: #f1d5d5;
    }

    .purchase-btn-danger:hover {
        background: #ffe8e7;
    }

    .purchase-alert {
        margin-bottom: 20px;
        padding: 14px 17px;
        border: 1px solid transparent;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.7;
    }

    .purchase-alert-success {
        color: #246b49;
        background: #edf8f1;
        border-color: #d2ead9;
    }

    .purchase-alert-danger {
        color: #a52d3c;
        background: #fff1f0;
        border-color: #f0d0ce;
    }

    .purchase-card {
        padding: 24px;
        background: #fff;
        border: 1px solid #eee1dc;
        border-radius: 16px;
        box-shadow: 0 5px 18px rgba(65, 35, 43, .035);
    }

    .purchase-card-heading {
        margin-bottom: 20px;
    }

    .purchase-card-heading h2 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #4f2530;
    }

    .purchase-card-heading p {
        margin: 5px 0 0;
        color: #88777d;
        font-size: 13px;
        line-height: 1.6;
    }

    .purchase-filter {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) auto auto;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }

    .purchase-filter input {
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        height: 44px;
        padding: 0 13px;
        color: #39242a;
        background: #fffdfb;
        border: 1px solid #e6d8d3;
        border-radius: 10px;
        font-family: inherit;
        font-size: 13px;
        transition: border-color .2s, box-shadow .2s;
    }

    .purchase-filter input:focus {
        outline: none;
        border-color: #7a3443;
        box-shadow: 0 0 0 3px rgba(122, 52, 67, .10);
    }

    .purchase-table-wrap {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #eee3de;
        border-radius: 12px;
    }

    .purchase-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        text-align: left;
    }

    .purchase-table thead {
        background: #faf4f0;
    }

    .purchase-table th {
        padding: 15px 14px;
        color: #74525b;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        border-bottom: 1px solid #eee3de;
    }

    .purchase-table td {
        padding: 15px 14px;
        color: #59474d;
        font-size: 13px;
        vertical-align: middle;
        border-bottom: 1px solid #f1e8e4;
    }

    .purchase-table tbody tr:last-child td {
        border-bottom: none;
    }

    .purchase-table tbody tr:hover {
        background: #fffbf9;
    }

    .purchase-number {
        color: #5b2632;
        font-weight: 700;
    }

    .purchase-date {
        color: #88777d;
        white-space: nowrap;
    }

    .purchase-amount {
        color: #39242a;
        font-weight: 700;
        white-space: nowrap;
    }

    .purchase-status {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        color: #246b49;
        background: #edf8f1;
        border: 1px solid #d2ead9;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .purchase-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .purchase-actions .purchase-btn {
        min-height: 34px;
        padding: 0 10px;
        font-size: 12px;
    }

    .purchase-empty {
        padding: 48px 20px !important;
        text-align: center;
    }

    .purchase-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 54px;
        height: 54px;
        margin: 0 auto 14px;
        color: #7a3443;
        background: #f8efec;
        border-radius: 16px;
        font-size: 25px;
    }

    .purchase-empty strong {
        display: block;
        margin-bottom: 7px;
        color: #4f2530;
        font-size: 14px;
    }

    .purchase-empty span {
        color: #88777d;
        font-size: 12px;
    }

    .purchase-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .purchase-pagination-info {
        color: #88777d;
        font-size: 12px;
    }

    @media (max-width: 850px) {
        .purchase-filter {
            grid-template-columns: minmax(180px, 1fr) auto auto;
        }
    }

    @media (max-width: 600px) {
        .purchase-heading h1 {
            font-size: 25px;
        }

        .purchase-heading > a {
            width: 100%;
        }

        .purchase-card {
            padding: 16px;
            border-radius: 13px;
        }

        .purchase-filter {
            grid-template-columns: 1fr;
        }

        .purchase-filter .purchase-btn {
            width: 100%;
        }

        .purchase-pagination {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="purchase-page">

    <div class="purchase-heading">
        <div>
            <h1>Data Pembelian</h1>
            <p>Kelola pembelian barang dan penambahan stok produk.</p>
        </div>

        <a href="{{ route('admin.purchases.create') }}"
           class="purchase-btn purchase-btn-primary">
            <span aria-hidden="true">+</span>
            Tambah Pembelian
        </a>
    </div>

    @if(session('success'))
        <div class="purchase-alert purchase-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="purchase-alert purchase-alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="purchase-card">

        <div class="purchase-card-heading">
            <h2>Riwayat Pembelian</h2>
            <p>Cari transaksi berdasarkan nomor pembelian atau nama supplier.</p>
        </div>

        <form method="GET"
              action="{{ route('admin.purchases.index') }}"
              class="purchase-filter">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nomor pembelian atau supplier..."
                aria-label="Cari nomor pembelian atau supplier"
            >

            <button type="submit"
                    class="purchase-btn purchase-btn-primary">
                Cari
            </button>

            <a href="{{ route('admin.purchases.index') }}"
               class="purchase-btn purchase-btn-secondary">
                Reset
            </a>
        </form>

        <div class="purchase-table-wrap">
            <table class="purchase-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Pembelian</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Jumlah Item</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($purchases as $purchase)
                        <tr>
                            <td>{{ $purchases->firstItem() + $loop->index }}</td>

                            <td>
                                <span class="purchase-number">
                                    {{ $purchase->purchase_number }}
                                </span>
                            </td>

                            <td>
                                <span class="purchase-date">
                                    {{ $purchase->purchase_date->format('d/m/Y') }}
                                </span>
                            </td>

                            <td>
                                {{ $purchase->supplier->name ?? 'Supplier tidak tersedia' }}
                            </td>

                            <td>{{ $purchase->items_count }} item</td>

                            <td>
                                <span class="purchase-amount">
                                    Rp {{ number_format((float) $purchase->total_amount, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="purchase-status">
                                    {{ ucfirst($purchase->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="purchase-actions">
                                    <a
                                        href="{{ route('admin.purchases.show', $purchase) }}"
                                        class="purchase-btn purchase-btn-secondary">
                                        Detail
                                    </a>

                                    <form
                                        action="{{ route('admin.purchases.destroy', $purchase) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus transaksi pembelian ini? Pastikan stok produk disesuaikan dengan benar.')">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="purchase-btn purchase-btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="purchase-empty">
                                <div class="purchase-empty-icon" aria-hidden="true">
                                    ↓
                                </div>
                                <strong>Belum ada data pembelian</strong>
                                <span>
                                    Transaksi pembelian yang berhasil disimpan akan muncul di sini.
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($purchases->hasPages())
            <div class="purchase-pagination">
                <div class="purchase-pagination-info">
                    Menampilkan {{ $purchases->firstItem() ?? 0 }}
                    –{{ $purchases->lastItem() ?? 0 }}
                    dari {{ $purchases->total() }} transaksi
                </div>

                {{ $purchases->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
