@extends('customer.layout')
@section('title','Checkout')
@section('content')
<div class="section-head" style="margin-top:0"><div><h2>Checkout</h2><div class="muted">Lengkapi alamat dan periksa ringkasan pesanan.</div></div></div>
<form method="POST" action="{{ route('customer.checkout.store') }}">@csrf
<div class="product-layout" style="align-items:start">
<div class="panel"><h3 style="margin-top:0">Informasi Pengiriman</h3>
<div class="form-grid">
<div class="field"><label>Nama</label><input value="{{ auth()->user()->name }}" disabled></div>
<div class="field"><label>Email</label><input value="{{ auth()->user()->email }}" disabled></div>
<div class="field full"><label for="phone">Nomor Telepon (opsional)</label><input id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"></div>
<div class="field full"><label for="shipping_address">Alamat Lengkap *</label><textarea id="shipping_address" name="shipping_address" required placeholder="Nama jalan, nomor rumah, desa/kelurahan, kecamatan, kota, provinsi, kode pos">{{ old('shipping_address') }}</textarea></div>
<div class="field full"><label for="customer_note">Catatan Pesanan (opsional)</label><textarea id="customer_note" name="customer_note" placeholder="Catatan untuk penjual">{{ old('customer_note') }}</textarea></div>
<div class="field full"><label>Metode Pembayaran</label><select name="payment_method"><option value="transfer_manual">Transfer Manual (konfirmasi oleh Staff)</option></select><small class="muted">Instruksi rekening/QRIS akan mengikuti informasi resmi dari toko. Jangan transfer ke rekening yang belum dikonfirmasi.</small></div>
</div></div>
<div class="panel"><h3 style="margin-top:0">Ringkasan Pesanan</h3>
@foreach($items as $item)<div style="display:flex;justify-content:space-between;gap:12px;padding:12px 0;border-bottom:1px solid var(--line)"><div><strong>{{ $item['product']->name }}</strong><div class="muted">{{ $item['quantity'] }} × Rp {{ number_format($item['product']->selling_price,0,',','.') }}</div></div><strong>Rp {{ number_format($item['quantity']*$item['product']->selling_price,0,',','.') }}</strong></div>@endforeach
<div style="display:flex;justify-content:space-between;padding:18px 0;font-size:17px"><strong>Total</strong><strong style="color:var(--wine)">Rp {{ number_format($subtotal,0,',','.') }}</strong></div>
<p class="muted">Stok akan diperiksa ulang saat pesanan dibuat. Status awal pesanan adalah Menunggu.</p><button class="btn" style="width:100%" type="submit">Buat Pesanan</button><p><a class="muted" href="{{ route('customer.cart') }}">← Kembali ke Keranjang</a></p>
</div></div></form>
@endsection
