
@extends('admin.layout')

@section('title', 'Tambah Produk')
@section('page-heading', 'Tambah Produk')
@section('page-description', 'Tambahkan produk baru ke inventaris Veloura.')

@section('content')
<section class="panel">
    <h2 class="panel-title">Informasi Produk</h2>

    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf

        @include('admin.products._form', ['product' => null, 'submitLabel' => 'Simpan Produk'])
    </form>
</section>
@endsection
