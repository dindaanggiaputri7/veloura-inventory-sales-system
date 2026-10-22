
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Veloura Parfum — A Scent That Becomes You</title>
    <meta name="description" content="Temukan aroma yang mencerminkan dirimu bersama Veloura Parfum.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

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

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            color: var(--espresso);
            background: var(--white);
            font-family: 'DM Sans', sans-serif;
        }

        a { color: inherit; text-decoration: none; }

        button, input { font: inherit; }

        .announcement {
            padding: 10px 16px;
            text-align: center;
            color: var(--ivory);
            background: var(--burgundy);
            font-size: 11px;
            letter-spacing: 1.5px;
        }

        .navbar {
            min-height: 84px;
            padding: 0 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            background: var(--white);
            border-bottom: 1px solid var(--line);
        }

        .brand {
            color: var(--burgundy);
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            letter-spacing: 3px;
        }

        .brand small {
            display: block;
            margin-top: 2px;
            text-align: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 9px;
            letter-spacing: 4px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
            font-size: 12px;
        }

        .nav-links a:hover { color: var(--burgundy); }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 43px;
            padding: 0 20px;
            border: 1px solid var(--burgundy);
            background: var(--burgundy);
            color: white;
            font-size: 12px;
            letter-spacing: .4px;
            cursor: pointer;
            transition: .2s ease;
        }

        .btn:hover {
            background: #741F33;
            border-color: #741F33;
            transform: translateY(-1px);
        }

        .btn-outline {
            color: var(--burgundy);
            background: transparent;
        }

        .btn-outline:hover { color: white; }

        .hero {
            min-height: 590px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: var(--ivory);
        }

        .hero-copy {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 70px 10% 70px 15%;
        }

        .eyebrow {
            color: var(--burgundy);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        h1, h2, h3, p { margin-top: 0; }

        .hero h1 {
            margin: 24px 0 18px;
            color: var(--burgundy);
            font-family: 'Playfair Display', serif;
            font-size: clamp(42px, 5vw, 68px);
            font-weight: 500;
            line-height: 1.12;
        }

        .hero-copy p {
            max-width: 410px;
            margin-bottom: 28px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
        }

        .hero-image {
            min-height: 480px;
            position: relative;
            overflow: hidden;
            background: #D9B9AD;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            min-height: 590px;
            position: absolute;
            inset: 0;
            object-fit: cover;
        }

        .hero-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(52,36,33,.16), transparent 55%);
            pointer-events: none;
        }

        .hero-note {
            position: absolute;
            z-index: 1;
            right: 28px;
            bottom: 28px;
            padding: 15px 20px;
            color: var(--espresso);
            background: rgba(255,252,249,.92);
            font-family: 'Playfair Display', serif;
            font-size: 17px;
        }

        .benefits {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            padding: 24px 7%;
            border-bottom: 1px solid var(--line);
            gap: 20px;
        }

        .benefit {
            text-align: center;
            font-size: 11px;
            letter-spacing: .6px;
        }

        .benefit strong {
            display: block;
            margin-bottom: 6px;
            color: var(--burgundy);
            font-size: 12px;
        }

        .section {
            padding: 85px 7%;
        }

        .section-heading {
            margin-bottom: 38px;
            text-align: center;
        }

        .section-heading h2 {
            margin: 13px 0;
            color: var(--burgundy);
            font-family: 'Playfair Display', serif;
            font-size: clamp(30px, 4vw, 42px);
            font-weight: 500;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
        }

        .product-card { min-width: 0; }

        .product-image {
            position: relative;
            aspect-ratio: 4 / 5;
            overflow: hidden;
            background: var(--ivory);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.04);
        }

        .product-tag {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 7px 10px;
            color: var(--burgundy);
            background: var(--white);
            font-size: 9px;
            letter-spacing: 1px;
        }

        .product-info { padding: 17px 2px; }

        .product-info h3 {
            margin-bottom: 8px;
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 500;
        }

        .product-info p {
            margin-bottom: 10px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .price {
            color: var(--burgundy);
            font-size: 13px;
            font-weight: 700;
        }

        .product-action {
            width: 100%;
            margin-top: 14px;
        }

        .empty-products {
            grid-column: 1 / -1;
            padding: 45px 20px;
            text-align: center;
            background: var(--ivory);
            color: var(--muted);
            font-size: 13px;
            line-height: 1.9;
        }

        .story {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: var(--ivory);
        }

        .story-image {
            min-height: 400px;
            background:
                linear-gradient(rgba(52,36,33,.08), rgba(52,36,33,.08)),
                url('https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=1200&q=85')
                center / cover;
        }

        .story-copy {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 65px 12%;
        }

        .story-copy h2 {
            margin: 18px 0;
            color: var(--burgundy);
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 4vw, 46px);
            font-weight: 500;
            line-height: 1.2;
        }

        .story-copy p {
            color: var(--muted);
            font-size: 13px;
            line-height: 2;
        }

        .story-copy .btn { margin-top: 12px; }

        .newsletter {
            padding: 70px 20px;
            text-align: center;
            background: var(--rose);
        }

        .newsletter h2 {
            margin: 12px 0;
            color: var(--burgundy);
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            font-weight: 500;
        }

        .newsletter p {
            color: #705A55;
            font-size: 13px;
            line-height: 1.8;
        }

        footer {
            padding: 38px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            color: var(--ivory);
            background: var(--espresso);
        }

        footer .brand { color: var(--ivory); }

        footer p {
            margin: 0;
            color: #D3C2BA;
            font-size: 11px;
        }

        .footer-links {
            display: flex;
            gap: 18px;
            font-size: 11px;
        }

        @media (max-width: 900px) {
            .navbar { padding: 18px 5%; flex-wrap: wrap; }
            .nav-links { order: 3; width: 100%; justify-content: center; gap: 22px; }
            .hero-copy { padding: 55px 8%; }
            .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .section { padding: 65px 5%; }
        }

        @media (max-width: 600px) {
            .announcement { font-size: 9px; }
            .brand { font-size: 24px; }
            .nav-links { gap: 16px; font-size: 11px; }
            .nav-actions { gap: 7px; }
            .nav-actions .btn { min-height: 37px; padding: 0 11px; font-size: 10px; }
            .hero { grid-template-columns: 1fr; }
            .hero-copy { padding: 55px 8%; }
            .hero-image, .hero-image img { min-height: 350px; }
            .benefits { grid-template-columns: 1fr; gap: 22px; }
            .product-grid { gap: 15px; }
            .product-info h3 { font-size: 16px; }
            .story { grid-template-columns: 1fr; }
            .story-image { min-height: 300px; }
            .story-copy { padding: 45px 8%; }
            .newsletter h2 { font-size: 28px; }
            footer { justify-content: center; text-align: center; }
            footer .brand { width: 100%; }
        }
    </style>
</head>

<body>
    <div class="announcement">
        DISCOVER YOUR SIGNATURE SCENT &nbsp;·&nbsp; A SCENT THAT BECOMES YOU
    </div>

    <header class="navbar">
        <a href="{{ route('home') }}" class="brand">
            VELOURA
            <small>PARFUM</small>
        </a>

        <nav class="nav-links" aria-label="Navigasi utama">
            <a href="#home">Beranda</a>
            <a href="#collection">Koleksi</a>
            <a href="#story">Tentang Kami</a>
        </nav>

        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                <a href="{{ route('register') }}" class="btn">Daftar</a>
            @endauth
        </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="hero-copy">
                <span class="eyebrow">The Art of Personal Fragrance</span>
                <h1>A scent that<br>becomes you.</h1>
                <p>
                    Setiap aroma menyimpan cerita. Temukan wewangian
                    yang mencerminkan karaktermu, meninggalkan kesan,
                    dan menjadi bagian dari setiap momen istimewa.
                </p>
                <a href="#collection" class="btn">Jelajahi Koleksi &nbsp; →</a>
            </div>

            <div class="hero-image">
                <img
                    src="https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=1400&q=90"
                    alt="Botol parfum dengan nuansa elegan"
                >
                <div class="hero-note">Find your own signature.</div>
            </div>
        </section>

        <section class="benefits" aria-label="Keunggulan Veloura">
            <div class="benefit">
                <strong>✦ Curated Fragrances</strong>
                Aroma pilihan untuk setiap karakter
            </div>
            <div class="benefit">
                <strong>✦ Your Personal Signature</strong>
                Temukan wangi yang terasa seperti dirimu
            </div>
            <div class="benefit">
                <strong>✦ A Thoughtful Experience</strong>
                Pengalaman belanja yang lebih personal
            </div>
        </section>

        <section class="section" id="collection">
            <div class="section-heading">
                <span class="eyebrow">The Veloura Collection</span>
                <h2>Find Your Signature</h2>
                <p>Temukan aroma favorit yang sesuai dengan suasana dan kepribadianmu.</p>
            </div>

            <div class="product-grid">
                @php
                    $productImages = [
                        'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=800&q=85',
                        'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=800&q=85',
                        'https://images.unsplash.com/photo-1595425970377-c9703cf48b6d?auto=format&fit=crop&w=800&q=85',
                        'https://images.unsplash.com/photo-1547887538-e3a2f32cb1cc?auto=format&fit=crop&w=800&q=85',
                    ];
                @endphp

                @forelse ($products as $index => $product)
                    <article class="product-card">
                        <div class="product-image">
                            <img
                                src="{{ $productImages[$index % count($productImages)] }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                            >
                            <span class="product-tag">VELOURA PARFUM</span>
                        </div>

                        <div class="product-info">
                            <h3>{{ $product->name }}</h3>
                            <p>
                                {{ \Illuminate\Support\Str::limit($product->description ?: 'Temukan karakter aroma yang melengkapi gayamu.', 85) }}
                            </p>
                            <div class="price">
                                Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                            </div>

                            @auth
                                @if (auth()->user()->role === 'customer')
                                    <a href="{{ route('customer.dashboard') }}"
                                       class="btn product-action">
                                        Lihat Produk
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}"
                                       class="btn product-action">
                                        Buka Dashboard
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="btn product-action">
                                    Masuk untuk Memesan
                                </a>
                            @endauth
                        </div>
                    </article>
                @empty
                    <div class="empty-products">
                        <strong>Koleksi Veloura sedang dipersiapkan.</strong>
                        <br>
                        Produk akan ditampilkan di sini setelah ditambahkan
                        melalui sistem manajemen produk.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="story" id="story">
            <div class="story-image" role="img" aria-label="Inspirasi parfum dan wewangian"></div>

            <div class="story-copy">
                <span class="eyebrow">More Than A Fragrance</span>
                <h2>Your scent.<br>Your story.</h2>
                <p>
                    Veloura percaya bahwa wewangian adalah bagian dari
                    cara kita mengekspresikan diri. Bukan sekadar aroma,
                    melainkan cerita, kenangan, dan karakter yang melekat
                    pada setiap langkah.
                </p>
                <a href="#collection" class="btn">Temukan Aroma Pilihan</a>
            </div>
        </section>

        <section class="newsletter">
            <span class="eyebrow">Welcome to Veloura</span>
            <h2>Make every moment memorable.</h2>
            <p>
                Mulai perjalananmu menemukan aroma yang paling mewakili dirimu.
            </p>

            @guest
                <a href="{{ route('register') }}" class="btn">Bergabung dengan Veloura</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn">Kunjungi Dashboard</a>
            @endguest
        </section>
    </main>

    <footer>
        <a href="{{ route('home') }}" class="brand">
            VELOURA
            <small>PARFUM</small>
        </a>

        <p>© {{ date('Y') }} Veloura Parfum. A Scent That Becomes You.</p>

        <div class="footer-links">
            <a href="#home">Beranda</a>
            <a href="#collection">Koleksi</a>
            <a href="{{ route('login') }}">Masuk</a>
        </div>
    </footer>
</body>
</html>
