@extends('customer.layout')

@section('title', 'Dashboard Customer')
@section('page-heading', 'Dashboard Customer')
@section('page-description', 'Selamat datang kembali. Temukan aroma favoritmu dan pantau pesanan di satu tempat.')

@section('content')
<section class="welcome">
    <div class="welcome-copy">
        <div class="eyebrow">Selamat datang di Veloura</div>
        <h1>Selamat datang, {{ auth()->user()->name }}!</h1>
        <p>Temukan aroma yang paling menggambarkan dirimu. Jelajahi koleksi parfum pilihan dan pantau pesananmu dengan mudah di satu tempat.</p>
        <a class="btn" href="{{ route('customer.catalog') }}">Lihat Katalog &nbsp; →</a>
    </div>
    <img
        <img class="welcome-art"
        src="{{ asset('images/veluora.png') }}"
        alt="Parfum Veloura">
</section>

<div class="stats">
    <div class="stat"><div class="label">Total Pesanan</div><div class="number">{{ $ordersCount }}</div><div class="muted">Semua pesanan kamu</div></div>
    <div class="stat"><div class="label">Pesanan Diproses</div><div class="number">{{ $pendingCount }}</div><div class="muted">Pesanan yang masih berjalan</div></div>
    <div class="stat"><div class="label">Kategori Parfum</div><div class="number">{{ $categories->count() }}</div><div class="muted">Pilihan aroma untukmu</div></div>
</div>

<div class="section-head">
    <div><h2>Kategori Populer</h2><div class="muted">Pilih aroma sesuai kepribadianmu</div></div>
    <a class="btn btn-light btn-sm" href="{{ route('customer.catalog') }}">Lihat Semua</a>
</div>
<div class="categories">
    @forelse($categories as $category)
        <a class="category" href="{{ route('customer.catalog', ['category' => $category->id]) }}">
            @include('customer.partials.category-image', ['category' => $category])
            <strong>{{ $category->name }} <span style="float:right">→</span></strong>
        </a>
    @empty
        <div class="panel">Kategori belum tersedia.</div>
    @endforelse
</div>

<div class="section-head">
    <div><h2>Rekomendasi Untukmu</h2><div class="muted">Koleksi parfum yang bisa kamu jelajahi</div></div>
    <a class="btn btn-light btn-sm" href="{{ route('customer.catalog') }}">Jelajahi Koleksi</a>
</div>
<div class="products">
    @forelse($products as $product)
        <article class="product-card">
            @include('customer.partials.product-image', ['product' => $product, 'imageClass' => 'product-image'])
            <div class="product-info">
                <span class="badge">Veloura Signature</span>
                <h3>{{ $product->name }}</h3>
                <div class="price">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                <p class="muted">Stok tersedia: {{ $product->stock }}</p>
                <a class="btn btn-sm" href="{{ route('customer.products.show', $product->id) }}">Lihat Detail</a>
            </div>
        </article>
    @empty
        <div class="panel">Belum ada produk tersedia. Silakan kembali lagi nanti.</div>
    @endforelse
</div>

<div class="section-head">
    <div><h2>Pesanan Terbaru</h2><div class="muted">Pantau perkembangan pesananmu</div></div>
    <a class="btn btn-light btn-sm" href="{{ route('customer.orders') }}">Lihat Pesanan</a>
</div>
<div class="panel table-wrap">
    <table>
        <thead><tr><th>No. Pesanan</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($latestOrders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td><span class="badge">{{ ucfirst($order->status) }}</span></td>
                    <td><a class="btn btn-light btn-sm" href="{{ route('customer.order.show', $order->id) }}">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">Kamu belum memiliki pesanan. Yuk, temukan aroma favoritmu!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
