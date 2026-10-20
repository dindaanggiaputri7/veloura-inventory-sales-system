
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veloura Parfum | Customer</title>

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
            padding: 22px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        header h1 {
            margin: 0;
            font-size: 25px;
            letter-spacing: 2px;
        }

        header p {
            margin: 6px 0 0;
            color: #E8CFC9;
        }

        main {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            background: white;
            padding: 32px;
            border-radius: 14px;
            border: 1px solid #E8CFC9;
        }

        .welcome h2 {
            color: #5B1726;
            margin-top: 0;
        }

        .button {
            display: inline-block;
            background: #5B1726;
            color: white;
            padding: 12px 20px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-top: 24px;
        }

        .feature {
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #E8CFC9;
        }

        .feature h3 {
            color: #5B1726;
        }

        footer {
            text-align: center;
            padding: 25px;
            color: #74615C;
        }
    </style>
</head>

<body>
    <header>
        <div>
            <h1>VELOURA</h1>
            <p>A Scent That Becomes You.</p>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="button">
                Logout
            </button>
        </form>
    </header>

    <main>
        <section class="welcome">
            <h2>Selamat datang, {{ Auth::user()->name }}!</h2>

            <p>
                Temukan aroma yang mencerminkan kepribadianmu
                bersama Veloura Parfum.
            </p>

            <p>
                Kamu login sebagai Customer.
            </p>
        </section>

        <section class="features">
            <div class="feature">
                <h3>Katalog Parfum</h3>
                <p>Lihat koleksi parfum Veloura yang tersedia.</p>
                <a href="#" class="button">Lihat Katalog</a>
            </div>

            <div class="feature">
                <h3>Keranjang</h3>
                <p>Produk pilihanmu nantinya dapat dikelola di sini.</p>
                <a href="#" class="button">Lihat Keranjang</a>
            </div>

            <div class="feature">
                <h3>Pesanan Saya</h3>
                <p>Pantau pesanan dan status pembayaranmu.</p>
                <a href="#" class="button">Lihat Pesanan</a>
            </div>
        </section>
    </main>

    <footer>
        &copy; {{ date('Y') }} Veloura Parfum. All rights reserved.
    </footer>
</body>
</html>
