
@extends('admin.layout')

@section('title', 'Edit Produk')
@section('page-heading', 'Edit Produk')
@section('page-description', 'Perbarui informasi produk yang dipilih.')

@section('content')
<section class="panel">
    <h2 class="panel-title">{{ $product->name }}</h2>

    <form method="POST" action="{{ route('admin.products.update', $product) }}">
        @csrf
        @method('PUT')

        @include('admin.products._form', ['product' => $product, 'submitLabel' => 'Simpan Perubahan'])
    </form>
</section>
@endsection
