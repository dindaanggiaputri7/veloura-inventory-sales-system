
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Veloura Parfum</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --ivory: #F8F1EB;
            --rose: #E8CFC9;
            --burgundy: #5B1726;
            --gold: #C5A16A;
            --espresso: #342421;
            --white: #FFFCF9;
            --muted: #84756F;
            --line: #E9DDD5;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--espresso);
            background: var(--white);
            font-family: 'DM Sans', sans-serif;
        }

        a { text-decoration: none; }

        .announcement {
            padding: 11px;
            color: var(--ivory);
            background: var(--burgundy);
            text-align: center;
            font-size: 10px;
            letter-spacing: 2px;
        }

        header {
            min-height: 82px;
            padding: 16px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--line);
        }

        .brand {
            color: var(--burgundy);
            font-family: 'Playfair Display', serif;
            font-size: 27px;
            letter-spacing: 3px;
        }

        .brand small {
            display: block;
            text-align: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 8px;
            letter-spacing: 4px;
        }

        .back {
            color: var(--burgundy);
            font-size: 12px;
        }

        main {
            max-width: 1120px;
            margin: auto;
            padding: 45px 24px 80px;
        }

        .breadcrumb {
            margin-bottom: 30px;
            color: var(--muted);
            font-size: 12px;
        }

        .product {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .photo {
            aspect-ratio: 4 / 5;
            overflow: hidden;
            background: var(--ivory);
        }

        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .eyebrow {
            color: var(--burgundy);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
        }

        h1 {
            margin: 18px 0;
            color: var(--burgundy);
            font-family: 'Playfair Display', serif;
            font-size: clamp(34px, 4vw, 50px);
            font-weight: 500;
        }

        .price {
            margin: 22px 0;
            color: var(--burgundy);
            font-size: 22px;
            font-weight: 700;
        }

        .description {
            color: var(--muted);
            font-size: 14px;
            line-height: 2;
            white-space: pre-line;
        }

        .stock {
            margin: 24px 0;
            font-size: 12px;
        }

        .available { color: #39704B; }
        .unavailable { color: #A42F3D; }

        .btn {
            display: inline-flex;
            min-height: 46px;
            padding: 0 22px;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--burgundy);
            background: var(--burgundy);
            color: white;
            font-size: 12px;
            cursor: pointer;
        }

        .btn:hover { background: #741F33; }

        .btn-outline {
            margin-left: 8px;
            background: transparent;
            color: var(--burgundy);
        }

        .btn-outline:hover { color: white; }

        .note {
            margin-top: 20px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
        }

        footer {
            padding: 28px;
            background: var(--espresso);
            color: var(--ivory);
            text-align: center;
            font-size: 11px;
        }

        @media (max-width: 700px) {
            header { padding: 18px 5%; }
            main { padding: 30px 18px 55px; }
            .product { grid-template-columns: 1fr; gap: 30px; }
            .btn-outline { margin: 10px 0 0; }
        }
    </style>
</head>

<body>
    <div class="announcement">
        A SCENT THAT BECOMES YOU
    </div>

    <header>
        <a href="{{ route('home') }}" class="brand">
            VELOURA
            <small>PARFUM</small>
        </a>

        <a href="{{ route('home') }}#collection" class="back">
            ← Kembali ke koleksi
        </a>
    </header>

    <main>
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            / Koleksi / {{ $product->name }}
        </div>

        <section class="product">
            <div class="photo">
                <img
                    src="https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=1000&q=85"
                    alt="Ilustrasi parfum {{ $product->name }}"
                >
            </div>

            <div>
                <span class="eyebrow">THE VELOURA COLLECTION</span>

                <h1>{{ $product->name }}</h1>

                <div class="price">
                    Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                </div>

                <p class="description">{{ $product->description ?: 'Temukan aroma yang melengkapi karakter dan momen spesialmu.' }}</p>

                <div class="stock {{ $product->stock > 0 ? 'available' : 'unavailable' }}">
                    @if ($product->stock > 0)
                        Tersedia · Stok {{ $product->stock }}
                    @else
                        Stok habis
                    @endif
                </div>

                @if ($product->stock > 0)
                    @auth
                        @if (auth()->user()->role === 'customer')
                            <a href="{{ route('customer.dashboard') }}" class="btn">
                                Lanjut ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn">
                                Buka Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn">
                            Masuk untuk Memesan
                        </a>

                        <a href="{{ route('register') }}" class="btn btn-outline">
                            Daftar
                        </a>
                    @endauth
                @else
                    <span class="btn" style="opacity:.6;cursor:not-allowed">
                        Stok Habis
                    </span>
                @endif

                <p class="note">
                    Veloura Parfum · A Scent That Becomes You.
                    <br>
                    Pemesanan online akan tersedia setelah fitur keranjang dan checkout diaktifkan.
                </p>
            </div>
        </section>
    </main>

    <footer>
        © {{ date('Y') }} Veloura Parfum. A Scent That Becomes You.
    </footer>
</body>
</html>
