
@extends('admin.layout')

@section('title', 'Edit Akun Staff')
@section('page-heading', 'Edit Akun Staff')
@section('page-description', 'Perbarui informasi akun pegawai Veloura.')

@section('content')
<style>
    .staff-edit-wrap {
        max-width: 780px;
        margin: 0 auto;
    }

    .staff-edit-card {
        background: #fff;
        border: 1px solid #eee1dc;
        border-radius: 15px;
        padding: 26px;
        box-shadow: 0 4px 16px rgba(84, 37, 47, .04);
    }

    .staff-edit-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 22px;
    }

    .staff-edit-top h2 {
        margin: 0 0 7px;
        color: #54252f;
        font-size: 21px;
    }

    .staff-edit-muted {
        color: #88797a;
        font-size: 13px;
        line-height: 1.6;
        margin: 0;
    }

    .staff-edit-back {
        color: #54252f;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .staff-edit-summary {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 15px;
        margin-bottom: 25px;
        background: #faf5f2;
        border: 1px solid #eee1dc;
        border-radius: 11px;
    }

    .staff-edit-avatar {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #642b3a;
        color: white;
        font-size: 18px;
        font-weight: 700;
    }

    .staff-edit-name {
        font-size: 14px;
        font-weight: 700;
        color: #392b2d;
        margin-bottom: 4px;
    }

    .staff-edit-email {
        font-size: 12px;
        color: #88797a;
        overflow-wrap: anywhere;
    }

    .staff-edit-status {
        display: inline-block;
        margin-top: 6px;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .staff-edit-status.active {
        color: #187447;
        background: #e4f5e9;
    }

    .staff-edit-status.inactive {
        color: #a12626;
        background: #fde9e8;
    }

    .staff-edit-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #54252f;
        margin: 0 0 16px;
    }

    .staff-edit-field {
        margin-bottom: 18px;
    }

    .staff-edit-field label {
        display: block;
        margin-bottom: 7px;
        color: #49383a;
        font-size: 13px;
        font-weight: 600;
    }

    .staff-edit-field input {
        display: block;
        width: 100%;
        min-height: 42px;
        padding: 10px 12px;
        box-sizing: border-box;
        border: 1px solid #e7d7d0;
        border-radius: 8px;
        background: #fff;
        color: #392b2d;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .staff-edit-field input:focus {
        border-color: #8b5360;
        box-shadow: 0 0 0 3px rgba(100, 43, 58, .09);
    }

    .staff-edit-field input::placeholder {
        color: #a39794;
    }

    .staff-edit-error {
        color: #b42318;
        font-size: 12px;
        margin: 6px 0 0;
    }

    .staff-edit-divider {
        border: 0;
        border-top: 1px solid #eee1dc;
        margin: 23px 0;
    }

    .staff-edit-note {
        padding: 12px 14px;
        border: 1px solid #eee1dc;
        border-radius: 9px;
        background: #faf5f2;
        color: #75645f;
        font-size: 12px;
        line-height: 1.7;
    }

    .staff-edit-note strong {
        color: #54252f;
    }

    .staff-edit-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 23px;
    }

    .staff-edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 39px;
        padding: 10px 16px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .staff-edit-btn-primary {
        color: #fff;
        background: #642b3a;
    }

    .staff-edit-btn-primary:hover {
        background: #4f202e;
    }

    .staff-edit-btn-secondary {
        color: #54252f;
        background: #f6eae7;
        border-color: #eedbd5;
    }

    .staff-edit-btn-secondary:hover {
        background: #efddda;
    }

    .staff-edit-alert {
        padding: 13px 15px;
        margin-bottom: 20px;
        border-radius: 9px;
        font-size: 13px;
        line-height: 1.6;
    }

    .staff-edit-alert ul {
        margin: 7px 0 0;
        padding-left: 20px;
    }

    .staff-edit-alert-error {
        color: #a12626;
        background: #fff0f0;
        border: 1px solid #f0cccc;
    }

    .staff-edit-alert-success {
        color: #216e39;
        background: #eaf7ee;
        border: 1px solid #c7e8d0;
    }

    @media (max-width: 600px) {
        .staff-edit-card {
            padding: 18px;
        }

        .staff-edit-top {
            flex-direction: column;
        }

        .staff-edit-actions {
            flex-direction: column-reverse;
        }

        .staff-edit-btn {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>

<div class="staff-edit-wrap">
    <section class="staff-edit-card">

        <div class="staff-edit-top">
            <div>
                <h2>Informasi Staff</h2>
                <p class="staff-edit-muted">
                    Perbarui nama, email, dan keamanan akun staff.
                </p>
            </div>

            <a class="staff-edit-back"
               href="{{ route('admin.users.index') }}">
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="staff-edit-alert staff-edit-alert-error">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="staff-edit-alert staff-edit-alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="staff-edit-summary">
            <div class="staff-edit-avatar">
                {{ strtoupper(substr($staff->name, 0, 1)) }}
            </div>

            <div style="min-width:0;">
                <div class="staff-edit-name">{{ $staff->name }}</div>
                <div class="staff-edit-email">{{ $staff->email }}</div>

                <span class="staff-edit-status {{ $staff->is_active ? 'active' : 'inactive' }}">
                    {{ $staff->is_active ? '● Akun Aktif' : '● Akun Nonaktif' }}
                </span>
            </div>
        </div>

        <form method="POST"
              action="{{ route('admin.users.update', $staff->id) }}">
            @csrf
            @method('PUT')

            <h3 class="staff-edit-section-title">Data Pribadi</h3>

            <div class="staff-edit-field">
                <label for="name">Nama Lengkap <span style="color:#b42318;">*</span></label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $staff->name) }}"
                    maxlength="255"
                    required
                >
                @error('name')
                    <p class="staff-edit-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="staff-edit-field">
                <label for="email">Alamat Email <span style="color:#b42318;">*</span></label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $staff->email) }}"
                    maxlength="255"
                    required
                >
                @error('email')
                    <p class="staff-edit-error">{{ $message }}</p>
                @enderror
            </div>

            <hr class="staff-edit-divider">

            <h3 class="staff-edit-section-title">Keamanan Akun</h3>
            <p class="staff-edit-muted" style="margin-bottom:18px;">
                Password tidak perlu diisi jika kamu tidak ingin menggantinya.
            </p>

            <div class="staff-edit-field">
                <label for="password">Password Baru</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    minlength="8"
                    autocomplete="new-password"
                    placeholder="Masukkan password baru (opsional)"
                >
                @error('password')
                    <p class="staff-edit-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="staff-edit-field">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    minlength="8"
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                >
            </div>

            <div class="staff-edit-note">
                <strong>Informasi Role</strong><br>
                Akun ini tetap memiliki role <strong>Staff</strong>.
                Perubahan role tidak dilakukan melalui formulir ini.
            </div>

            <div class="staff-edit-actions">
                <a href="{{ route('admin.users.index') }}"
                   class="staff-edit-btn staff-edit-btn-secondary">
                    Batal
                </a>

                <button type="submit"
                        class="staff-edit-btn staff-edit-btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section>
</div>
@endsection
