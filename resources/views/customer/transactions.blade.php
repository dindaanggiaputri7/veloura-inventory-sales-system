@extends('customer.layout')
@section('title','Riwayat Transaksi')
@section('content')
<div class="section-head" style="margin-top:0"><div><h2>Riwayat Transaksi</h2><div class="muted">Pesanan yang sudah selesai atau dikirim.</div></div></div>
<div class="panel table-wrap"><table><thead><tr><th>No. Pesanan</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Detail</th></tr></thead><tbody>
@forelse($orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td><td>Rp {{ number_format($order->total,0,',','.') }}</td><td><span class="badge">{{ ucfirst($order->status) }}</span></td><td><a class="btn btn-light btn-sm" href="{{ route('customer.order.show',$order->id) }}">Detail</a></td></tr>@empty<tr><td colspan="5" class="empty">Belum ada transaksi selesai.</td></tr>@endforelse
</tbody></table>
@if($orders->hasPages())<div class="pagination">@if($orders->onFirstPage())<span>‹</span>@else<a href="{{ $orders->previousPageUrl() }}">‹</a>@endif @foreach($orders->getUrlRange(1,$orders->lastPage()) as $page=>$url) @if($page==$orders->currentPage())<span class="active">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif @endforeach @if($orders->hasMorePages())<a href="{{ $orders->nextPageUrl() }}">›</a>@else<span>›</span>@endif</div>@endif
</div>
@endsection
