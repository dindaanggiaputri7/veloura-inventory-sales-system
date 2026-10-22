@extends('customer.layout')
@section('title','Pesanan Saya')
@section('content')
<div class="section-head" style="margin-top:0"><div><h2>Pesanan Saya</h2><div class="muted">Pantau status pesanan dan detail pembelianmu.</div></div><a class="btn btn-light btn-sm" href="{{ route('customer.catalog') }}">Belanja Lagi</a></div>
<div class="panel table-wrap"><table><thead><tr><th>No. Pesanan</th><th>Tanggal</th><th>Total</th><th>Pembayaran</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($orders as $order)
<tr><td><strong>{{ $order->order_number }}</strong></td><td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td><td>Rp {{ number_format($order->total,0,',','.') }}</td><td>{{ $order->payment_status === 'paid' ? 'Dibayar' : 'Belum dibayar' }}</td><td><span class="badge">{{ ucfirst($order->status) }}</span></td><td><a class="btn btn-light btn-sm" href="{{ route('customer.order.show',$order->id) }}">Detail</a></td></tr>
@empty<tr><td colspan="6" class="empty">Belum ada pesanan. Pesanan yang kamu buat akan muncul di sini.</td></tr>@endforelse
</tbody></table>
@if($orders->hasPages())<div class="pagination">@if($orders->onFirstPage())<span>‹</span>@else<a href="{{ $orders->previousPageUrl() }}">‹</a>@endif @foreach($orders->getUrlRange(1,$orders->lastPage()) as $page=>$url) @if($page==$orders->currentPage())<span class="active">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif @endforeach @if($orders->hasMorePages())<a href="{{ $orders->nextPageUrl() }}">›</a>@else<span>›</span>@endif</div>@endif
</div>
@endsection
