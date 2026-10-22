
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Veloura</title>

    <style>
        :root {
            --wine: #652a39;
            --wine-dark: #4d1e2a;
            --wine-soft: #824957;
            --cream: #f8f3ee;
            --paper: #ffffff;
            --text: #35272b;
            --muted: #95848a;
            --border: #eee3de;
            --rose: #f5e7e7;
            --green: #26764b;
            --red: #a43a42;
            --shadow: 0 5px 20px rgba(68, 33, 42, .045);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--cream);
            color: var(--text);
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
            font: inherit;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        /* SIDEBAR */

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

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 5px;
        }

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

        .brand-name {
            font-size: 21px;
            font-weight: 800;
            letter-spacing: 2.5px;
        }

        .brand-caption {
            margin-top: 5px;
            color: #e6c9cd;
            font-size: 9px;
            letter-spacing: 1px;
            line-height: 1.5;
        }

        .nav-section {
            margin-top: 32px;
        }

        .nav-title {
            padding: 0 12px;
            margin-bottom: 10px;
            color: #d7b5bd;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.6px;
        }

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

        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,.09);
            transform: translateX(2px);
        }

        .nav-link.active {
            color: white;
            background: #824653;
            border-color: rgba(255,255,255,.08);
            box-shadow: inset 3px 0 #f0d0d3;
        }

        .nav-icon {
            display: inline-grid;
            flex: 0 0 19px;
            width: 19px;
            height: 19px;
            place-items: center;
            color: #e8c8ce;
        }

        .nav-icon svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .nav-link.active .nav-icon {
            color: white;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 24px;
        }

        .account-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 10px;
            margin-bottom: 12px;
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 11px;
            background: rgba(255,255,255,.055);
        }

        .avatar {
            display: grid;
            flex: 0 0 34px;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 10px;
            color: var(--wine);
            background: #f4e2e3;
            font-weight: 800;
        }

        .account-name {
            overflow: hidden;
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .account-role {
            margin-top: 4px;
            color: #dfbec4;
            font-size: 10px;
        }

        .logout {
            width: 100%;
            padding: 11px;
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 9px;
            color: #fff;
            background: transparent;
            cursor: pointer;
            font-size: 12px;
            transition: background .2s;
        }

        .logout:hover {
            background: rgba(255,255,255,.1);
        }

        /* MAIN CONTENT */

        .main {
            min-height: 100vh;
            margin-left: 250px;
            padding: 25px 30px 35px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 25px;
        }

        .page-heading {
            margin: 0 0 6px;
            font-size: 24px;
            font-weight: 750;
            letter-spacing: -.5px;
        }

        .muted {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 11px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: rgba(255,255,255,.8);
        }

        .topbar-user .avatar {
            width: 36px;
            height: 36px;
        }

        .topbar-user-name {
            font-size: 12px;
            font-weight: 750;
        }

        .role-label {
            margin-top: 3px;
            color: var(--muted);
            font-size: 10px;
            text-transform: capitalize;
        }

        .mobile-menu {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--wine);
            background: white;
            cursor: pointer;
        }

        .page-content {
            min-width: 0;
        }

        /* GENERAL COMPONENTS */

        .panel {
            padding: 22px;
            margin-bottom: 21px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--paper);
            box-shadow: var(--shadow);
        }

        .panel-title {
            margin: 0 0 17px;
            font-size: 16px;
            font-weight: 750;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 14px;
            border: 1px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: .18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            color: white;
            background: var(--wine);
        }

        .btn-primary:hover {
            background: var(--wine-dark);
        }

        .btn-light {
            color: var(--wine);
            background: #f5e9e6;
        }

        .btn-light:hover {
            background: #ecd9d8;
        }

        .btn-danger {
            color: var(--red);
            background: #fff0ee;
        }

        .btn-danger:hover {
            background: #fbe0dc;
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 17px;
        }

        .search {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #e7d9d3;
            border-radius: 8px;
            color: var(--text);
            background: #fffdfb;
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #a86c7b;
            box-shadow: 0 0 0 3px rgba(101,42,57,.08);
        }

        .search input {
            width: 260px;
            max-width: 100%;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 12px;
            font-weight: 700;
        }

        .field {
            margin-bottom: 18px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .hint {
            margin-top: 6px;
            color: var(--muted);
            font-size: 11px;
        }

        .error {
            margin-top: 6px;
            color: var(--red);
            font-size: 11px;
        }

        .alert {
            padding: 13px 16px;
            margin-bottom: 18px;
            border-radius: 10px;
            font-size: 12px;
        }

        .alert-success {
            color: #286638;
            background: #e8f3e8;
            border: 1px solid #d4e9d4;
        }

        .alert-error {
            color: #922f35;
            background: #fbe9e7;
            border: 1px solid #f0d4d0;
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td {
            padding: 13px 12px;
            border-bottom: 1px solid #f0e7e3;
            text-align: left;
            vertical-align: middle;
        }

        th {
            color: #87747a;
            background: #fcf8f5;
            font-size: 11px;
            font-weight: 750;
            white-space: nowrap;
        }

        tbody tr:hover {
            background: #fdfaf8;
        }

        .actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .actions form {
            margin: 0;
        }

        .count {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 20px;
            color: var(--wine);
            background: #f5e9e7;
            font-size: 10px;
            font-weight: 700;
        }

        .pagination {
            margin-top: 19px;
        }

        .pagination nav > div:first-child {
            margin-bottom: 10px;
            color: var(--muted);
            font-size: 11px;
        }

        .pagination nav > div:last-child {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 11px;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--wine);
            background: white;
            font-size: 11px;
            text-decoration: none;
        }

        .pagination [aria-current="page"] span {
            color: white;
            background: var(--wine);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .detail-label {
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 11px;
        }

        .detail-value {
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .empty-state {
            padding: 28px 16px;
            color: var(--muted);
            text-align: center;
        }

        @media (max-width: 1000px) {
            .main {
                padding: 23px 20px;
            }
        }

        @media (max-width: 760px) {
            .sidebar {
                width: 250px;
                transform: translateX(-100%);
                transition: transform .25s ease;
                box-shadow: 10px 0 30px rgba(0,0,0,.12);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                z-index: 90;
                display: none;
                background: rgba(31,17,21,.4);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main {
                margin-left: 0;
                padding: 18px 15px 28px;
            }

            .topbar {
                justify-content: flex-start;
                gap: 12px;
                margin-bottom: 22px;
            }

            .mobile-menu {
                display: inline-grid;
                flex: 0 0 40px;
                place-items: center;
            }

            .page-heading {
                font-size: 21px;
            }

            .topbar-user {
                margin-left: auto;
                padding: 6px;
            }

            .topbar-user .avatar {
                width: 32px;
                height: 32px;
            }

            .topbar-user-info {
                display: none;
            }

            .panel {
                padding: 16px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="brand">
            <div class="brand-symbol">V</div>
            <div>
                <div class="brand-name">VELOURA</div>
                <div class="brand-caption">INVENTORY &amp; SALES<br>MANAGEMENT SYSTEM</div>
            </div>
        </a>

        <nav aria-label="Navigasi utama">
            <div class="nav-section">
                <div class="nav-title">MENU UTAMA</div>

                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="m3 10 9-7 9 7"/><path d="M5 9v12h14V9M9 21v-7h6v7"/></svg></span>
                    Dashboard
                </a>

                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg></span>
                    Manajemen Staff
                </a>

                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                   href="{{ route('admin.categories.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span>
                    Kategori
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-title">INVENTARIS</div>

                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                   href="{{ route('admin.products.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="m12 3 9 5-9 5-9-5 9-5Z"/><path d="m3 8 9 5 9-5M3 8v9l9 5 9-5V8M12 13v9"/></svg></span>
                    Produk
                </a>

                <a class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}"
                   href="{{ route('admin.suppliers.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M3 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M1 21h22M8 7h4M8 11h4M8 15h4M17 9h3l2 3v9"/></svg></span>
                    Supplier
                </a>

                <a class="nav-link {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}"
                   href="{{ route('admin.purchases.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M3 3h2l2.4 12.4a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 8H6"/><circle cx="10" cy="21" r="1"/><circle cx="18" cy="21" r="1"/><path d="M12 5v6M9 8h6"/></svg></span>
                    Pembelian
                </a>

                <a class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}"
                   href="{{ route('admin.sales.index') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="m7 14 4-4 4 3 6-7"/></svg></span>
                    Penjualan
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-title">AKUN</div>

                <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                   href="{{ route('profile.edit') }}">
                    <span class="nav-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg></span>
                    Profil Saya
                </a>
            </div>
        </nav>

        <div class="sidebar-bottom">
            <div class="account-card">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div style="min-width:0">
                    <div class="account-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="account-role">{{ ucfirst(auth()->user()->role ?? 'admin') }} Veloura</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout" type="submit">
                    Keluar dari Akun
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <button class="mobile-menu" type="button" id="mobileMenu"
                    aria-label="Buka navigasi" aria-expanded="false">
                <svg width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div>
                <h1 class="page-heading">@yield('page-heading', 'Dashboard')</h1>
                <div class="muted">@yield('page-description', 'Kelola operasional Veloura dengan mudah.')</div>
            </div>

            <div class="topbar-user">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="topbar-user-info">
                    <div class="topbar-user-name">{{ auth()->user()->name ?? 'Veloura Admin' }}</div>
                    <div class="role-label">{{ ucfirst(auth()->user()->role ?? 'admin') }}</div>
                </div>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error" role="alert">
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
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const button = document.getElementById('mobileMenu');

            function setSidebar(open) {
                sidebar.classList.toggle('open', open);
                overlay.classList.toggle('show', open);
                button?.setAttribute('aria-expanded', String(open));
            }

            button?.addEventListener('click', () => {
                setSidebar(!sidebar.classList.contains('open'));
            });

            overlay?.addEventListener('click', () => setSidebar(false));

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') setSidebar(false);
            });
        })();
    </script>
</body>
</html>
