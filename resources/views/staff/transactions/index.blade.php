@extends('staff.layout')
@section('title','Riwayat Transaksi')
@section('page-heading','Riwayat Transaksi')
@section('page-description','Riwayat penjualan langsung dan pesanan Customer.')
@section('content')
<div style="background:white;padding:22px;border:1px solid #eadbd6;border-radius:12px"><div style="overflow-x:auto"><table style="width:100%;border-collapse:collapse;font-size:12px"><thead><tr style="background:#fcf8f5;text-align:left"><th style="padding:12px">No.</th><th style="padding:12px">Nomor Transaksi</th><th style="padding:12px">Tanggal</th><th style="padding:12px">Pelanggan</th><th style="padding:12px">Jenis</th><th style="padding:12px">Total</th><th style="padding:12px">Status</th></tr></thead><tbody>
@forelse($transactions as $transaction)<tr style="border-bottom:1px solid #f1e8e4"><td style="padding:12px">{{ $transactions->firstItem()+$loop->index }}</td><td style="padding:12px;font-weight:600">{{ $transaction->transaction_number }}</td><td style="padding:12px">{{ \Illuminate\Support\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td><td style="padding:12px">{{ $transaction->customer }}</td><td style="padding:12px">{{ $transaction->type }}</td><td style="padding:12px">Rp {{ number_format((float)$transaction->total,0,',','.') }}</td><td style="padding:12px">{{ ucfirst($transaction->status) }}</td></tr>@empty<tr><td colspan="7" style="padding:20px;text-align:center">Belum ada transaksi.</td></tr>@endforelse
</tbody></table></div><div style="margin-top:18px">{{ $transactions->links() }}</div></div>
@endsection
