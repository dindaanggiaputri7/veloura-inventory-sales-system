
@extends('admin.layout')

@section('title', 'Tambah Kategori')
@section('page-heading', 'Tambah Kategori')
@section('page-description', 'Tambahkan kategori baru ke inventaris Veloura.')

@section('content')
<section class="panel">
    <h2 class="panel-title">Informasi Kategori</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="field">
            <label for="name">Nama Kategori *</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255"
                   placeholder="Contoh: Eau de Parfum">
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" maxlength="2000"
                      placeholder="Tuliskan keterangan kategori (opsional)">{{ old('description') }}</textarea>
            @error('description') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</section>
@endsection
