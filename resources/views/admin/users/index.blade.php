
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna | Veloura</title>

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
            padding: 22px 7%;
        }

        header h1 { margin: 0; letter-spacing: 2px; }

        main {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .panel {
            background: white;
            border: 1px solid #E8CFC9;
            border-radius: 12px;
            padding: 24px;
        }

        h2 { color: #5B1726; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            text-align: left;
            padding: 13px 10px;
            border-bottom: 1px solid #E8CFC9;
        }

        th { color: #5B1726; }

        .role {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            background: #F8F1EB;
            color: #5B1726;
        }

        a { color: #5B1726; }

        .back {
            display: inline-block;
            margin-bottom: 18px;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 650px) {
            .panel { overflow-x: auto; }
            table { min-width: 550px; }
        }
    </style>
</head>
<body>
    <header>
        <h1>VELOURA</h1>
        <p>Manajemen Pengguna</p>
    </header>

    <main>
        <a class="back" href="{{ route('admin.dashboard') }}">
            &larr; Kembali ke Dashboard
        </a>

        <section class="panel">
            
        <h2>Daftar Pengguna</h2>
        <p>Kelola dan pantau akun yang terdaftar di Veloura.</p>

        <form method="GET" action="{{ route('admin.users.index') }}"
            style="display:flex; flex-wrap:wrap; gap:10px; margin-top:20px;">

        <input
            type="text"
            name="search"
            placeholder="Cari nama atau email..."
            value="{{ request('search') }}"
            style="padding:10px; border:1px solid #E8CFC9; border-radius:6px; flex:1; min-width:180px;"
        >

        <select
            name="role"
            style="padding:10px; border:1px solid #E8CFC9; border-radius:6px;"
        >
            <option value="">Semua Role</option>
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
            <option value="staff" @selected(request('role') === 'staff')>Staff</option>
            <option value="customer" @selected(request('role') === 'customer')>Customer</option>
        </select>

        <button
            type="submit"
            style="padding:10px 16px; background:#5B1726; color:white; border:0; border-radius:6px; cursor:pointer;"
        >
            Cari
        </button>

        <a href="{{ route('admin.users.index') }}"
            style="padding:10px; color:#5B1726;">
            Reset
        </a>
    </form>

            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination">
                {{ $users->links() }}
            </div>
        </section>
    </main>
</body>
</html>
