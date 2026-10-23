
@extends('admin.layout')

@section('content')
<style>
    .sales-page {
        color: #39242a;
    }

    .sales-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        margin-bottom: 26px;
    }

    .sales-heading h1 {
        margin: 0 0 7px;
        font-size: 30px;
        line-height: 1.3;
        font-weight: 750;
        letter-spacing: -.5px;
        color: #39242a;
    }

    .sales-heading p {
        margin: 0;
        color: #88777d;
        font-size: 14px;
        line-height: 1.7;
    }

    .sales-btn {
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

    .sales-btn:hover {
        transform: translateY(-1px);
    }

    .sales-btn-primary {
        color: #fff;
        background: #5b2632;
        border-color: #5b2632;
    }

    .sales-btn-primary:hover {
        background: #763746;
    }

    .sales-btn-secondary {
        color: #5b2632;
        background: #fff;
        border-color: #e8d8d3;
    }

    .sales-btn-secondary:hover {
        background: #faf1ed;
    }

    .sales-btn-danger {
        color: #a72c3b;
        background: #fff4f3;
        border-color: #f1d5d5;
    }

    .sales-btn-danger:hover {
        background: #ffe8e7;
    }

    .sales-alert {
        margin-bottom: 20px;
        padding: 14px 17px;
        border: 1px solid transparent;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.7;
    }

    .sales-alert-success {
        color: #246b49;
        background: #edf8f1;
        border-color: #d2ead9;
    }

    .sales-alert-info {
        color: #73551c;
        background: #fff8e7;
        border-color: #f1e2b9;
    }

    .sales-alert-danger {
        color: #a52d3c;
        background: #fff1f0;
        border-color: #f0d0ce;
    }

    .sales-alert ul {
        margin: 8px 0 0;
        padding-left: 21px;
    }

    .sales-card {
        padding: 24px;
        background: #fff;
        border: 1px solid #eee1dc;
        border-radius: 16px;
        box-shadow: 0 5px 18px rgba(65, 35, 43, .035);
    }

    .sales-card-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .sales-card-heading h2 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #4f2530;
    }

    .sales-card-heading p {
        margin: 5px 0 0;
        color: #88777d;
        font-size: 13px;
    }

    .sales-filter {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) 190px auto auto;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
    }

    .sales-filter input {
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

    .sales-filter input:focus {
        outline: none;
        border-color: #7a3443;
        box-shadow: 0 0 0 3px rgba(122, 52, 67, .10);
    }

    .sales-filter .sales-btn {
        width: auto;
        min-width: 76px;
    }

    .sales-table-wrap {
        width: 100%;
        overflow-x: auto;
        border: 1px solid #eee3de;
        border-radius: 12px;
    }

    .sales-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        text-align: left;
    }

    .sales-table thead {
        background: #faf4f0;
    }

    .sales-table th {
        padding: 15px 14px;
        color: #74525b;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        border-bottom: 1px solid #eee3de;
    }

    .sales-table td {
        padding: 15px 14px;
        color: #59474d;
        font-size: 13px;
        vertical-align: middle;
        border-bottom: 1px solid #f1e8e4;
    }

    .sales-table tbody tr:last-child td {
        border-bottom: none;
    }

    .sales-table tbody tr:hover {
        background: #fffbf9;
    }

    .sales-number {
        color: #5b2632;
        font-weight: 700;
    }

    .sales-date {
        color: #88777d;
        white-space: nowrap;
    }

    .sales-amount {
        color: #39242a;
        font-weight: 700;
        white-space: nowrap;
    }

    .sales-method {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        color: #69404b;
        background: #f8efec;
        border: 1px solid #efe0da;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .sales-actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .sales-actions .sales-btn {
        min-height: 34px;
        padding: 0 10px;
        font-size: 12px;
    }

    .sales-empty {
        padding: 48px 20px !important;
        text-align: center;
    }

    .sales-empty-icon {
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

    .sales-empty strong {
        display: block;
        margin-bottom: 7px;
        color: #4f2530;
        font-size: 14px;
    }

    .sales-empty span {
        color: #88777d;
        font-size: 12px;
    }

    .sales-pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .sales-pagination-info {
        color: #88777d;
        font-size: 12px;
    }

    .sales-pagination nav {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .sales-pagination nav a,
    .sales-pagination nav span {
        border-radius: 7px;
    }

    @media (max-width: 1000px) {
        .sales-filter {
            grid-template-columns: minmax(200px, 1fr) 180px;
        }

        .sales-filter .sales-btn {
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        .sales-heading h1 {
            font-size: 25px;
        }

        .sales-heading > a {
            width: 100%;
        }

        .sales-card {
            padding: 16px;
            border-radius: 13px;
        }

        .sales-filter {
            grid-template-columns: 1fr;
        }

        .sales-filter .sales-btn {
            width: 100%;
        }

        .sales-pagination {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<div class="sales-page">

    <div class="sales-heading">
        <div>
            <h1>Data Penjualan</h1>
            <p>Kelola transaksi penjualan dan pantau stok produk.</p>
        </div>

    </div>

    @if(session('success'))
        <div class="sales-alert sales-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="sales-alert sales-alert-info">
            {{ session('info') }}
        </div>
    @endif

    @if($errors->any())
        <div class="sales-alert sales-alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="sales-card">

        <div class="sales-card-heading">
            <div>
                <h2>Riwayat Transaksi</h2>
                <p>Cari transaksi berdasarkan nomor, pelanggan, atau tanggal.</p>
            </div>
        </div>

        <form method="GET"
              action="{{ route('admin.sales.index') }}"
              class="sales-filter">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nomor transaksi atau pelanggan..."
                aria-label="Cari nomor transaksi atau pelanggan"
            >

            <input
                type="date"
                name="date"
                value="{{ request('date') }}"
                aria-label="Filter tanggal penjualan"
            >

            <button type="submit"
                    class="sales-btn sales-btn-primary">
                Cari
            </button>

            <a href="{{ route('admin.sales.index') }}"
               class="sales-btn sales-btn-secondary">
                Reset
            </a>
        </form>

        <div class="sales-table-wrap">
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Jumlah Item</th>
                        <th>Total</th>
                        <th>Metode Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sales->firstItem() + $loop->index }}</td>

                            <td>
                                <span class="sales-number">
                                    {{ $sale->sale_number }}
                                </span>
                            </td>

                            <td>
                                <span class="sales-date">
                                    {{ $sale->sale_date->format('d/m/Y') }}
                                </span>
                            </td>

                            <td>{{ $sale->customer_name ?: 'Pelanggan umum' }}</td>

                            <td>{{ $sale->items_count }} item</td>

                            <td>
                                <span class="sales-amount">
                                    Rp {{ number_format((float) $sale->total_amount, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="sales-method">
                                    {{ strtoupper($sale->payment_method) }}
                                </span>
                            </td>

                            <td>
                                <div class="sales-actions">
                                    <a
                                        href="{{ route('admin.sales.show', $sale) }}"
                                        class="sales-btn sales-btn-secondary">
                                        Detail
                                    </a>

                                    <form
                                        action="{{ route('admin.sales.destroy', $sale) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus transaksi ini dan kembalikan stok produknya?')">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="sales-btn sales-btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="sales-empty">
                                <div class="sales-empty-icon" aria-hidden="true">
                                    ↗
                                </div>
                                <strong>Belum ada transaksi penjualan</strong>
                                <span>
                                    Transaksi yang berhasil disimpan akan muncul di sini.
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->hasPages())
            <div class="sales-pagination">
                <div class="sales-pagination-info">
                    Menampilkan {{ $sales->firstItem() ?? 0 }}
                   –{{ $sales->lastItem() ?? 0 }}
                    dari {{ $sales->total() }} transaksi
                </div>

                {{ $sales->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
