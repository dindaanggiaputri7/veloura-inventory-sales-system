
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin | Veloura Parfum</title>

    <style>
        * {
            box-sizing: border-box;
        }

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
            flex-wrap: wrap;
            gap: 15px;
        }

        .brand h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 2px;
        }

        .brand p {
            margin: 8px 0 0;
            color: #E8CFC9;
        }

        .logout-button,
        .menu-button {
            display: inline-block;
            border: none;
            border-radius: 6px;
            padding: 11px 17px;
            background: #5B1726;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .logout-button {
            background: transparent;
            border: 1px solid #E8CFC9;
        }

        main {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 22px;
        }

        .welcome {
            background: white;
            border: 1px solid #E8CFC9;
            border-radius: 12px;
            padding: 30px 25px;
        }

        .welcome h2 {
            margin-top: 0;
            color: #5B1726;
        }

        .welcome p {
            line-height: 1.6;
        }

        .section-title {
            margin: 30px 0 18px;
            color: #5B1726;
        }

        .menus {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(220px, 1fr)
            );
            gap: 18px;
        }

        .menu {
            background: white;
            border: 1px solid #E8CFC9;
            border-radius: 12px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .menu h3 {
            margin-top: 0;
            color: #5B1726;
        }

        .menu p {
            line-height: 1.5;
            flex: 1;
        }

        .menu-button:hover {
            background: #7A2839;
        }

        .coming-soon {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 10px;
            border-radius: 5px;
            background: #F8F1EB;
            color: #5B1726;
            font-size: 12px;
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #74615C;
        }

        @media (max-width: 600px) {
            header {
                padding: 20px;
            }

            main {
                margin-top: 22px;
                padding: 0 15px;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="brand">
            <h1>VELOURA</h1>
            <p>Inventory &amp; Sales Management</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="logout-button">
                Logout
            </button>
        </form>
    </header>

    <main>

        <section class="welcome">
            <h2>Dashboard Admin</h2>

            <p>
                Selamat datang,
                <strong>{{ Auth::user()->name }}</strong>!
            </p>

            <p>
                Kelola data dan aktivitas operasional
                Veloura Parfum melalui dashboard ini.
            </p>
        </section>

        <h2 class="section-title">Menu Pengelolaan</h2>

        <section class="menus">

            <div class="menu">
                <h3>Manajemen Pengguna</h3>

                <p>
                    Lihat akun yang terdaftar dan kelola
                    pengguna Admin maupun Staff.
                </p>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="menu-button"
                >
                    Lihat Pengguna
                </a>
            </div>

            <div class="menu">
                <h3>Kategori</h3>

                <p>
                    Kelola kategori untuk mengelompokkan
                    produk parfum Veloura.
                </p>

                <span class="coming-soon">
                    Fitur berikutnya
                </span>
            </div>

            <div class="menu">
                <h3>Produk</h3>

                <p>
                    Kelola nama produk, SKU, harga,
                    kategori, dan jumlah stok parfum.
                </p>

                <span class="coming-soon">
                    Fitur berikutnya
                </span>
            </div>

            <div class="menu">
                <h3>Supplier</h3>

                <p>
                    Kelola informasi pemasok yang
                    menyediakan produk parfum.
                </p>

                <span class="coming-soon">
                    Fitur berikutnya
                </span>
            </div>

            <div class="menu">
                <h3>Pembelian</h3>

                <p>
                    Catat pembelian barang dan pantau
                    penambahan stok dari supplier.
                </p>

                <span class="coming-soon">
                    Fitur berikutnya
                </span>
            </div>

            <div class="menu">
                <h3>Penjualan</h3>

                <p>
                    Pantau transaksi penjualan dan
                    perubahan stok produk.
                </p>

                <span class="coming-soon">
                    Fitur berikutnya
                </span>
            </div>

        </section>

    </main>

    <footer>
        &copy; {{ date('Y') }} Veloura Parfum.
        All rights reserved.
    </footer>

</body>
</html>
