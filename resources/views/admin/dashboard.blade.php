
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Veloura</title>

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
            padding: 22px 5.5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        header h1 { margin: 0; letter-spacing: 2px; }
        header p { margin: 6px 0 0; color: #E8CFC9; }

        main {
            max-width: 1250px;
            margin: 30px auto;
            padding: 0 22px;
        }

        .welcome, .card {
            background: white;
            border: 1px solid #E8CFC9;
            border-radius: 12px;
            padding: 24px;
        }

        h2, h3 { color: #5B1726; }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 16px;
            margin: 22px 0 32px;
        }

        .stat-label { color: #74615C; margin: 0 0 12px; }
        .stat-number { font-size: 30px; font-weight: bold; margin: 0; color: #5B1726; }

        .menus {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }

        .card {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .card p { line-height: 1.5; flex: 1; }

        .button {
            display: inline-block;
            background: #5B1726;
            color: white;
            padding: 11px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: 0;
            cursor: pointer;
            font-size: 14px;
        }

        .button:hover { background: #7A2839; }

        .muted {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 5px;
            background: #F8F1EB;
            color: #5B1726;
            font-size: 12px;
        }

        .logout { background: transparent; border: 1px solid #E8CFC9; }

        footer {
            text-align: center;
            padding: 24px;
            color: #74615C;
        }

        @media (max-width: 600px) {
            header { padding: 20px; }
            main { padding: 0 15px; }
        }
    </style>
</head>
<body>
<header>
    <div>
        <h1>VELOURA</h1>
        <p>Inventory &amp; Sales Management</p>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="button logout" type="submit">Logout</button>
    </form>
</header>

<main>
    <section class="welcome">
        <h2>Dashboard Admin</h2>
        <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
        <p>Kelola data dan aktivitas operasional Veloura Parfum melalui dashboard ini.</p>
    </section>

    <h2>Ringkasan Sistem</h2>

    <section class="stats">
        <div class="card">
            <p class="stat-label">Total Staff</p>
            <p class="stat-number">{{ $totalStaff }}</p>
            <p>Semua akun Staff</p>
        </div>

        <div class="card">
            <p class="stat-label">Staff Aktif</p>
            <p class="stat-number">{{ $activeStaff }}</p>
            <p>Akun yang dapat digunakan</p>
        </div>

        <div class="card">
            <p class="stat-label">Kategori</p>
            <p class="stat-number">{{ $totalCategories }}</p>
            <p>Kategori produk parfum</p>
        </div>

        <div class="card">
            <p class="stat-label">Total Produk</p>
            <p class="stat-number">{{ $totalProducts }}</p>
            <p>Produk terdaftar</p>
        </div>

        <div class="card">
            <p class="stat-label">Stok Menipis</p>
            <p class="stat-number">{{ $lowStockProducts }}</p>
            <p>Produk pada batas stok minimum atau di bawahnya</p>
        </div>

        <div class="card">
            <p class="stat-label">Supplier</p>
            <p class="stat-number">{{ $totalSuppliers }}</p>
            <p>Pemasok terdaftar</p>
        </div>

        <div class="card">
            <p class="stat-label">Pembelian</p>
            <p class="stat-number">{{ $totalPurchases }}</p>
            <p>Total transaksi pembelian</p>
        </div>

        <div class="card">
            <p class="stat-label">Penjualan</p>
            <p class="stat-number">{{ $totalSales }}</p>
            <p>Total transaksi penjualan</p>
        </div>

        <div class="card">
            <p class="stat-label">Nilai Penjualan</p>
            <p class="stat-number" style="font-size: 24px;">
                Rp {{ number_format((float) $totalSalesAmount, 0, ',', '.') }}
            </p>
            <p>Akumulasi nilai transaksi penjualan</p>
        </div>
    </section>

    <h2>Menu Pengelolaan</h2>

    <section class="menus">
        <div class="card">
            <h3>Manajemen Staff</h3>
            <p>Tambah, cari, edit, dan aktifkan atau nonaktifkan akun Staff.</p>
            <a class="button" href="{{ route('admin.users.index') }}">Kelola Staff</a>
        </div>

        <div class="card">
            <h3>Kategori</h3>
            <p>Kelola kategori untuk mengelompokkan produk parfum.</p>
            <span class="muted">Fitur berikutnya</span>
        </div>

        <div class="card">
            <h3>Produk</h3>
            <p>Kelola SKU, nama produk, harga, kategori, dan stok.</p>
            <span class="muted">Fitur berikutnya</span>
        </div>

        <div class="card">
            <h3>Supplier</h3>
            <p>Kelola informasi pemasok produk parfum.</p>
            <span class="muted">Fitur berikutnya</span>
        </div>

        <div class="card">
            <h3>Pembelian</h3>
            <p>Catat pembelian barang dari supplier.</p>
            <span class="muted">Fitur berikutnya</span>
        </div>

        <div class="card">
            <h3>Penjualan</h3>
            <p>Kelola transaksi penjualan dan pantau stok.</p>
            <span class="muted">Fitur berikutnya</span>
        </div>
    </section>
</main>

<footer>&copy; {{ date('Y') }} Veloura Parfum</footer>
</body>
</html>
