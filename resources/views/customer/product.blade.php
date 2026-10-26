@extends('customer.layout')

@section('title', $product->name)
@section('page-heading', 'Detail Produk')
@section('page-description', 'Kenali detail aroma, harga, dan stok sebelum menambahkan produk ke keranjang.')

@section('content')
<p class="muted"><a href="{{ route('customer.catalog') }}">Katalog</a> / {{ $product->name }}</p>
<div class="panel product-layout">
    <div>
        @include('customer.partials.product-image', ['product' => $product, 'imageClass' => 'product-hero'])
    </div>
    <div style="padding:8px 0">
        <div class="eyebrow">{{ $product->category_name ?? 'Veloura Signature' }}</div>
        <h1 style="font:500 34px Georgia,serif;color:var(--wine);margin:12px 0">{{ $product->name }}</h1>
        <div class="price" style="font-size:23px">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
        <p class="muted" style="line-height:1.8">{{ $product->description ?: 'Temukan karakter aroma istimewa dari koleksi Veloura.' }}</p>
        <p><span class="badge">SKU: {{ $product->sku }}</span> <span class="badge">Stok: {{ $product->stock }}</span></p>
        @if($product->stock > 0)
            <form method="POST" action="{{ route('customer.cart.add', $product->id) }}" class="panel" style="padding:16px;margin-top:20px">
                @csrf
                <label class="field">Jumlah
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required>
                </label>
                <button class="btn" style="width:100%;margin-top:14px">♡ &nbsp; Tambah ke Keranjang</button>
            </form>
        @else
            <div class="alert error">Stok sedang habis.</div>
        @endif
        <p><a class="btn btn-light" href="{{ route('customer.catalog') }}">← Kembali ke Katalog</a></p>
    </div>
</div>
@endsection
