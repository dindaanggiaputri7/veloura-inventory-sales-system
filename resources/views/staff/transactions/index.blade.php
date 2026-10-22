
@extends('staff.layout')

@section('title', 'Riwayat Transaksi')
@section('page-heading', 'Riwayat Transaksi')
@section('page-description', 'Daftar transaksi penjualan yang tercatat.')

@section('content')
<div style="background:white;padding:22px;border:1px solid #eadbd6;border-radius:12px">
    <h3 style="margin-top:0">Riwayat Penjualan</h3>

    <div style="overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:12px">
            <thead>
                <tr style="background:#fcf8f5;text-align:left">
                    <th style="padding:12px">No.</th>
                    <th style="padding:12px">Nomor Transaksi</th>
                    <th style="padding:12px">Tanggal</th>
                    <th style="padding:12px">Pelanggan</th>
                    <th style="padding:12px">Total</th>
                    <th style="padding:12px">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr style="border-bottom:1px solid #f1e8e4">
                        <td style="padding:12px">{{ $sales->firstItem() + $loop->index }}</td>
                        <td style="padding:12px;font-weight:600">{{ $sale->sale_number }}</td>
                        <td style="padding:12px">{{ \Illuminate\Support\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                        <td style="padding:12px">{{ $sale->customer_name ?: 'Pelanggan umum' }}</td>
                        <td style="padding:12px;white-space:nowrap">
                            Rp {{ number_format((float)$sale->total_amount, 0, ',', '.') }}
                        </td>
                        <td style="padding:12px">{{ ucfirst($sale->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:20px;text-align:center">
                            Belum ada transaksi penjualan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px">
        {{ $sales->links() }}
    </div>
</div>
@endsection
