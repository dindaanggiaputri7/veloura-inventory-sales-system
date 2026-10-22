@extends('customer.layout')
@section('title','Keranjang')
@section('content')
<div class="section-head" style="margin-top:0"><div><h2>Keranjang Belanja</h2><div class="muted">Periksa kembali produk sebelum melanjutkan.</div></div><a class="btn btn-light btn-sm" href="{{ route('customer.catalog') }}">+ Tambah Produk</a></div>
<div class="panel table-wrap">
@if(count($items))
<table><thead><tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead><tbody>
@foreach($items as $item)
<tr><td><strong>{{ $item->product->name }}</strong><br><small class="muted">{{ $item->product->sku }}</small></td><td>Rp {{ number_format($item->product->selling_price,0,',','.') }}</td><td><form method="POST" action="{{ route('customer.cart.update',$item->product->id) }}" style="display:flex;gap:5px">@csrf @method('PATCH')<input style="width:68px;padding:7px;border:1px solid var(--line);border-radius:7px" type="number" name="quantity" min="1" max="{{ $item->product->stock }}" value="{{ $item->quantity }}"><button class="btn btn-light btn-sm">Ubah</button></form></td><td>Rp {{ number_format($item->line_total,0,',','.') }}</td><td><form method="POST" action="{{ route('customer.cart.remove',$item->product->id) }}" onsubmit="return confirm('Hapus produk ini dari keranjang?')">@csrf @method('DELETE')<button class="btn btn-light btn-sm">Hapus</button></form></td></tr>
@endforeach
</tbody></table>
<div style="display:flex;justify-content:flex-end;margin-top:22px"><div style="width:min(100%,350px)"><div style="display:flex;justify-content:space-between;padding:12px 0"><span>Subtotal</span><strong>Rp {{ number_format($subtotal,0,',','.') }}</strong></div><div class="muted">Ongkos kirim dikonfirmasi sesuai kebijakan toko.</div><a class="btn" style="width:100%;margin-top:14px" href="{{ route('customer.checkout') }}">Lanjut ke Checkout →</a></div></div>
@else<div class="empty"><h3>Keranjangmu masih kosong</h3><p>Temukan aroma favoritmu dari koleksi Veloura.</p><a class="btn" href="{{ route('customer.catalog') }}">Jelajahi Katalog</a></div>@endif
</div>
@endsection
