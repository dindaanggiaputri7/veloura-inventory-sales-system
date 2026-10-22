
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff | Veloura</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: #f8f4ef;
            color: #392b2d;
        }
        .sidebar {
            position: fixed;
            width: 245px;
            height: 100vh;
            background: #54252f;
            color: white;
            padding: 30px 20px;
        }
        .brand { font-size: 25px; font-weight: bold; letter-spacing: 2px; }
        .subtitle { font-size: 12px; color: #e4c8c7; margin: 8px 0 35px; }
        .nav-title { font-size: 11px; color: #d5b4b5; margin: 20px 10px 12px; }
        .nav-link {
            display: block;
            color: #f8eaea;
            text-decoration: none;
            padding: 13px 12px;
            margin-bottom: 7px;
            border-radius: 8px;
            font-size: 14px;
        }
        .nav-link.active, .nav-link:hover { background: #75414a; }
        .main { margin-left: 245px; padding: 32px; }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        .topbar h1 { font-size: 25px; margin-bottom: 7px; }
        .muted { color: #88797a; font-size: 13px; }
        .user { font-size: 13px; text-align: right; }
        .banner {
            background: linear-gradient(120deg, #54252f, #86515a);
            color: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 28px;
        }
        .banner h2 { font-size: 24px; margin-bottom: 12px; }
        .banner p { font-size: 14px; line-height: 1.7; color: #f4e5e3; }
        .section-title { font-size: 18px; margin-bottom: 16px; }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }
        .stat, .panel, .menu-card {
            background: white;
            border: 1px solid #eee4df;
            border-radius: 13px;
            padding: 22px;
        }
        .stat-label { color: #88797a; font-size: 13px; margin-bottom: 13px; }
        .stat-value { font-size: 27px; font-weight: bold; color: #54252f; }
        .stat-note { color: #9a7779; font-size: 12px; margin-top: 8px; }
        .menus {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        .menu-card h3 { font-size: 16px; margin-bottom: 9px; }
        .menu-card p { color: #88797a; font-size: 13px; line-height: 1.6; }
        .menu-icon {
            display: inline-flex;
            background: #f5e9e7;
            color: #54252f;
            border-radius: 9px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .panel { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { text-align: left; padding: 14px 10px; border-bottom: 1px solid #eee4df; }
        th { color: #88797a; font-weight: 600; }
        .badge {
            display: inline-block;
            background: #f7ead7;
            color: #875b24;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
        }
        .logout {
            width: 100%;
            margin-top: 30px;
            padding: 12px;
            background: transparent;
            border: 1px solid #a87880;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }
        @media (max-width: 900px) {
            .sidebar { width: 190px; }
            .main { margin-left: 190px; padding: 22px; }
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 600px) {
            .sidebar { position: static; width: 100%; height: auto; }
            .main { margin-left: 0; padding: 18px; }
            .stats, .menus { grid-template-columns: 1fr; }
            .topbar { align-items: flex-start; flex-direction: column; }
            .user { text-align: left; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand">VELOURA</div>
        <div class="subtitle">Inventory & Sales Management</div>

        <div class="nav-title">MENU UTAMA</div>
        <a href="{{ route('staff.dashboard') }}" class="nav-link active">Dashboard</a>
        <a href="#stok" class="nav-link">Informasi Stok</a>
        <a href="#transaksi" class="nav-link">Transaksi</a>

        <div class="nav-title">AKUN</div>
        <a href="{{ route('profile.edit') }}" class="nav-link">Profil Saya</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout" type="submit">Keluar dari Akun</button>
        </form>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h1>Dashboard Staff</h1>
                <p class="muted">Pantau stok dan aktivitas operasional Veloura.</p>
            </div>
            <div class="user">
                <strong>{{ auth()->user()->name }}</strong>
                <p class="muted">Staff Operasional</p>
            </div>
        </header>

        <section class="banner">
            <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
            <p>
                Kelola aktivitas operasional dengan teliti. Pantau ketersediaan
                produk dan transaksi agar proses penjualan berjalan lancar.
            </p>
        </section>

        <h2 class="section-title">Ringkasan Operasional</h2>
        <section class="stats">
            <div class="stat">
                <p class="stat-label">Total Produk</p>
                <p class="stat-value">{{ number_format($totalProducts) }}</p>
                <p class="stat-note">Produk terdaftar</p>
            </div>
            <div class="stat">
                <p class="stat-label">Stok Menipis</p>
                <p class="stat-value">{{ number_format($lowStockProducts) }}</p>
                <p class="stat-note">Perlu diperiksa</p>
            </div>
            <div class="stat">
                <p class="stat-label">Kategori</p>
                <p class="stat-value">{{ number_format($totalCategories) }}</p>
                <p class="stat-note">Kategori produk</p>
            </div>
            <div class="stat">
                <p class="stat-label">Supplier</p>
                <p class="stat-value">{{ number_format($totalSuppliers) }}</p>
                <p class="stat-note">Supplier terdaftar</p>
            </div>
            <div class="stat">
                <p class="stat-label">Transaksi Pembelian</p>
                <p class="stat-value">{{ number_format($totalPurchases) }}</p>
                <p class="stat-note">Total pembelian tercatat</p>
            </div>
            <div class="stat">
                <p class="stat-label">Transaksi Penjualan</p>
                <p class="stat-value">{{ number_format($totalSales) }}</p>
                <p class="stat-note">Total penjualan tercatat</p>
            </div>
        </section>

        <h2 class="section-title">Menu Operasional</h2>
        <section class="menus">
            <div class="menu-card" id="stok">
                <div class="menu-icon">STOK</div>
                <h3>Informasi Stok Produk</h3>
                <p>Pantau jumlah produk dan identifikasi barang yang stoknya menipis.</p>
            </div>
            <div class="menu-card" id="transaksi">
                <div class="menu-icon">TRX</div>
                <h3>Pengelolaan Transaksi</h3>
                <p>Area ringkasan untuk aktivitas pembelian dan penjualan.</p>
            </div>
        </section>

        <h2 class="section-title">Informasi Stok Menipis</h2>
        <section class="panel">
            @php
                $lowStockList = \App\Models\Product::whereColumn(
                    'stock', '<=', 'minimum_stock'
                )->orderBy('stock')->limit(5)->get();
            @endphp

            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Stok Tersedia</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowStockList as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td><span class="badge">Perlu diperiksa</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Belum ada produk dengan stok menipis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
