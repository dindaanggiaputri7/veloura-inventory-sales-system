@extends('customer.layout')
@section('title','Profil Saya')
@section('content')
<div class="section-head" style="margin-top:0"><div><h2>Profil Saya</h2><div class="muted">Kelola informasi akun Veloura kamu.</div></div></div>
<div class="panel" style="max-width:760px"><form method="POST" action="{{ route('customer.profile.update') }}">@csrf @method('PUT')
<div class="form-grid">
<div class="field full"><label for="name">Nama Lengkap</label><input id="name" name="name" value="{{ old('name',$user->name) }}" required maxlength="255"></div>
<div class="field full"><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email',$user->email) }}" required></div>
<div class="field"><label for="password">Password Baru (opsional)</label><input id="password" name="password" type="password" minlength="8" autocomplete="new-password" placeholder="Minimal 8 karakter"></div>
<div class="field"><label for="password_confirmation">Konfirmasi Password Baru</label><input id="password_confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password"></div>
</div><p class="muted">Kosongkan password jika tidak ingin mengubahnya.</p><button class="btn" type="submit">Simpan Perubahan</button>
</form></div>
@endsection
