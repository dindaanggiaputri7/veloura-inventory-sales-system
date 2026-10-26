@php
    $productImageName = \Illuminate\Support\Str::lower($product->name ?? '');
    $productImageFile = match (true) {
        \Illuminate\Support\Str::contains($productImageName, ['midnight', 'rose']) => 'veloura-midnight-rose-katalog.jpg',
        \Illuminate\Support\Str::contains($productImageName, ['bloom', 'floral']) => 'veloura-bloom-katalog.jpg',
        \Illuminate\Support\Str::contains($productImageName, ['oud', 'essence', 'woody']) => 'veloura-oud-essence-katalog.jpg',
        \Illuminate\Support\Str::contains($productImageName, ['pure', 'mist', 'fresh']) => 'veloura-pure-mist-katalog.jpg',
        default => 'veluora.png',
    };
@endphp
<img
    src="{{ asset('images/' . $productImageFile) }}"
    class="{{ $imageClass ?? 'product-image' }}"
    alt="Parfum {{ $product->name }}"
    loading="lazy"
    onerror="this.onerror=null;this.src='{{ asset('images/veloura-bloom-katalog.jpg') }}';"
>
