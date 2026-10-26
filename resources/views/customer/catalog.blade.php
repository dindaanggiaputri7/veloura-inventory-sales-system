@extends('customer.layout')

@section('title', 'Katalog Parfum')
@section('page-heading', 'Katalog Parfum')
@section('page-description', 'Jelajahi produk Veloura dan pilih aroma yang paling cocok untukmu.')

@section('content')
<div class="section-head" style="margin-top:0">
    <div><div class="eyebrow">The Veloura Collection</div><h2>Koleksi Parfum</h2><div class="muted">Temukan aroma yang paling cocok untukmu.</div></div>
</div>

<form method="GET" action="{{ route('customer.catalog') }}" class="panel" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px">
    <input class="search-input" style="flex:2;min-width:190px" name="q" value="{{ request('q') }}" placeholder="Cari nama parfum atau SKU...">
    <select class="search-input" style="flex:1;min-width:160px" name="category">
        <option value="">Semua Kategori</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
    <button class="btn" type="submit">Cari Produk</button>
    <a class="btn btn-light" href="{{ route('customer.catalog') }}">Reset</a>
</form>

<div class="products">
    @forelse($products as $product)
        <article class="product-card">
            @include('customer.partials.product-image', ['product' => $product, 'imageClass' => 'product-image'])
            <div class="product-info">
                <span class="badge">{{ $product->category_name ?? 'Veloura' }}</span>
                <h3>{{ $product->name }}</h3>
                <div class="muted">{{ $product->sku }}</div>
                <p class="muted">{{ \Illuminate\Support\Str::limit($product->description, 75) }}</p>
                <div class="price">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                <p class="muted">Stok: {{ $product->stock }}</p>
                <a class="btn btn-sm" href="{{ route('customer.products.show', $product->id) }}">Lihat Detail →</a>
            </div>
        </article>
    @empty
        <div class="panel empty" style="grid-column:1/-1"><h3>Produk belum ditemukan</h3><p>Coba kata kunci atau kategori lain.</p><a class="btn" href="{{ route('customer.catalog') }}">Lihat Semua Produk</a></div>
    @endforelse
</div>

@if($products->hasPages())
    <div class="pagination">
        @if($products->onFirstPage())<span>‹</span>@else<a href="{{ $products->previousPageUrl() }}">‹</a>@endif
        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if($page == $products->currentPage())<span class="active">{{ $page }}</span>@else<a href="{{ $url }}">{{ $page }}</a>@endif
        @endforeach
        @if($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}">›</a>@else<span>›</span>@endif
    </div>
@endif
@endsection
