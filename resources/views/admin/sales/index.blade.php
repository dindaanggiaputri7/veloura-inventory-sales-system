
@extends('admin.layout')

@section('title', 'Penjualan')
@section('page-heading', 'Data Penjualan')
@section('page-description', 'Pantau penjualan langsung dan pesanan Customer dalam satu daftar.')

@section('content')
<style>
    .sales-wrap { color:#39242a; }
    .sales-panel {
        padding:22px;
        margin-bottom:20px;
        background:#fff;
        border:1px solid #eee1dc;
        border-radius:14px;
        box-shadow:0 5px 18px rgba(65,35,43,.035);
    }
    .sales-filter {
        display:grid;
        grid-template-columns:minmax(220px,1fr) 180px auto auto;
        gap:10px;
        margin-bottom:18px;
    }
    .sales-filter input {
        width:100%;
        padding:11px;
        border:1px solid #e6d8d3;
        border-radius:8px;
        background:#fffdfb;
    }
    .sales-btn {
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        padding:10px 13px;
        border:1px solid #e8d8d3;
        border-radius:8px;
        color:#5b2632;
        background:#fff;
        font-size:12px;
        font-weight:700;
        text-decoration:none;
        cursor:pointer;
        white-space:nowrap;
    }
    .sales-btn-primary { background:#5b2632;color:#fff;border-color:#5b2632; }
    .sales-btn-danger { background:#fff1f0;color:#a52d3c;border-color:#f0d0ce; }
    .sales-table-wrap { overflow-x:auto; }
    .sales-table { width:100%;min-width:950px;border-collapse:collapse;font-size:12px; }
    .sales-table th {
        padding:13px 10px;
        color:#74525b;
        background:#faf4f0;
        text-align:left;
        white-space:nowrap;
    }
    .sales-table td { padding:13px 10px;border-bottom:1px solid #f1e8e4;vertical-align:middle; }
    .sales-number { color:#5b2632;font-weight:750; }
    .sales-muted { margin-top:4px;color:#95848a;font-size:11px; }
    .sales-pill {
        display:inline-block;
        padding:5px 8px;
        border-radius:20px;
        color:#652a39;
        background:#f5e9e6;
        font-size:10px;
        white-space:nowrap;
    }
    .sales-pill-success { color:#286638;background:#e8f3e8; }
    .sales-pill-danger { color:#922f35;background:#fbe9e7; }
    .sales-actions { display:flex;flex-wrap:wrap;gap:6px; }
    .sales-alert { padding:12px 15px;margin-bottom:16px;border-radius:9px; }
    .sales-success { color:#286638;background:#e8f3e8; }
    .sales-error { color:#922f35;background:#fbe9e7; }
    .sales-empty { padding:28px;text-align:center;color:#95848a; }
    @media(max-width:760px) {
        .sales-filter { grid-template-columns:1fr; }
        .sales-panel { padding:15px; }
    }
</style>

<div class="sales-wrap">
    @if(session('success'))
        <div class="sales-alert sales-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="sales-alert sales-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="sales-alert sales-error">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="sales-panel">
        <p class="sales-muted" style="margin:0 0 17px">
            Penjualan langsung dan pesanan online ditampilkan bersama.
            Pesanan yang belum dibayar tetap terlihat, tetapi tidak masuk
            perhitungan penjualan yang sudah dibayar.
        </p>

        <form method="GET"
              action="{{ route('admin.sales.index') }}"
              class="sales-filter">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nomor transaksi atau pelanggan..."
                aria-label="Cari transaksi"
            >

            <input
                type="date"
                name="date"
                value="{{ request('date') }}"
                aria-label="Filter tanggal"
            >

            <button class="sales-btn sales-btn-primary" type="submit">
                Cari
            </button>

            <a href="{{ route('admin.sales.index') }}" class="sales-btn">
                Reset
            </a>
        </form>

        <div class="sales-table-wrap">
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        @php
                            $isOnline = $transaction->source_type === 'online';

                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'processing' => 'Diproses',
                                'completed' => 'Selesai',
                                'delivered' => 'Dikirim/Diterima',
                                'cancelled' => 'Dibatalkan',
                            ];

                            $paymentLabels = [
                                'paid' => 'Sudah dibayar',
                                'unpaid' => 'Belum dibayar',
                                'cash' => 'Tunai',
                                'transfer' => 'Transfer',
                                'qris' => 'QRIS',
                                'debit' => 'Debit',
                                'transfer_manual' => 'Transfer manual',
                            ];

                            $statusLabel = $statusLabels[$transaction->status]
                                ?? ucfirst($transaction->status);

                            $paymentValue = $isOnline
                                ? $transaction->payment_status
                                : $transaction->payment_method;

                            $paymentLabel = $paymentLabels[$paymentValue]
                                ?? strtoupper((string) $paymentValue);

                            $statusClass = $transaction->status === 'cancelled'
                                ? 'sales-pill-danger'
                                : (
                                    ($isOnline && $transaction->payment_status === 'paid')
                                    || (!$isOnline && $transaction->status === 'completed')
                                        ? 'sales-pill-success'
                                        : ''
                                );
                        @endphp

                        <tr>
                            <td>{{ $transactions->firstItem() + $loop->index }}</td>

                            <td>
                                <span class="sales-pill">
                                    {{ $isOnline ? 'Online' : 'Langsung' }}
                                </span>
                            </td>

                            <td>
                                <div class="sales-number">
                                    {{ $transaction->transaction_number }}
                                </div>
                            </td>

                            <td>
                                {{ \Illuminate\Support\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}
                            </td>

                            <td>{{ $transaction->customer_name ?: 'Pelanggan umum' }}</td>

                            <td>{{ $transaction->items_count }} item</td>

                            <td style="font-weight:750;white-space:nowrap">
                                Rp {{ number_format((float)$transaction->amount, 0, ',', '.') }}
                            </td>

                            <td>{{ $paymentLabel }}</td>

                            <td>
                                <span class="sales-pill {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td>
                                <div class="sales-actions">
                                    @if(!$isOnline)
                                        <a
                                            href="{{ route('admin.sales.show', $transaction->source_id) }}"
                                            class="sales-btn">
                                            Detail
                                        </a>

                                        @if($transaction->status === 'completed')
                                            <form
                                                action="{{ route('admin.sales.destroy', $transaction->source_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Batalkan penjualan ini dan kembalikan stok?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="sales-btn sales-btn-danger">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="sales-muted">
                                            Diproses melalui Pesanan Customer
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="sales-empty">
                                Belum ada transaksi penjualan atau pesanan Customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:18px">
            {{ $transactions->links() }}
        </div>
    </section>
</div>
@endsection
