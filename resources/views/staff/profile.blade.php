
@extends('staff.layout')

@section('title', 'Profil Saya')
@section('page-heading', 'Profil Saya')
@section('page-description', 'Lihat dan perbarui informasi akun Staff Anda.')

@section('content')

<style>
    .staff-profile-page {
        color: #3c292e;
    }

    .staff-profile-page .profile-banner {
        padding: 24px;
        margin-bottom: 20px;
        border-radius: 13px;
        color: white;
        background: linear-gradient(115deg, #57222f, #804653);
    }

    .staff-profile-page .profile-banner h2 {
        margin: 0 0 8px;
        color: white;
        font-size: 21px;
    }

    .staff-profile-page .profile-banner p {
        margin: 0;
        color: #f3e4e5;
        font-size: 12px;
        line-height: 1.7;
    }

    .staff-profile-page .profile-card {
        max-width: 850px;
        padding: 24px;
        margin-bottom: 18px;
        border: 1px solid #eadbd6;
        border-radius: 13px;
        background: white;
    }

    .staff-profile-page .profile-card h3 {
        margin: 0 0 7px;
        font-size: 16px;
    }

    .staff-profile-page .description {
        margin: 0 0 22px;
        color: #99878b;
        font-size: 11px;
        line-height: 1.6;
    }

    .staff-profile-page .field {
        margin-bottom: 17px;
    }

    .staff-profile-page label {
        display: block;
        margin-bottom: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .staff-profile-page input {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #e5d5d1;
        border-radius: 8px;
        outline: none;
        background: #fffdfb;
        color: #3c292e;
        font: inherit;
    }

    .staff-profile-page input:focus {
        border-color: #804653;
        box-shadow: 0 0 0 3px rgba(128,70,83,.1);
    }

    .staff-profile-page .error {
        margin-top: 6px;
        color: #b42332;
        font-size: 11px;
    }

    .staff-profile-page .button {
        display: inline-block;
        padding: 11px 17px;
        border: 0;
        border-radius: 8px;
        background: #57222f;
        color: white;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .staff-profile-page .button:hover {
        background: #713746;
    }

    .staff-profile-page .success {
        margin-bottom: 17px;
        padding: 11px 13px;
        border: 1px solid #c8e8d0;
        border-radius: 8px;
        background: #edf8ef;
        color: #286a45;
        font-size: 12px;
    }

    .staff-profile-page .account-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .staff-profile-page .info-item {
        padding: 14px;
        border: 1px solid #eee2dd;
        border-radius: 9px;
        background: #fcf8f5;
    }

    .staff-profile-page .info-label {
        margin-bottom: 7px;
        color: #99878b;
        font-size: 10px;
    }

    .staff-profile-page .info-value {
        font-size: 13px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    @media (max-width: 600px) {
        .staff-profile-page .profile-card {
            padding: 17px;
        }

        .staff-profile-page .account-info {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="staff-profile-page">

    <section class="profile-banner">
        <h2>Informasi Akun Staff</h2>
        <p>
            Kelola informasi pribadi dan keamanan akun untuk mendukung
            aktivitas operasional Veloura.
        </p>
    </section>

    <section class="profile-card">
        <h3>Ringkasan Akun</h3>
        <p class="description">
            Informasi akun yang sedang digunakan.
        </p>

        <div class="account-info">
            <div class="info-item">
                <div class="info-label">Nama Staff</div>
                <div class="info-value">{{ auth()->user()->name }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Email</div>
                <div class="info-value">{{ auth()->user()->email }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Role Akun</div>
                <div class="info-value">Staff</div>
            </div>

            <div class="info-item">
                <div class="info-label">Status Email</div>
                <div class="info-value">
                    {{ auth()->user()->email_verified_at ? 'Terverifikasi' : 'Belum terverifikasi' }}
                </div>
            </div>
        </div>
    </section>

    <section class="profile-card">
        <h3>Perbarui Informasi Profil</h3>
        <p class="description">
            Ubah nama dan alamat email akun Anda.
        </p>

        @if (session('status') === 'profile-updated')
            <div class="success">
                Profil berhasil diperbarui.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="field">
                <label for="name">Nama Lengkap</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', auth()->user()->name) }}"
                    required
                    autocomplete="name"
                >

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="email">Alamat Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', auth()->user()->email) }}"
                    required
                    autocomplete="username"
                >

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="button">
                Simpan Perubahan
            </button>
        </form>
    </section>

    <section class="profile-card">
        <h3>Keamanan Akun</h3>
        <p class="description">
            Gunakan halaman pengaturan profil Laravel untuk memperbarui
            kata sandi dan pengaturan keamanan yang tersedia.
        </p>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="button">
                Pengaturan Kata Sandi
            </a>
        @endif
    </section>

</div>

@endsection
