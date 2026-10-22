
@extends('admin.layout')

@section('title', 'Edit Kategori')
@section('page-heading', 'Edit Kategori')
@section('page-description', 'Perbarui informasi kategori yang dipilih.')

@section('content')
<section class="panel">
    <h2 class="panel-title">Edit: {{ $category->name }}</h2>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="name">Nama Kategori *</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $category->name) }}" required maxlength="255">
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" maxlength="2000">{{ old('description', $category->description) }}</textarea>
            @error('description') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</section>
@endsection
