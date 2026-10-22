@extends('admin.layout')

@section('title', 'Tambah Staff')
@section('page-heading', 'Tambah Staff')
@section('page-description', 'Daftarkan akun pegawai baru ke sistem Veloura.')

@section('content')
<div class="panel" style="max-width:850px;margin:0 auto">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px">
        <div style="width:46px;height:46px;border-radius:12px;background:#f5e9e7;color:#54252f;display:flex;align-items:center;justify-content:center;font-size:21px;font-weight:700">
            +
        </div>
        <div>
            <h2 style="font-size:20px;margin:0 0 5px;color:#392b2d">
                Informasi Staff
            </h2>
            <p style="font-size:13px;color:#88797a;margin:0">
                Isi data akun yang akan digunakan untuk mengakses sistem.
            </p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom:20px">
            <strong>Periksa kembali data berikut:</strong>
            <ul style="margin:8px 0 0;padding-left:20px">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <div style="grid-column:1/-1">
                <label for="name">Nama lengkap <span style="color:#a52d36">*</span></label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap staff"
                    required
                    autocomplete="name"
                    style="width:100%;margin-top:8px"
                >
                @error('name')
                    <p style="color:#a52d36;font-size:12px;margin-top:6px">{{ $message }}</p>
                @enderror
            </div>

            <div style="grid-column:1/-1">
                <label for="email">Alamat email <span style="color:#a52d36">*</span></label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@veloura.com"
                    required
                    autocomplete="email"
                    style="width:100%;margin-top:8px"
                >
                @error('email')
                    <p style="color:#a52d36;font-size:12px;margin-top:6px">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password">Password sementara <span style="color:#a52d36">*</span></label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                    autocomplete="new-password"
                    style="width:100%;margin-top:8px"
                >
                @error('password')
                    <p style="color:#a52d36;font-size:12px;margin-top:6px">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation">Konfirmasi password <span style="color:#a52d36">*</span></label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                    autocomplete="new-password"
                    style="width:100%;margin-top:8px"
                >
            </div>
        </div>

        <div style="margin-top:26px;padding-top:20px;border-top:1px solid #eee4df;display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan Staff
            </button>
        </div>
    </form>
</div>

<style>
@media(max-width:600px) {
    .panel {
        padding:18px !important;
    }
    .panel form > div:first-of-type {
        grid-template-columns:1fr !important;
    }
    .panel form > div:first-of-type > div {
        grid-column:1 !important;
    }
}
</style>
@endsection