
@extends('admin.layout')

@section('title', 'Edit Supplier')
@section('page-heading', 'Edit Supplier')
@section('page-description', 'Perbarui informasi pemasok.')

@section('content')
<section class="panel">
    <h2 class="panel-title">{{ $supplier->name }}</h2>
    <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}">
        @csrf
        @method('PUT')
        @include('admin.suppliers._form', ['supplier' => $supplier, 'submitLabel' => 'Simpan Perubahan'])
    </form>
</section>
@endsection
