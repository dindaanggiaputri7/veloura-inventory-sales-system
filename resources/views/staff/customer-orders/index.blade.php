@extends('staff.layout')
@section('title','Pesanan Customer')
@section('page-heading','Pesanan Customer')
@section('page-description','Periksa pesanan yang masuk, pembayaran, dan status proses.')
@section('content')
@if(session('success'))<div style="padding:12px;background:#e7f6ec;color:#216e39;border-radius:8px;margin-bottom:16px">{{ session('success') }}</div>@endif
<div style="background:white;padding:22px;border:1px solid #eadbd6;border-radius:12px"><div style="overflow-x:auto"><table style="width:100%;border-collapse:collapse;font-size:12px"><thead><tr style="background:#fcf8f5;text-align:left"><th style="padding:12px">No.</th><th style="padding:12px">Nomor Pesanan</th><th style="padding:12px">Customer</th><th style="padding:12px">Tanggal</th><th style="padding:12px">Total</th><th style="padding:12px">Pembayaran</th><th style="padding:12px">Status Pesanan</th><th style="padding:12px">Detail</th></tr></thead><tbody>
@forelse($orders as $order)<tr style="border-bottom:1px solid #f1e8e4"><td style="padding:12px">{{ $orders->firstItem()+$loop->index }}</td><td style="padding:12px;font-weight:600">{{ $order->order_number }}</td><td style="padding:12px">{{ $order->customer_name }}</td><td style="padding:12px">{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td><td style="padding:12px">Rp {{ number_format((float)$order->total,0,',','.') }}</td><td style="padding:12px">{{ ucfirst($order->payment_status) }}</td><td style="padding:12px">{{ ucfirst($order->status) }}</td><td style="padding:12px"><a href="{{ route('staff.customer-orders.show',$order->id) }}" style="color:#57222f;font-weight:bold">Periksa</a></td></tr>@empty<tr><td colspan="8" style="padding:20px;text-align:center">Belum ada pesanan Customer.</td></tr>@endforelse
</tbody></table></div><div style="margin-top:18px">{{ $orders->links() }}</div></div>
@endsection
