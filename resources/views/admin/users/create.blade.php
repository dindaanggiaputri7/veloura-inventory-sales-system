
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Staff | Veloura</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #F8F1EB;
            color: #342421;
        }
        header {
            background: #5B1726;
            color: white;
            padding: 24px 7%;
        }
        header h1 { margin: 0 0 8px; letter-spacing: 2px; }
        header p { margin: 0; color: #E8CFC9; }
        main { max-width: 760px; margin: 32px auto; padding: 0 20px; }
        .back { display: inline-block; margin-bottom: 20px; color: #5B1726; }
        .panel {
            background: white;
            border: 1px solid #E8CFC9;
            border-radius: 14px;
            padding: 28px;
        }
        h2 { color: #5B1726; margin-top: 0; }
        .muted { color: #75645F; line-height: 1.5; }
        label { display: block; margin: 18px 0 8px; font-weight: bold; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #E8CFC9;
            border-radius: 8px;
            font-size: 15px;
        }
        .button {
            display: inline-block;
            padding: 12px 16px;
            border: 0;
            border-radius: 8px;
            background: #5B1726;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }
        .secondary { background: #E8CFC9; color: #342421; }
        .actions { display: flex; gap: 10px; margin-top: 24px; }
        .error { color: #A12626; font-size: 14px; margin-top: 6px; }
        .notice {
            padding: 12px;
            border-radius: 8px;
            background: #F8F1EB;
            margin-top: 16px;
        }
    </style>
</head>
<body>
<header>
    <h1>VELOURA</h1>
    <p>Manajemen Akun Staff</p>
</header>

<main>
    <a class="back" href="{{ route('admin.users.index') }}">
        &larr; Kembali ke Daftar Staff
    </a>

    <section class="panel">
        <h2>Tambah Staff</h2>
        <p class="muted">
            Masukkan data pegawai yang akan diberikan akses ke sistem Veloura.
        </p>

        @if ($errors->any())
            <div class="notice">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <label for="name">Nama lengkap</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name') }}" required maxlength="255">
            @error('name') <p class="error">{{ $message }}</p> @enderror

            <label for="email">Email</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email') }}" required maxlength="255">
            @error('email') <p class="error">{{ $message }}</p> @enderror

            <label for="password">Password sementara</label>
            <input id="password" name="password" type="password"
                   required minlength="8" autocomplete="new-password">
            @error('password') <p class="error">{{ $message }}</p> @enderror

            <label for="password_confirmation">Konfirmasi password</label>
            <input id="password_confirmation" name="password_confirmation"
                   type="password" required minlength="8"
                   autocomplete="new-password">

            <div class="notice">
                Role akun akan ditetapkan otomatis menjadi <strong>Staff</strong>.
            </div>

            <div class="actions">
                <button class="button" type="submit">Simpan Staff</button>
                <a class="button secondary"
                   href="{{ route('admin.users.index') }}">Batal</a>
            </div>
        </form>
    </section>
</main>
</body>
</html>
