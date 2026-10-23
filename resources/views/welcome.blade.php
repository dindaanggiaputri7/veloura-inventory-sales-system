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
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    <style>
        :root{--cream:#faf5f0;--ivory:#fffdfb;--rose:#f0ddd8;--rose-deep:#c77c83;--wine:#681d31;--wine-dark:#451321;--gold:#bd9660;--ink:#38242a;--muted:#88777b;--line:#eadbd5;--soft:#f7ece7}
        *{box-sizing:border-box}html{scroll-behavior:smooth;scroll-padding-top:100px}body{margin:0;background:var(--ivory);color:var(--ink);font-family:'DM Sans',sans-serif}a{color:inherit;text-decoration:none}button,input{font:inherit}img{display:block;max-width:100%}
        .announcement{padding:9px 16px;background:var(--wine-dark);color:#fff2e9;text-align:center;font-size:10px;letter-spacing:1.6px;text-transform:uppercase}
        .navbar{position:sticky;top:0;z-index:20;min-height:86px;padding:14px 5.5%;display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:25px;background:rgba(255,253,251,.96);border-bottom:1px solid var(--line);backdrop-filter:blur(14px)}
        .brand{display:inline-flex;align-items:center;gap:12px;width:max-content}.brand-mark{width:48px;height:48px;display:grid;place-items:center;border-radius:15px;background:var(--wine);color:#fff9f2;font-family:'Playfair Display',serif;font-size:28px;box-shadow:0 6px 15px #45132120}.brand-copy strong{display:block;color:var(--wine);font-size:18px;font-weight:800;letter-spacing:2.4px}.brand-copy small{display:block;margin-top:4px;color:#987b7d;font-size:8px;letter-spacing:1.6px;text-transform:uppercase;white-space:nowrap}
        .nav-links{display:flex;align-items:center;justify-content:center;gap:clamp(16px,2.7vw,38px);font-size:12px;font-weight:600}.nav-links a{position:relative;padding:10px 0;transition:color .2s}.nav-links a:hover{color:var(--wine)}.nav-links a:after{position:absolute;bottom:2px;left:0;width:0;height:2px;background:var(--wine);content:'';transition:width .2s}.nav-links a:hover:after{width:100%}
        .nav-actions{display:flex;align-items:center;justify-content:flex-end;gap:9px}.btn{min-height:43px;padding:0 19px;display:inline-flex;align-items:center;justify-content:center;gap:9px;border:1px solid var(--wine);border-radius:6px;background:var(--wine);color:white;font-size:11px;font-weight:700;letter-spacing:.2px;transition:transform .2s,background .2s,box-shadow .2s;cursor:pointer}.btn:hover{background:var(--wine-dark);border-color:var(--wine-dark);box-shadow:0 6px 14px #45132120;transform:translateY(-1px)}.btn-outline{background:transparent;color:var(--wine)}.btn-outline:hover{color:white}.btn-light{background:transparent;border-color:#d5bcb5;color:var(--wine)}.btn-light:hover{background:var(--wine);color:#fff}
        .hero{min-height:590px;padding:44px 5.5%;display:grid;grid-template-columns:minmax(0,.92fr) minmax(0,1.08fr);align-items:center;gap:clamp(30px,5vw,78px);background:radial-gradient(ellipse at 15% 5%,#fffdf9 0,transparent 43%),linear-gradient(115deg,#fbf4ed 0%,#f5e7df 100%);overflow:hidden}.hero-copy{max-width:590px;padding:25px 0}.eyebrow{display:flex;align-items:center;gap:10px;color:var(--wine);font-size:9px;font-weight:700;letter-spacing:3px;text-transform:uppercase}.eyebrow:before{width:25px;height:1px;background:var(--gold);content:''}.hero h1{margin:22px 0 20px;color:var(--wine-dark);font-family:'Playfair Display',serif;font-size:clamp(46px,5.6vw,76px);font-weight:400;line-height:1.05;letter-spacing:-1.9px}.hero h1 em{color:var(--rose-deep);font-weight:400}.hero-description{max-width:465px;color:var(--muted);font-size:13px;line-height:1.95}.hero-actions{display:flex;flex-wrap:wrap;gap:11px;margin-top:27px}.hero-points{display:flex;flex-wrap:wrap;gap:18px;margin-top:34px;padding-top:22px;border-top:1px solid #e4d2c8}.hero-point{display:flex;align-items:center;gap:8px;color:#765d60;font-size:10px}.point-icon{width:28px;height:28px;display:grid;place-items:center;border-radius:50%;background:#eedbd5;color:var(--wine);font-size:13px}
        .hero-art{position:relative;min-height:460px;display:flex;align-items:center;justify-content:center;padding:0;overflow:hidden;border:1px solid #c9a17c;border-radius:48% 48% 9px 9px;background:#4c1726;box-shadow:0 24px 55px #693b3220;isolation:isolate}.hero-art:before{position:absolute;z-index:1;inset:14px;border:1px solid #fff8efb0;border-radius:48% 48% 5px 5px;content:'';pointer-events:none}.hero-art:after{position:absolute;z-index:-1;inset:0;background:linear-gradient(180deg,#2e0b1710,#2e0b1730);content:'';pointer-events:none}.hero-art img{position:absolute;z-index:-2;inset:0;width:100%;height:100%;min-height:100%;object-fit:cover;object-position:center;border-radius:inherit;filter:none}.art-label{position:absolute;z-index:3;right:-15px;top:45px;width:112px;height:112px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:7px;border:1px solid #c5a16a;border-radius:50%;background:#fff9f1e8;color:var(--wine);text-align:center;font-size:8px;line-height:1.6;letter-spacing:1.2px}.art-label strong{font-size:10px;letter-spacing:1.6px}.art-caption{position:absolute;z-index:3;bottom:28px;left:32px;padding:12px 16px;background:#fffaf0e8;color:var(--wine);font-family:'Playfair Display',serif;font-size:15px;font-style:italic;box-shadow:0 5px 16px #44212612}
        .benefits{padding:22px 6%;display:grid;grid-template-columns:repeat(3,1fr);gap:20px;background:#fffdfb;border-bottom:1px solid var(--line)}.benefit{text-align:center;border-right:1px solid var(--line)}.benefit:last-child{border-right:0}.benefit strong{display:block;margin-bottom:6px;color:var(--wine);font-size:11px;letter-spacing:.5px}.benefit span{color:var(--muted);font-size:10px}
        .section{padding:78px 6%}.section-heading{max-width:640px;margin:0 auto 32px;text-align:center}.section-heading .eyebrow{justify-content:center}.section-heading .eyebrow:after{width:25px;height:1px;background:var(--gold);content:''}.section-heading h2{margin:14px 0 10px;color:var(--wine-dark);font-family:'Playfair Display',serif;font-size:clamp(32px,4vw,46px);font-weight:400}.section-heading p{margin:0;color:var(--muted);font-size:12px;line-height:1.8}
        .collection-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}.collection-card{position:relative;min-height:178px;padding:19px;display:flex;flex-direction:column;justify-content:flex-end;overflow:hidden;border-radius:4px;color:#fff7ef;background:linear-gradient(145deg,#7a3244,#3d1424);isolation:isolate}.collection-card:nth-child(2){background:linear-gradient(145deg,#ca928e,#80515a)}.collection-card:nth-child(3){background:linear-gradient(145deg,#735247,#34211f)}.collection-card:nth-child(4){background:linear-gradient(145deg,#c3a17b,#684332)}.collection-card:before{position:absolute;z-index:-1;top:-30px;right:-10px;width:150px;height:150px;border:1px solid #fff6e84a;border-radius:50%;content:''}.collection-card:after{position:absolute;z-index:-1;top:10px;right:14px;width:75px;height:75px;border:1px solid #fff6e84a;border-radius:50%;content:''}.collection-number{margin-bottom:auto;color:#f0d0c0;font-size:9px;letter-spacing:1.5px}.collection-card h3{margin:0 0 7px;font-family:'Playfair Display',serif;font-size:21px;font-weight:400}.collection-card p{margin:0 0 13px;color:#f8e9e0c9;font-size:10px;line-height:1.5}.collection-card a{width:max-content;padding-bottom:4px;border-bottom:1px solid #eac6b1;font-size:9px;font-weight:700;letter-spacing:1px;text-transform:uppercase}
        .products-section{background:#faf4ef}.product-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:17px}.product-card{min-width:0;padding:11px 11px 17px;border:1px solid var(--line);background:#fffdfb;transition:transform .25s,box-shadow .25s}.product-card:hover{transform:translateY(-4px);box-shadow:0 12px 28px #4e20200d}.product-visual{height:180px;position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden;background:linear-gradient(155deg,#fbf2e8,#e8d4cc)}.product-photo{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .35s ease}.product-card:hover .product-photo{transform:scale(1.045)}.product-card:nth-child(4n+2) .product-visual{background:linear-gradient(155deg,#f3e5e0,#d7b4b0)}.product-card:nth-child(4n+3) .product-visual{background:linear-gradient(155deg,#f5ead9,#d9c4a4)}.product-card:nth-child(4n+4) .product-visual{background:linear-gradient(155deg,#ead9d1,#c6a59b)}.bottle{position:relative;width:72px;height:112px;margin-top:22px;border:2px solid #d7b08a;border-radius:13px 13px 17px 17px;background:linear-gradient(90deg,#ffffff8c,#d99a6f70 30%,#fbe7ceaa 65%,#ffffff70);box-shadow:inset -7px 0 9px #a15c3a15,0 10px 14px #613b2b1c}.bottle:before{position:absolute;top:-27px;left:22px;width:25px;height:29px;border:2px solid #c39a63;border-bottom:0;border-radius:5px 5px 0 0;background:linear-gradient(90deg,#eed3a0,#986a37,#f1d9a4);content:''}.bottle:after{position:absolute;top:-43px;left:14px;width:41px;height:18px;border:1px solid #a97b43;border-radius:4px;background:linear-gradient(90deg,#e7c58f,#95662f,#e8c58d);box-shadow:0 2px 2px #5b342633;content:''}.product-card:nth-child(4n+2) .bottle{background:linear-gradient(90deg,#9a263f,#4c0f25 40%,#8b1d32)}.product-card:nth-child(4n+3) .bottle{background:linear-gradient(90deg,#fff9e7,#ddc49b,#fbefd9)}.product-card:nth-child(4n+4) .bottle{background:linear-gradient(90deg,#db9857,#8e4c22,#e7b26e)}.bottle-label{position:absolute;top:43%;left:5px;right:5px;padding:8px 2px;border:1px solid #c7a36d;background:#fff8e7;color:#6a2733;text-align:center;font-family:'Playfair Display',serif;font-size:8px;letter-spacing:.8px}.visual-tag{position:absolute;top:10px;left:10px;padding:6px 8px;background:#fffaf4d9;color:var(--wine);font-size:8px;letter-spacing:1px}.product-info{padding:14px 4px 0}.product-category{color:#a37a67;font-size:8px;letter-spacing:1.4px;text-transform:uppercase}.product-info h3{margin:7px 0;color:var(--wine-dark);font-family:'Playfair Display',serif;font-size:17px;font-weight:500}.product-info p{min-height:35px;margin:0 0 12px;color:var(--muted);font-size:10px;line-height:1.7}.product-bottom{display:flex;align-items:center;justify-content:space-between;gap:8px}.price{color:var(--wine);font-size:11px;font-weight:800;white-space:nowrap}.product-arrow{width:31px;height:31px;display:grid;place-items:center;border:1px solid #d7b8b6;color:var(--wine);font-size:15px}.empty-products{grid-column:1/-1;padding:34px 20px;border:1px dashed #d9c2b9;color:var(--muted);text-align:center;font-size:12px;line-height:1.9}.view-all{text-align:center;margin-top:30px}
        .story{padding:0 6%;display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:clamp(30px,6vw,90px);background:#fffdfb}.story-art{position:relative;min-height:340px;display:grid;place-items:center;overflow:hidden;padding:28px;background:radial-gradient(circle at 50% 40%,#8d4556 0,#5d1d30 42%,#35121e 100%);border:1px solid #c8a078;color:#f9e8d4}.story-art:before,.story-art:after{position:absolute;content:'';border:1px solid #d7b18455;border-radius:50%;aspect-ratio:1}.story-art:before{width:82%;}.story-art:after{width:68%;}.story-inner{position:relative;z-index:1;width:78%;min-height:260px;display:flex;flex-direction:column;align-items:center;justify-content:center;border:1px solid #d7b184a6;text-align:center}.story-inner span{font-size:9px;letter-spacing:3px}.story-inner strong{margin:5px 0 0;font-family:'Playfair Display',serif;font-size:96px;font-weight:400;line-height:1.1}.story-inner h3{margin:0;font-size:18px;letter-spacing:5px}.story-inner p{margin:10px 0 0;color:#e4cba7;font-size:8px;letter-spacing:2px}.story-copy{padding:50px 0}.story-copy h2{margin:17px 0;color:var(--wine-dark);font-family:'Playfair Display',serif;font-size:clamp(34px,4vw,48px);font-weight:400;line-height:1.2}.story-copy p{color:var(--muted);font-size:12px;line-height:2}.story-copy .btn{margin-top:13px}
        .closing{padding:65px 20px;text-align:center;background:linear-gradient(130deg,#f6e7df,#ecd3cc)}.closing .eyebrow{justify-content:center}.closing .eyebrow:after{width:25px;height:1px;background:var(--gold);content:''}.closing h2{margin:14px 0 10px;color:var(--wine);font-family:'Playfair Display',serif;font-size:clamp(29px,4vw,41px);font-weight:400}.closing p{margin-bottom:23px;color:#806a6c;font-size:12px;line-height:1.8}
        footer{padding:30px 5.5%;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;background:var(--wine-dark);color:#fff4e9}.footer-brand .brand-mark{background:#fff6ec;color:var(--wine);box-shadow:none}.footer-brand .brand-copy strong{color:#fff7ef}.footer-brand .brand-copy small{color:#d8bcb8}footer p{margin:0;color:#d8bcb8;font-size:10px;line-height:1.8}.footer-links{display:flex;gap:17px;font-size:10px}.footer-links a:hover{color:#e8c18c}
        @media(max-width:1000px){.navbar{grid-template-columns:1fr auto}.nav-links{grid-column:1/-1;grid-row:2;order:3;padding:0 0 8px}.hero{gap:30px;padding-inline:4%}.hero-art{min-height:400px}.hero-art img{height:340px}.collection-grid,.product-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.collection-card{min-height:165px}.story{gap:30px}}
        @media(max-width:620px){.announcement{font-size:8px;letter-spacing:1px}.navbar{position:relative;grid-template-columns:1fr auto;padding:13px 4%;gap:12px}.brand-mark{width:41px;height:41px;font-size:23px;border-radius:12px}.brand-copy strong{font-size:15px;letter-spacing:1.8px}.brand-copy small{font-size:7px;letter-spacing:1px}.nav-actions{gap:6px}.nav-actions .btn{min-height:37px;padding:0 10px;font-size:10px}.nav-links{gap:17px;font-size:10px;overflow-x:auto;justify-content:flex-start}.hero{grid-template-columns:1fr;padding:32px 5% 38px;gap:22px}.hero-copy{padding:12px 0}.hero h1{font-size:clamp(44px,12vw,62px);letter-spacing:-1px}.hero-description{font-size:12px}.hero-points{gap:10px}.hero-point{font-size:9px}.hero-art{min-height:310px;padding:12px;border-radius:44% 44% 8px 8px}.hero-art img{height:100%;width:100%;min-height:100%;object-fit:cover}.art-label{top:24px;right:-5px;width:82px;height:82px;font-size:6px}.art-label strong{font-size:8px}.art-caption{bottom:17px;left:16px;font-size:12px}.benefits{grid-template-columns:1fr;gap:15px;padding:22px 6%}.benefit{padding-bottom:14px;border-right:0;border-bottom:1px solid var(--line)}.benefit:last-child{padding-bottom:0;border-bottom:0}.section{padding:55px 5%}.section-heading{margin-bottom:24px}.collection-grid{grid-template-columns:1fr 1fr;gap:10px}.collection-card{min-height:158px;padding:13px}.collection-card h3{font-size:17px}.collection-card p{font-size:9px}.product-grid{gap:10px}.product-card{padding:7px 7px 12px}.product-visual{height:145px}.bottle{transform:scale(.84)}.product-info h3{font-size:15px}.product-info p{font-size:9px}.price{font-size:10px}.story{grid-template-columns:1fr;padding:0 5%;gap:0}.story-art{margin-top:25px;padding:15px}.story-art{min-height:280px}.story-inner{min-height:225px}.story-inner strong{font-size:78px}.story-copy{padding:36px 0}.closing{padding:48px 20px}footer{justify-content:center;text-align:center;padding:26px 5%}.footer-links{width:100%;justify-content:center;flex-wrap:wrap}}
    </style>
</head>
<body>
    <div class="announcement">✦ &nbsp; VELOURA — DISCOVER YOUR SIGNATURE SCENT &nbsp; ✦</div>

    <header class="navbar">
        <a href="{{ route('home') }}" class="brand" aria-label="Veloura beranda">
            <span class="brand-mark">V</span>
            <span class="brand-copy"><strong>VELOURA</strong><small>Inventory &amp; Sales Management</small></span>
        </a>

        <nav class="nav-links" aria-label="Navigasi utama">
            <a href="#home">Beranda</a>
            <a href="#collection">Koleksi</a>
            <a href="#featured">Produk Unggulan</a>
            <a href="#story">Tentang Kami</a>
        </nav>

        <div class="nav-actions">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                <a href="{{ route('register') }}" class="btn">Daftar</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn">Dashboard <span aria-hidden="true">↗</span></a>
            @endguest
        </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="hero-copy">
                <div class="eyebrow">The Art of Personal Fragrance</div>
                <h1>A scent that<br><em>becomes you.</em></h1>
                <p class="hero-description">Setiap aroma menyimpan cerita. Temukan parfum yang mencerminkan karaktermu, meninggalkan kesan, dan menjadi bagian dari setiap momen istimewa.</p>
                <div class="hero-actions">
                    <a href="#collection" class="btn">Jelajahi Koleksi <span aria-hidden="true">→</span></a>
                    <a href="#featured" class="btn btn-light">Lihat Produk</a>
                </div>
                <div class="hero-points">
                    <div class="hero-point"><span class="point-icon">✧</span> Koleksi pilihan</div>
                    <div class="hero-point"><span class="point-icon">❋</span> Aroma berkarakter</div>
                    <div class="hero-point"><span class="point-icon">♧</span> Pengalaman personal</div>
                </div>
            </div>

            <div class="hero-art">
                <img src="{{ asset('images/veloura-lumiere.jpg') }}" alt="Botol parfum Veloura burgundy dengan bunga merah dan aksen mewah">
                <div class="art-label">DISCOVER<strong>YOUR SIGNATURE</strong>VELOURA</div>
                <div class="art-caption">More than a fragrance.</div>
            </div>
        </section>

        <section class="benefits" aria-label="Keunggulan Veloura">
            <div class="benefit"><strong>✦ KOLEKSI PILIHAN</strong><span>Aroma untuk berbagai karakter dan suasana</span></div>
            <div class="benefit"><strong>✦ TEMUKAN SIGNATURE-MU</strong><span>Pilih aroma yang terasa paling personal</span></div>
            <div class="benefit"><strong>✦ PENGALAMAN BERMAKNA</strong><span>Belanja parfum dengan tampilan yang nyaman</span></div>
        </section>

        <section class="section" id="collection">
            <div class="section-heading">
                <div class="eyebrow">Explore Veloura</div>
                <h2>Shop by Collection</h2>
                <p>Pilih suasana aroma yang paling menggambarkan dirimu.</p>
            </div>
            <div class="collection-grid">
                <article class="collection-card"><span class="collection-number">01 / FLORAL</span><h3>Floral Bouquets</h3><p>Lembut, romantis, dan anggun.</p><a href="#featured">Jelajahi koleksi ↗</a></article>
                <article class="collection-card"><span class="collection-number">02 / WARM</span><h3>Warm &amp; Sensual</h3><p>Hangat, elegan, memikat.</p><a href="#featured">Jelajahi koleksi ↗</a></article>
                <article class="collection-card"><span class="collection-number">03 / FRESH</span><h3>Fresh &amp; Radiant</h3><p>Ringan, bersih, menyegarkan.</p><a href="#featured">Jelajahi koleksi ↗</a></article>
                <article class="collection-card"><span class="collection-number">04 / SIGNATURE</span><h3>Exclusive Collection</h3><p>Unik, berkelas, berkarakter.</p><a href="#featured">Jelajahi koleksi ↗</a></article>
            </div>
        </section>

        <section class="section products-section" id="featured">
            <div class="section-heading">
                <div class="eyebrow">The Veloura Edit</div>
                <h2>Featured Fragrances</h2>
                <p>Temukan pilihan parfum yang tersedia di katalog Veloura.</p>
            </div>
            <div class="product-grid">
                @php $productImages = ['images/veloura-rose-noir.jpg', 'images/veloura-lamour.jpg', 'images/veloura-vanille.jpg', 'images/veloura-amber.jpg']; @endphp
                @forelse ($products as $index => $product)
                    <article class="product-card">
                        <div class="product-visual">
                            <img class="product-photo" src="{{ asset($productImages[$index % count($productImages)]) }}" alt="Parfum {{ $product->name }}" loading="lazy">
                            <span class="visual-tag">EAU DE PARFUM</span>
                        </div>
                        <div class="product-info">
                            <span class="product-category">Veloura Collection</span>
                            <h3>{{ $product->name }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($product->description ?: 'Aroma pilihan untuk melengkapi karakter dan momen spesialmu.', 75) }}</p>
                            <div class="product-bottom">
                                <span class="price">Rp {{ number_format((float) $product->selling_price, 0, ',', '.') }}</span>
                                <a class="product-arrow" href="{{ route('products.show', $product->id) }}" aria-label="Lihat {{ $product->name }}">↗</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-products"><strong>Koleksi Veloura sedang dipersiapkan.</strong><br>Produk akan muncul di sini setelah ditambahkan melalui sistem inventaris.</div>
                @endforelse
            </div>
            <div class="view-all"><a href="{{ route('login') }}" class="btn btn-outline">Masuk untuk Menjelajahi Lebih Lanjut →</a></div>
        </section>

        <section class="story" id="story">
            <div class="story-art" role="img" aria-label="Identitas brand Veloura dalam nuansa burgundy dan champagne gold"><div class="story-inner"><span>THE ART OF SCENT</span><strong>V</strong><h3>VELOURA</h3><p>ESSENCE OF TIMELESS ELEGANCE</p></div></div>
            <div class="story-copy">
                <div class="eyebrow">Our Story</div>
                <h2>The art of fine fragrance is our heritage.</h2>
                <p>Veloura hadir sebagai pengalaman wewangian yang personal. Setiap aroma punya karakternya sendiri—ada yang lembut, hangat, segar, maupun berani. Temukan pilihan yang paling sesuai dengan cerita dan gaya kamu.</p>
                <a href="#featured" class="btn">Temukan Aroma Pilihan →</a>
            </div>
        </section>

        <section class="closing">
            <div class="eyebrow">Your Story, Your Scent</div>
            <h2>Make every moment memorable.</h2>
            <p>Mulai perjalananmu menemukan aroma yang paling mewakili dirimu.</p>
            @guest
                <a href="{{ route('register') }}" class="btn">Buat Akun Veloura →</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn">Kunjungi Dashboard →</a>
            @endguest
        </section>
    </main>

    <footer>
        <a href="{{ route('home') }}" class="brand footer-brand"><span class="brand-mark">V</span><span class="brand-copy"><strong>VELOURA</strong><small>Inventory &amp; Sales Management</small></span></a>
        <p>© {{ date('Y') }} Veloura. A scent that becomes you.</p>
        <nav class="footer-links" aria-label="Navigasi footer"><a href="#home">Beranda</a><a href="#collection">Koleksi</a><a href="#story">Tentang Kami</a>@guest<a href="{{ route('register') }}">Daftar</a>@endguest</nav>
    </footer>
</body>
</html>
