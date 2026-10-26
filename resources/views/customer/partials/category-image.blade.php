@php
    $categoryImageName = \Illuminate\Support\Str::lower($category->name ?? '');
    $categoryImageFile = match (true) {
        \Illuminate\Support\Str::contains($categoryImageName, ['floral', 'flower', 'bloom', 'rose']) => 'veloura-bloom-katalog.jpg',
        \Illuminate\Support\Str::contains($categoryImageName, ['woody', 'wood', 'oud', 'amber', 'oriental']) => 'veloura-oud-essence-katalog.jpg',
        \Illuminate\Support\Str::contains($categoryImageName, ['fresh', 'mist', 'aqua', 'citrus', 'clean']) => 'veloura-pure-mist-katalog.jpg',
        \Illuminate\Support\Str::contains($categoryImageName, ['midnight', 'night', 'spicy', 'rose']) => 'veloura-midnight-rose-katalog.jpg',
        default => 'veloura-bloom-katalog.jpg',
    };
@endphp
<img
    src="{{ asset('images/' . $categoryImageFile) }}"
    alt="Koleksi kategori {{ $category->name }}"
    loading="lazy"
    onerror="this.onerror=null;this.src='{{ asset('images/veloura-bloom-katalog.jpg') }}';"
>
