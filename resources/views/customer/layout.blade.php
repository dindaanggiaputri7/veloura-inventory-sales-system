<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Customer') | Veloura</title>
    <style>
        :root {
            --wine: #652a39;
            --wine-dark: #4d1e2a;
            --wine-soft: #824957;
            --cream: #f8f3ee;
            --paper: #fff;
            --text: #35272b;
            --muted: #95848a;
            --border: #eee3de;
            --rose: #f5e7e7;
            --gold: #c5a16a;
            --shadow: 0 5px 20px rgba(68, 33, 42, .045);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            min-height: 100vh;
            background: var(--cream);
            color: var(--text);
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        button, input, select, textarea { font: inherit; }
        button, a { -webkit-tap-highlight-color: transparent; }

        /* Sidebar customer memakai identitas visual yang sama dengan Admin/Staff. */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            width: 250px;
            padding: 25px 16px 18px;
            overflow-y: auto;
            color: #fff;
            background: linear-gradient(180deg, #602635 0%, #4e202b 100%);
            scrollbar-width: thin;
            scrollbar-color: #87515d transparent;
        }
        .brand { display: flex; align-items: center; gap: 11px; padding: 0 5px; }
        .brand-symbol {
            display: grid;
            flex: 0 0 42px;
            width: 42px;
            height: 42px;
            place-items: center;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 12px;
            background: rgba(255,255,255,.09);
            font-family: Georgia, serif;
            font-size: 25px;
            font-weight: 700;
        }
        .brand-name { font-size: 21px; font-weight: 800; letter-spacing: 2.5px; }
        .brand-caption { margin-top: 5px; color: #e6c9cd; font-size: 9px; letter-spacing: 1px; line-height: 1.5; }
        .nav-section { margin-top: 32px; }
        .nav-title { padding: 0 12px; margin-bottom: 10px; color: #d7b5bd; font-size: 9px; font-weight: 700; letter-spacing: 1.6px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 41px;
            padding: 10px 12px;
            margin: 4px 0;
            border: 1px solid transparent;
            border-radius: 9px;
            color: #f8e9eb;
            font-size: 12px;
            font-weight: 500;
            transition: background .18s, color .18s, transform .18s;
        }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,.09); transform: translateX(2px); }
        .nav-link.active { color: #fff; background: #824653; border-color: rgba(255,255,255,.08); box-shadow: inset 3px 0 #f0d0d3; }
        .nav-icon { display: inline-grid; flex: 0 0 19px; width: 19px; height: 19px; place-items: center; color: #e8c8ce; }
        .nav-icon svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
        .nav-link.active .nav-icon { color: #fff; }
        .sidebar-bottom { margin-top: auto; padding-top: 24px; }
        .account-card { display: flex; align-items: center; gap: 10px; padding: 12px 10px; margin-bottom: 12px; border: 1px solid rgba(255,255,255,.15); border-radius: 11px; background: rgba(255,255,255,.055); }
        .avatar { display: grid; flex: 0 0 34px; width: 34px; height: 34px; place-items: center; border-radius: 10px; color: var(--wine); background: #f4e2e3; font-weight: 800; }
        .account-name { overflow: hidden; font-size: 11px; font-weight: 700; text-overflow: ellipsis; white-space: nowrap; }
        .account-role { margin-top: 4px; color: #dfbec4; font-size: 10px; }
        .logout { width: 100%; padding: 11px; border: 1px solid rgba(255,255,255,.25); border-radius: 9px; color: #fff; background: transparent; cursor: pointer; font-size: 12px; transition: background .2s; }
        .logout:hover { background: rgba(255,255,255,.1); }
        .sidebar-overlay { display: none; }

        /* Header dan ruang konten */
        .main { min-height: 100vh; margin-left: 250px; padding: 25px 30px 35px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 25px; }
        .page-heading { margin: 0 0 6px; font-size: 24px; font-weight: 750; letter-spacing: -.5px; }
        .page-description { margin: 0; color: var(--muted); font-size: 12px; line-height: 1.6; }
        .topbar-user { display: flex; align-items: center; gap: 10px; padding: 8px 11px; border: 1px solid var(--border); border-radius: 12px; background: rgba(255,255,255,.8); }
        .topbar-user .avatar { width: 36px; height: 36px; }
        .topbar-user-name { font-size: 12px; font-weight: 750; }
        .role-label { margin-top: 3px; color: var(--muted); font-size: 10px; text-transform: capitalize; }
        .mobile-menu { display: none; width: 40px; height: 40px; border: 1px solid var(--border); border-radius: 10px; color: var(--wine); background: #fff; cursor: pointer; }
        .page-content { min-width: 0; max-width: 1440px; margin: 0 auto; }

        /* Komponen yang dipakai halaman-halaman Customer */
        .welcome { position: relative; display: flex; min-height: 205px; overflow: hidden; border: 1px solid #e7c8bd; border-radius: 16px; background: linear-gradient(105deg,#f0d8d0,#f9ece4); }
        .welcome-copy { z-index: 1; max-width: 66%; padding: 30px; }
        .eyebrow { color: var(--wine); font-size: 10px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
        .welcome h1 { margin: 10px 0; color: #35272b; font-family: Georgia,serif; font-size: 32px; font-weight: 500; line-height: 1.18; }
        .welcome p { max-width: 510px; color: #6e514b; font-size: 13px; line-height: 1.7; }
        .welcome-art { position: absolute; top: 0; right: 0; width: 39%; height: 100%; object-fit: cover; object-position: center; }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 36px; padding: 10px 15px; border: 1px solid transparent; border-radius: 9px; background: var(--wine); color: #fff; font-size: 12px; font-weight: 700; cursor: pointer; transition: background .2s, transform .2s; }
        .btn:hover { background: var(--wine-soft); }
        .btn-light { border-color: #d9b5ac; background: #fffaf6; color: var(--wine); }
        .btn-light:hover { background: #f4e6e4; }
        .btn-sm { min-height: 30px; padding: 7px 10px; font-size: 11px; }
        .section-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin: 27px 0 14px; }
        .section-head h2 { margin: 0; color: #35272b; font-family: Georgia,serif; font-size: 23px; font-weight: 500; }
        .muted { color: var(--muted); font-size: 12px; line-height: 1.6; }
        .stats { display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 14px; margin: 20px 0; }
        .stat,.panel,.category,.product-card { min-width: 0; border: 1px solid var(--border); border-radius: 13px; background: var(--paper); box-shadow: 0 3px 12px rgba(66,35,42,.02); }
        .stat { padding: 18px; }
        .stat .label { color: var(--muted); font-size: 12px; }
        .stat .number { margin-top: 7px; color: var(--wine); font-family: Georgia,serif; font-size: 27px; }
        .categories { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 13px; }
        .category { overflow: hidden; transition: transform .2s,box-shadow .2s; }
        .category:hover,.product-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(91,23,38,.08); }
        .category img { display: block; width: 100%; height: 112px; object-fit: cover; background: #f1e1d9; }
        .category strong { display: block; padding: 12px 13px; color: var(--wine); font-size: 12px; }
        .products { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 14px; }
        .product-card { overflow: hidden; transition: transform .2s,box-shadow .2s; }
        .product-card img { display: block; width: 100%; height: 175px; object-fit: cover; background: #f1e1d9; }
        .product-info { padding: 14px; }
        .product-info h3 { margin: 9px 0 5px; color: var(--text); font-size: 14px; }
        .price { color: var(--wine); font-size: 14px; font-weight: 750; }
        .badge { display: inline-block; padding: 5px 9px; border-radius: 20px; background: #f4e3dc; color: var(--wine); font-size: 10px; }
        .panel { padding: 20px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th,td { padding: 13px 10px; border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap; }
        th { background: #fcf5f0; color: var(--muted); font-weight: 700; }
        .form-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 16px; }
        .field { display: flex; flex-direction: column; gap: 7px; font-size: 12px; }
        .field.full { grid-column: 1 / -1; }
        .field input,.field select,.field textarea,.search-input { width: 100%; min-width: 0; padding: 12px; border: 1px solid #e4d5cc; border-radius: 9px; outline-color: var(--gold); background: #fffdfa; }
        .field textarea { min-height: 105px; resize: vertical; }
        .alert { padding: 12px 15px; margin-bottom: 16px; border-radius: 10px; background: #e5f4e8; color: #24643b; font-size: 13px; }
        .alert.error { background: #fae5e3; color: #912d2d; }
        .empty { padding: 38px 20px; color: var(--muted); text-align: center; }
        .empty h3 { color: var(--wine); }
        .product-layout { display: grid; grid-template-columns: minmax(0,1fr) minmax(0,1fr); align-items: center; gap: 28px; }
        .product-hero { display: block; width: 100%; max-height: 490px; border: 1px solid var(--border); border-radius: 14px; object-fit: cover; }
        .pagination { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 18px; }
        .pagination a,.pagination span { padding: 8px 11px; border: 1px solid var(--border); border-radius: 7px; background: #fff; font-size: 12px; }
        .pagination .active { background: var(--wine); color: #fff; }
        .footer-note { margin-top: 28px; color: var(--muted); font-size: 11px; }

        @media (max-width: 1150px) {
            .categories,.products { grid-template-columns: repeat(2,minmax(0,1fr)); }
            .stats { grid-template-columns: repeat(3,minmax(0,1fr)); }
        }
        @media (max-width: 850px) {
            .sidebar { transform: translateX(-100%); transition: transform .22s ease; }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay { position: fixed; inset: 0; z-index: 90; background: rgba(25,12,16,.4); }
            .sidebar-overlay.show { display: block; }
            .main { margin-left: 0; padding: 19px 20px 28px; }
            .mobile-menu { display: grid; flex: 0 0 40px; place-items: center; }
            .topbar { justify-content: flex-start; }
            .topbar-heading { flex: 1; }
        }
        @media (max-width: 650px) {
            .main { padding: 16px 13px 24px; }
            .topbar { align-items: flex-start; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; }
            .page-heading { font-size: 21px; }
            .topbar-user { margin-left: auto; padding: 6px 8px; }
            .topbar-user-info { display: none; }
            .welcome { min-height: 230px; }
            .welcome-copy { max-width: 100%; padding: 23px 20px; }
            .welcome-art { width: 70%; opacity: .18; }
            .welcome h1 { font-size: 26px; }
            .stats { grid-template-columns: 1fr; gap: 10px; }
            .stat { padding: 14px 16px; }
            .categories,.products { grid-template-columns: repeat(2,minmax(0,1fr)); gap: 10px; }
            .category img { height: 100px; }
            .product-card img { height: 145px; }
            .product-layout,.form-grid { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
            .panel { padding: 15px; }
            .section-head { align-items: flex-start; }
            .section-head h2 { font-size: 20px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *,*::before,*::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="customerSidebarOverlay"></div>

    <aside class="sidebar" id="customerSidebar">
        <a href="{{ route('customer.dashboard') }}" class="brand">
            <div class="brand-symbol">V</div>
            <div>
                <div class="brand-name">VELOURA</div>
                <div class="brand-caption">INVENTORY &amp; SALES<br>MANAGEMENT SYSTEM</div>
            </div>
        </a>

        <nav aria-label="Navigasi Customer">
            <div class="nav-section">
                <div class="nav-title">MENU CUSTOMER</div>
                <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="m3 10 9-7 9 7"></path><path d="M5 9v12h14V9M9 21v-7h6v7"></path></svg></span>Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('customer.catalog') || request()->routeIs('customer.products.show') ? 'active' : '' }}" href="{{ route('customer.catalog') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M6 7h12l1 14H5L6 7Z"></path><path d="M9 7V5a3 3 0 0 1 6 0v2"></path></svg></span>Katalog Produk
                </a>
                <a class="nav-link {{ request()->routeIs('customer.cart*') || request()->routeIs('customer.checkout*') ? 'active' : '' }}" href="{{ route('customer.cart') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2 3h2l2.5 12h12L21 7H5"></path></svg></span>Keranjang
                </a>
                <a class="nav-link {{ request()->routeIs('customer.orders*') || request()->routeIs('customer.order.show') ? 'active' : '' }}" href="{{ route('customer.orders') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M8 4h13v17H8z"></path><path d="M4 8v13h13M11 9h7M11 13h7M11 17h5"></path></svg></span>Pesanan Saya
                </a>
                <a class="nav-link {{ request()->routeIs('customer.transactions') ? 'active' : '' }}" href="{{ route('customer.transactions') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path></svg></span>Riwayat Transaksi
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-title">AKUN</div>
                <a class="nav-link {{ request()->routeIs('customer.profile*') ? 'active' : '' }}" href="{{ route('customer.profile') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M4 21a8 8 0 0 1 16 0"></path></svg></span>Profil Saya
                </a>
            </div>
        </nav>

        <div class="sidebar-bottom">
            <div class="account-card">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'C', 0, 1)) }}</div>
                <div style="min-width:0">
                    <div class="account-name">{{ auth()->user()->name ?? 'Customer' }}</div>
                    <div class="account-role">Customer Veloura</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Keluar dari Akun</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <button class="mobile-menu" type="button" id="customerMobileMenu" aria-label="Buka navigasi" aria-expanded="false">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="topbar-heading">
                <h1 class="page-heading">@yield('page-heading', 'Portal Customer')</h1>
                <p class="page-description">@yield('page-description', 'Jelajahi koleksi dan kelola pesananmu di Veloura.')</p>
            </div>
            <div class="topbar-user">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'C', 0, 1)) }}</div>
                <div class="topbar-user-info">
                    <div class="topbar-user-name">{{ auth()->user()->name ?? 'Customer' }}</div>
                    <div class="role-label">Customer Veloura</div>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="alert" role="status">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert error" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert error" role="alert">
                <strong>Periksa kembali data yang kamu masukkan.</strong>
                <ul style="margin:8px 0 0;padding-left:18px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="page-content">
            @yield('content')
        </div>
    </main>

    <script>
        (() => {
            const sidebar = document.getElementById('customerSidebar');
            const overlay = document.getElementById('customerSidebarOverlay');
            const button = document.getElementById('customerMobileMenu');
            if (!sidebar || !overlay || !button) return;

            function setSidebar(open) {
                sidebar.classList.toggle('open', open);
                overlay.classList.toggle('show', open);
                button.setAttribute('aria-expanded', String(open));
            }
            button.addEventListener('click', () => setSidebar(!sidebar.classList.contains('open')));
            overlay.addEventListener('click', () => setSidebar(false));
            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') setSidebar(false);
            });
        })();
    </script>
</body>
</html>
