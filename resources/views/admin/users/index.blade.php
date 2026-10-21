
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun Staff | Veloura</title>
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

        main {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 24px;
        }

        a { color: #5B1726; }
        .back { display: inline-block; margin-bottom: 22px; }

        .panel {
            background: white;
            border: 1px solid #E8CFC9;
            border-radius: 14px;
            padding: 26px;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        h2 { color: #5B1726; margin: 0 0 8px; }
        .muted { color: #75645F; line-height: 1.5; }

        .button {
            display: inline-block;
            border: 0;
            border-radius: 8px;
            padding: 10px 14px;
            background: #5B1726;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            font-family: inherit;
            white-space: nowrap;
        }

        .button:hover { background: #76283A; }

        .button-secondary {
            background: #E8CFC9;
            color: #342421;
        }

        .button-secondary:hover { background: #DAB9B1; }

        .button-danger {
            background: #FBE5E5;
            color: #9B2929;
        }

        .button-danger:hover { background: #F3CCCC; }

        .stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin: 24px 0;
        }

        .stat-card {
            background: #F8F1EB;
            border: 1px solid #E8CFC9;
            border-radius: 12px;
            padding: 20px;
        }

        .stat-card p { margin: 0 0 10px; color: #75645F; }
        .stat-card strong { color: #5B1726; font-size: 30px; }

        .search-form {
            display: flex;
            gap: 10px;
            margin: 24px 0;
            flex-wrap: wrap;
        }

        .search-form input {
            flex: 1;
            min-width: 220px;
            padding: 12px;
            border: 1px solid #E8CFC9;
            border-radius: 8px;
            font-size: 14px;
        }

        .reset { padding: 12px; align-self: center; }
        .table-wrap { width: 100%; overflow-x: auto; }

        table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px 10px;
            text-align: left;
            border-bottom: 1px solid #E8CFC9;
            vertical-align: middle;
        }

        th { color: #5B1726; }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .active { background: #E1F3E7; color: #23643A; }
        .inactive { background: #FBE5E5; color: #9B2929; }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }

        .action-buttons form { margin: 0; }
        .empty { text-align: center; padding: 35px 12px; }
        .empty h3 { color: #5B1726; }

        .alert-success {
            background: #E1F3E7;
            color: #23643A;
            border: 1px solid #B8DEC4;
            border-radius: 8px;
            padding: 14px 16px;
            margin: 20px 0;
        }

        .pagination { margin-top: 22px; overflow-x: auto; }

        @media (max-width: 600px) {
            main { padding: 0 14px; margin: 22px auto; }
            .panel { padding: 18px; }
            .stats { grid-template-columns: 1fr; }
            .panel-heading > .button { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>
<header>
    <h1>VELOURA</h1>
    <p>Manajemen Akun Staff</p>
</header>

<main>
    <a class="back" href="{{ route('admin.dashboard') }}">
        &larr; Kembali ke Dashboard
    </a>

    <section class="panel">
        <div class="panel-heading">
            <div>
                <h2>Daftar Staff</h2>
                <p class="muted">Kelola akun dan akses pegawai Veloura.</p>
            </div>

            <a class="button" href="{{ route('admin.users.create') }}">
                + Tambah Staff
            </a>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="stats">
            <div class="stat-card">
                <p>Total Staff</p>
                <strong>{{ $totalStaff }}</strong>
            </div>
            <div class="stat-card">
                <p>Staff Aktif</p>
                <strong>{{ $activeStaff }}</strong>
            </div>
        </div>

        <form class="search-form" method="GET"
              action="{{ route('admin.users.index') }}">
            <input
                type="text"
                name="search"
                placeholder="Cari nama atau email Staff..."
                value="{{ request('search') }}"
                aria-label="Cari nama atau email Staff"
            >

            <button class="button" type="submit">Cari</button>

            @if (request('search'))
                <a class="reset" href="{{ route('admin.users.index') }}">
                    Reset
                </a>
            @endif
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->is_active)
                                    <span class="status active">Aktif</span>
                                @else
                                    <span class="status inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a class="button"
                                       href="{{ route('admin.users.edit', $user->id) }}">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.users.toggle-active', $user->id) }}"
                                          onsubmit="return confirm('Yakin ingin mengubah status akun Staff ini?')">
                                        @csrf
                                        @method('PATCH')

                                        @if ($user->is_active)
                                            <button class="button button-danger" type="submit">
                                                Nonaktifkan
                                            </button>
                                        @else
                                            <button class="button button-secondary" type="submit">
                                                Aktifkan
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty">
                                    <h3>Belum ada akun Staff</h3>
                                    <p class="muted">
                                        Tambahkan akun pegawai agar mereka dapat
                                        masuk ke sistem Veloura.
                                    </p>
                                    <a class="button"
                                       href="{{ route('admin.users.create') }}">
                                        + Tambah Staff Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </section>
</main>
</body>
</html>
