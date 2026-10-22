
@extends('admin.layout')

@section('title', 'Tambah Supplier')
@section('page-heading', 'Tambah Supplier')
@section('page-description', 'Daftarkan pemasok baru ke sistem Veloura.')

@section('content')
<section class="panel">
    <h2 class="panel-title">Informasi Supplier</h2>
    <form method="POST" action="{{ route('admin.suppliers.store') }}">
        @csrf
        @include('admin.suppliers._form', ['supplier' => null, 'submitLabel' => 'Simpan Supplier'])
    </form>
</section>
@endsection
