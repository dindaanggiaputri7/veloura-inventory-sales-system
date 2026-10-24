
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Veloura | Inventory &amp; Sales Management</title>
    <meta name="description" content="Temukan parfum yang mencerminkan karaktermu bersama Veloura.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #faf5f0;
            --ivory: #fffdfb;
            --rose: #f0ddd8;
            --rose-deep: #c77c83;
            --wine: #681d31;
            --wine-dark: #451321;
            --gold: #bd9660;
            --ink: #38242a;
            --muted: #88777b;
            --line: #eadbd5;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        body {
            margin: 0;
            background: var(--ivory);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            display: block;
            max-width: 100%;
        }

        /* ANNOUNCEMENT */
        .announcement {
            padding: 9px 16px;
            background: var(--wine-dark);
            color: #fff2e9;
            text-align: center;
            font-size: 10px;
            letter-spacing: 1.5px;
        }

        /* NAVBAR */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 20;
            min-height: 78px;
            padding: 14px 5.5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            background: rgba(255, 253, 251, .97);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .brand-mark {
            width: 45px;
            height: 45px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: var(--wine);
            color: #fff9f2;
            font: 27px 'Playfair Display', serif;
        }

        .brand-copy strong {
            display: block;
            color: var(--wine);
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .brand-copy small {
            display: block;
            margin-top: 4px;
            color: #987b7d;
            font-size: 8px;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: clamp(12px, 2.5vw, 32px);
            font-size: 12px;
            font-weight: 600;
        }

        .nav-links a {
            transition: color .2s;
        }

        .nav-links a:hover,
        .footer-links a:hover {
            color: var(--rose-deep);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .btn {
            min-height: 42px;
            padding: 0 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid var(--wine);
            border-radius: 7px;
            background: var(--wine);
            color: white;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .btn:hover {
            background: var(--wine-dark);
            border-color: var(--wine-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--wine);
        }

        .btn-outline:hover {
            color: white;
        }

        /* WELCOME HERO */
        .hero {
            min-height: 550px;
            padding: 48px 6%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 5%;
            background: linear-gradient(120deg, #fffdf9, #f3e2da);
        }

        .hero-copy {
            max-width: 590px;
        }

        .eyebrow {
            color: var(--wine);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
        }

        .hero h1 {
            margin: 20px 0;
            color: var(--wine-dark);
            font: 400 clamp(42px, 5vw, 70px)/1.08 'Playfair Display', serif;
        }

        .hero h1 em {
            color: var(--rose-deep);
        }

        .hero-description {
            max-width: 460px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.9;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 11px;
            margin-top: 25px;
        }

        .hero-points {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e4d2c8;
        }

        .hero-point {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #765d60;
            font-size: 10px;
        }

        .point-icon {
            width: 29px;
            height: 29px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #eedbd5;
            color: var(--wine);
            font-size: 14px;
        }

        .hero-art {
            position: relative;
            height: 450px;
            overflow: hidden;
            border: 1px solid #c9a17c;
            border-radius: 48% 48% 10px 10px;
            background: var(--wine-dark);
            box-shadow: 0 20px 45px #693b3220;
        }

        .hero-art img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .art-caption {
            position: absolute;
            bottom: 22px;
            left: 22px;
            padding: 12px 16px;
            background: rgba(255, 250, 240, .93);
            color: var(--wine);
            font: italic 15px 'Playfair Display', serif;
        }

        /* KEUNGGULAN */
        .benefits {
            padding: 25px 6%;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            background: white;
            border-bottom: 1px solid var(--line);
        }

        .benefit {
            text-align: center;
            border-right: 1px solid var(--line);
        }

        .benefit:last-child {
            border-right: 0;
        }

        .benefit strong {
            display: block;
            margin-bottom: 7px;
            color: var(--wine);
            font-size: 11px;
        }

        .benefit span {
            color: var(--muted);
            font-size: 10px;
        }

        /* BAGIAN KONTEN */
        .section {
            padding: 70px 6%;
        }

        .section-heading {
            max-width: 640px;
            margin: 0 auto 35px;
            text-align: center;
        }

        .section-heading h2 {
            margin: 12px 0;
            color: var(--wine-dark);
            font: 400 clamp(30px, 4vw, 43px) 'Playfair Display', serif;
        }

        .section-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        /* SHOP BY COLLECTION: FOTO BUNGA DAN BOTANIKAL */
        .collection-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .collection-card {
            position: relative;
            isolation: isolate;
            min-width: 0;
            min-height: 240px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            overflow: hidden;
            border-radius: 12px;
            background: var(--wine-dark);
            color: white;
        }

        .collection-photo {
            position: absolute;
            inset: 0;
            z-index: -2;
            width: 100%;
            height: 100%;
            max-width: none;
            object-fit: cover;
            object-position: center;
            transition: transform .4s;
        }

        .collection-card:hover .collection-photo {
            transform: scale(1.06);
        }

        .collection-card::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background: linear-gradient(
                180deg,
                rgba(40, 10, 20, .02) 4%,
                rgba(40, 10, 20, .88) 100%
            );
        }

        .collection-number {
            margin: auto 0 12px;
            color: #ffe8d7;
            font-size: 10px;
            letter-spacing: 1.5px;
        }

        .collection-card h3 {
            margin: 0 0 8px;
            color: white;
            font: 400 22px 'Playfair Display', serif;
        }

        .collection-card p {
            margin: 0 0 14px;
            color: #fff0e9;
            font-size: 11px;
            line-height: 1.6;
        }

        .collection-card a {
            width: max-content;
            padding-bottom: 5px;
            border-bottom: 1px solid #f2c9b4;
            color: white;
            font-size: 10px;
        }

        /* KATALOG PRODUK */
        .products-section {
            background: var(--cream);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .product-card {
            min-width: 0;
            overflow: hidden;
            padding: 10px 10px 16px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--ivory);
            transition: transform .25s, box-shadow .25s;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px #4e202015;
        }

        .product-visual {
            position: relative;
            height: 230px;
            overflow: hidden;
            border-radius: 8px;
            background: linear-gradient(155deg, #fbf2e8, #e8d4cc);
        }

        .product-photo {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform .35s;
        }

        .product-card:hover .product-photo {
            transform: scale(1.045);
        }

        .visual-tag {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 6px 9px;
            border-radius: 4px;
            background: rgba(255, 253, 251, .94);
            color: var(--wine);
            font-size: 9px;
            letter-spacing: 1px;
        }

        .product-info {
            padding: 14px 4px 0;
        }

        .product-category {
            color: #a37a67;
            font-size: 9px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .product-info h3 {
            margin: 8px 0;
            color: var(--wine-dark);
            font: 500 18px 'Playfair Display', serif;
        }

        .product-info p {
            min-height: 38px;
            margin: 0 0 14px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .product-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .price {
            color: var(--wine);
            font-size: 12px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .product-arrow {
            display: grid;
            place-items: center;
            flex-shrink: 0;
            width: 34px;
            height: 34px;
            border: 1px solid #d7b8b6;
            border-radius: 50%;
            color: var(--wine);
        }

        .product-arrow:hover {
            background: var(--wine);
            color: white;
        }

        .empty-products {
            grid-column: 1 / -1;
            padding: 35px 20px;
            border: 1px dashed #d9c2b9;
            border-radius: 10px;
            color: var(--muted);
            text-align: center;
            font-size: 12px;
            line-height: 1.9;
        }

        .view-all {
            margin-top: 30px;
            text-align: center;
        }

        /* TENTANG VELOURA */
        .story {
            padding: 65px 6%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 6%;
            background: white;
        }

        .story-art {
            min-height: 330px;
            padding: 25px;
            display: grid;
            place-items: center;
            background: radial-gradient(circle, #8d4556, #35121e);
            border: 1px solid #c8a078;
            color: #f9e8d4;
        }

        .story-inner {
            width: 80%;
            min-height: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #d7b184;
            text-align: center;
        }

        .story-inner span {
            font-size: 9px;
            letter-spacing: 3px;
        }

        .story-inner strong {
            margin-top: 10px;
            font: 400 80px 'Playfair Display', serif;
        }

        .story-inner h3 {
            margin: 5px 0;
            font-size: 18px;
            letter-spacing: 5px;
        }

        .story-inner p {
            color: #e4cba7;
            font-size: 8px;
            letter-spacing: 2px;
        }

        .story-copy h2 {
            margin: 15px 0;
            color: var(--wine-dark);
            font: 400 clamp(32px, 4vw, 46px)/1.2 'Playfair Display', serif;
        }

        .story-copy p {
            color: var(--muted);
            font-size: 12px;
            line-height: 2;
        }

        /* BAGIAN PENUTUP */
        .closing {
            padding: 60px 20px;
            text-align: center;
            background: linear-gradient(130deg, #f6e7df, #ecd3cc);
        }

        .closing h2 {
            margin: 14px 0 10px;
            color: var(--wine);
            font: 400 clamp(29px, 4vw, 41px) 'Playfair Display', serif;
        }

        .closing p {
            margin-bottom: 23px;
            color: #806a6c;
            font-size: 12px;
            line-height: 1.8;
        }

        /* FOOTER */
        footer {
            padding: 30px 5.5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            background: var(--wine-dark);
            color: #fff4e9;
        }

        .footer-brand .brand-mark {
            background: #fff6ec;
            color: var(--wine);
        }

        .footer-brand .brand-copy strong {
            color: #fff7ef;
        }

        .footer-brand .brand-copy small {
            color: #d8bcb8;
        }

        footer p {
            margin: 0;
            color: #d8bcb8;
            font-size: 10px;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 17px;
            font-size: 10px;
        }

        /* RESPONSIVE */
        @media (max-width: 1000px) {
            .navbar {
                flex-wrap: wrap;
            }

            .nav-links {
                gap: 12px;
            }

            .hero {
                gap: 25px;
            }

            .hero-art {
                height: 390px;
            }

            .collection-grid,
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .product-visual {
                height: 220px;
            }
        }

        @media (max-width: 620px) {
            .navbar {
                position: relative;
                gap: 12px;
                padding: 13px 4%;
            }

            .brand-mark {
                width: 39px;
                height: 39px;
                font-size: 23px;
            }

            .brand-copy strong {
                font-size: 15px;
            }

            .brand-copy small {
                font-size: 7px;
            }

            .nav-links {
                order: 3;
                width: 100%;
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 5px;
                font-size: 10px;
            }

            .nav-actions {
                gap: 6px;
            }

            .nav-actions .btn {
                min-height: 36px;
                padding: 0 10px;
                font-size: 10px;
            }

            .hero {
                grid-template-columns: 1fr;
                padding: 32px 5%;
                gap: 25px;
            }

            .hero h1 {
                font-size: 45px;
            }

            .hero-description {
                font-size: 12px;
            }

            .hero-art {
                height: 320px;
                border-radius: 35% 35% 8px 8px;
            }

            .hero-points {
                gap: 10px;
            }

            .benefits {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .benefit {
                padding-bottom: 14px;
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }

            .benefit:last-child {
                padding-bottom: 0;
                border-bottom: 0;
            }

            .section {
                padding: 50px 5%;
            }

            .collection-grid,
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .collection-card {
                min-height: 190px;
                padding: 13px;
            }

            .collection-card h3 {
                font-size: 18px;
            }

            .collection-card p {
                font-size: 10px;
            }

            .product-card {
                padding: 7px 7px 12px;
            }

            .product-visual {
                height: 165px;
            }

            .product-info h3 {
                font-size: 15px;
            }

            .product-info p {
                font-size: 9px;
            }

            .price {
                font-size: 10px;
            }

            .story {
                grid-template-columns: 1fr;
                padding: 35px 5%;
                gap: 25px;
            }

            .story-art {
                min-height: 280px;
            }

            .story-inner {
                min-height: 225px;
            }

            .story-inner strong {
                font-size: 70px;
            }

            .closing {
                padding: 45px 20px;
            }

            footer {
                justify-content: center;
                text-align: center;
            }

            .footer-links {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="announcement">
        ✦ &nbsp; VELOURA — DISCOVER YOUR SIGNATURE SCENT &nbsp; ✦
    </div>

    <!-- NAVBAR -->
    <header class="navbar">
        <a href="{{ route('home') }}" class="brand" aria-label="Veloura beranda">
            <span class="brand-mark">V</span>
            <span class="brand-copy">
                <strong>VELOURA </strong>
                <strong> PARFUM</strong>
                <small>Inventory &amp; Sales Management</small>
            </span>
        </a>

        <nav class="nav-links" aria-label="Navigasi utama">
            <a href="#home">Beranda</a>
            <a href="#collection">Koleksi</a>
            <a href="#featured">Katalog Produk</a>
            <a href="#story">Tentang Kami</a>
        </nav>

        <div class="nav-actions">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                <a href="{{ route('register') }}" class="btn">Daftar</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn">Dashboard ↗</a>
            @endguest
        </div>
    </header>

    <main>
        <!-- WELCOME -->
        <section class="hero" id="home">
            <div class="hero-copy">
                <div class="eyebrow">The Art of Personal Fragrance</div>

                <h1>
                    A scent that<br>
                    <em>becomes you.</em>
                </h1>

                <p class="hero-description">
                    Setiap aroma menyimpan cerita. Temukan parfum yang
                    mencerminkan karaktermu, meninggalkan kesan, dan menjadi
                    bagian dari setiap momen istimewa.
                </p>

                <div class="hero-actions">
                    <a href="#collection" class="btn">Jelajahi Koleksi →</a>
                    <a href="#featured" class="btn btn-outline">Lihat Produk</a>
                </div>

                <div class="hero-points">
                    <div class="hero-point">
                        <span class="point-icon">✧</span>
                        Koleksi pilihan
                    </div>
                    <div class="hero-point">
                        <span class="point-icon">❋</span>
                        Aroma berkarakter
                    </div>
                    <div class="hero-point">
                        <span class="point-icon">♧</span>
                        Pengalaman personal
                    </div>
                </div>
            </div>

            <div class="hero-art">
                <img
                    src="{{ asset('images/veluora.png') }}"
                    alt="Parfum Veloura"
                    onerror="this.onerror=null;this.src='{{ asset('image/veluora.png') }}';"
                >
                <div class="art-caption">More than a fragrance.</div>
            </div>
        </section>

        <!-- KEUNGGULAN -->
        <section class="benefits" aria-label="Keunggulan Veloura">
            <div class="benefit">
                <strong>✦ KOLEKSI PILIHAN</strong>
                <span>Aroma untuk berbagai karakter dan suasana</span>
            </div>
            <div class="benefit">
                <strong>✦ TEMUKAN SIGNATURE-MU</strong>
                <span>Pilih aroma yang terasa paling personal</span>
            </div>
            <div class="benefit">
                <strong>✦ PENGALAMAN BERMAKNA</strong>
                <span>Belanja parfum dengan tampilan yang nyaman</span>
            </div>
        </section>

        <!-- SHOP BY COLLECTION: PNG TANPA BOTOL PARFUM -->
        <section class="section" id="collection">
            <div class="section-heading">
                <div class="eyebrow">Explore Veloura</div>
                <h2>Shop by Collection</h2>
                <p>Pilih suasana aroma yang paling menggambarkan dirimu.</p>
            </div>

            <div class="collection-grid">
                <article class="collection-card">
                    <img
                        class="collection-photo"
                        src="{{ asset('images/veloura-midnight-rose.png') }}"
                        alt="Bunga mawar merah burgundy"
                        onerror="this.onerror=null;this.style.display='none';"
                    >
                    <span class="collection-number">01 / FLORAL</span>
                    <h3>Midnight Rose</h3>
                    <p>Lembut, romantis, dan anggun.</p>
                    <a href="#featured">Jelajahi koleksi ↗</a>
                </article>

                <article class="collection-card">
                    <img
                        class="collection-photo"
                        src="{{ asset('images/veloura-bloom.png') }}"
                        alt="Bunga pastel merah muda dan putih"
                        onerror="this.onerror=null;this.style.display='none';"
                    >
                    <span class="collection-number">02 / BLOOM</span>
                    <h3>Bloom</h3>
                    <p>Floral lembut dan feminin.</p>
                    <a href="#featured">Jelajahi koleksi ↗</a>
                </article>

                <article class="collection-card">
                    <img
                        class="collection-photo"
                        src="{{ asset('images/veloura-oud-essence.png') }}"
                        alt="Kayu oud dan rempah hangat"
                        onerror="this.onerror=null;this.style.display='none';"
                    >
                    <span class="collection-number">03 / WOODY</span>
                    <h3>Oud Essence</h3>
                    <p>Hangat, dewasa, dan berkarakter.</p>
                    <a href="#featured">Jelajahi koleksi ↗</a>
                </article>

                <article class="collection-card">
                    <img
                        class="collection-photo"
                        src="{{ asset('images/veloura-pure-mist.png') }}"
                        alt="Daun hijau, bunga putih, dan citrus"
                        onerror="this.onerror=null;this.style.display='none';"
                    >
                    <span class="collection-number">04 / FRESH</span>
                    <h3>Pure Mist</h3>
                    <p>Segar, ringan, dan menyenangkan.</p>
                    <a href="#featured">Jelajahi koleksi ↗</a>
                </article>
            </div>
        </section>

        <!-- KATALOG PRODUK: JPG KHUSUS KATALOG -->
        <section class="section products-section" id="featured">
            <div class="section-heading">
                <div class="eyebrow">The Veloura Edit</div>
                <h2>Katalog Produk</h2>
                <p>
                    Temukan parfum favoritmu dari koleksi Veloura.
                    Pilih produk untuk melihat detailnya.
                </p>
            </div>

            <div class="product-grid">
                @forelse ($products as $product)
                    @php
                        $nama = \Illuminate\Support\Str::lower($product->name);

                        /*
                         * JPG katalog memiliki foto parfum.
                         * Nama file disesuaikan dengan folder public/images/.
                         */
                        $gambarProduk = 'images/veluora.png';

                        if (
                            str_contains($nama, 'midnight') ||
                            str_contains($nama, 'rose')
                        ) {
                            $gambarProduk = 'images/veloura-midnight-rose-katalog.jpg';
                        } elseif (str_contains($nama, 'bloom')) {
                            $gambarProduk = 'images/veloura-bloom-katalog.jpg';
                        } elseif (
                            str_contains($nama, 'oud') ||
                            str_contains($nama, 'essence')
                        ) {
                            $gambarProduk = 'images/veloura-oud-essence-katalog.jpg';
                        } elseif (
                            str_contains($nama, 'pure') ||
                            str_contains($nama, 'mist')
                        ) {
                            $gambarProduk = 'images/veloura-pure-mist-katalog.jpg';
                        }
                    @endphp

                    <article class="product-card">
                        <div class="product-visual">
                            <img
                                class="product-photo"
                                src="{{ asset($gambarProduk) }}"
                                alt="Parfum {{ $product->name }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('images/veluora.png') }}';"
                            >

                            <span class="visual-tag">VELOURA COLLECTION</span>
                        </div>

                        <div class="product-info">
                            <span class="product-category">
                                {{ $product->sku ?? 'Parfum Veloura' }}
                            </span>

                            <h3>{{ $product->name }}</h3>

                            <p>
                                {{ \Illuminate\Support\Str::limit(
                                    $product->description ?: 'Aroma pilihan untuk melengkapi karakter dan momen spesialmu.',
                                    85
                                ) }}
                            </p>

                            <div class="product-bottom">
                                <span class="price">
                                    Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}
                                </span>

                                <a
                                    class="product-arrow"
                                    href="{{ route('products.show', $product->id) }}"
                                    aria-label="Lihat {{ $product->name }}"
                                    title="Lihat detail produk"
                                >↗</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-products">
                        <strong>Koleksi Veloura sedang dipersiapkan.</strong>
                        <br>
                        Produk akan muncul di sini setelah ditambahkan melalui inventaris.
                    </div>
                @endforelse
            </div>

            <div class="view-all">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline">
                        Masuk untuk Menjelajahi Lebih Lanjut →
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-outline">
                        Kunjungi Dashboard →
                    </a>
                @endguest
            </div>
        </section>

        <!-- TENTANG VELOURA -->
        <section class="story" id="story">
            <div class="story-art">
                <div class="story-inner">
                    <span>THE ART OF SCENT</span>
                    <strong>V</strong>
                    <h3>VELOURA</h3>
                    <p>ESSENCE OF TIMELESS ELEGANCE</p>
                </div>
            </div>

            <div class="story-copy">
                <div class="eyebrow">Our Story</div>
                <h2>The art of fine fragrance is our heritage.</h2>
                <p>
                    Veloura hadir sebagai pengalaman wewangian yang personal.
                    Setiap aroma punya karakternya sendiri—ada yang lembut,
                    hangat, segar, maupun berani. Temukan pilihan yang paling
                    sesuai dengan cerita dan gaya kamu.
                </p>
                <a href="#featured" class="btn">Temukan Aroma Pilihan →</a>
            </div>
        </section>

        <!-- BAGIAN PENUTUP -->
        <section class="closing">
            <div class="eyebrow">Your Story, Your Scent</div>
            <h2>Make every moment memorable.</h2>
            <p>
                Mulai perjalananmu menemukan aroma yang paling mewakili dirimu.
            </p>

            @guest
                <a href="{{ route('register') }}" class="btn">
                    Buat Akun Veloura →
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn">
                    Kunjungi Dashboard →
                </a>
            @endguest
        </section>
    </main>

    <!-- FOOTER -->
    <footer>
        <a href="{{ route('home') }}" class="brand footer-brand">
            <span class="brand-mark">V</span>
            <span class="brand-copy">
                <strong>VELOURA PARFUM</strong>
                <small>Inventory &amp; Sales Management</small>
            </span>
        </a>

        <p>© {{ date('Y') }} Veloura. A scent that becomes you.</p>

        <nav class="footer-links" aria-label="Navigasi footer">
            <a href="#home">Beranda</a>
            <a href="#collection">Koleksi</a>
            <a href="#story">Tentang Kami</a>

            @guest
                <a href="{{ route('register') }}">Daftar</a>
            @endguest
        </nav>
    </footer>
</body>
</html>

