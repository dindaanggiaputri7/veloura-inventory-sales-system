<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Customer') — Veloura</title>
<style>
:root{--wine:#5b1726;--wine2:#7a2638;--cream:#fbf5ef;--rose:#ead2cc;--gold:#c5a16a;--ink:#342421;--muted:#88766f;--white:#fffdfa;--line:#eadfd7}
*{box-sizing:border-box}body{margin:0;background:#f7eee8;color:var(--ink);font-family:Inter,Arial,sans-serif}a{color:inherit;text-decoration:none}button,input,select,textarea{font:inherit}.shell{min-height:100vh;display:flex}.sidebar{width:245px;background:linear-gradient(180deg,#671b2d,#3f101c);color:#fff;padding:26px 16px;flex-shrink:0}.brand{font-family:Georgia,serif;font-size:26px;letter-spacing:2px;padding:0 12px 5px}.brand-sub{font-size:10px;color:#e7c9bd;padding:0 13px 28px}.nav-label{font-size:10px;text-transform:uppercase;letter-spacing:1.6px;color:#d6aeb2;padding:12px}.nav a{display:flex;gap:12px;align-items:center;padding:12px;border-radius:10px;margin:4px 0;font-size:13px;color:#f6e9e7}.nav a:hover,.nav a.active{background:#ffffff22;color:#fff}.main{flex:1;min-width:0}.topbar{height:76px;background:#fffaf6;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:flex-end;gap:18px;padding:0 34px}.topbar small{color:var(--muted)}.avatar{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;background:var(--rose);color:var(--wine);font-weight:700}.logout{border:1px solid var(--line);background:white;color:var(--wine);padding:9px 13px;border-radius:9px;cursor:pointer}.content{padding:30px;max-width:1440px;margin:auto}.welcome{background:linear-gradient(105deg,#f0d8d0,#f9ece4);border:1px solid #e7c8bd;border-radius:18px;overflow:hidden;display:flex;min-height:190px;position:relative}.welcome-copy{padding:30px;max-width:66%;z-index:1}.eyebrow{font-size:11px;text-transform:uppercase;letter-spacing:2px;color:var(--wine2);font-weight:700}.welcome h1{font-family:Georgia,serif;font-weight:500;font-size:32px;line-height:1.18;margin:10px 0}.welcome p{font-size:13px;line-height:1.7;color:#6e514b;max-width:510px}.welcome-art{position:absolute;right:0;top:0;width:39%;height:100%;object-fit:cover;mix-blend-mode:multiply;opacity:.9}.btn{display:inline-flex;align-items:center;justify-content:center;border:0;border-radius:9px;padding:11px 16px;background:var(--wine);color:white;font-size:12px;font-weight:700;cursor:pointer}.btn:hover{background:var(--wine2)}.btn-light{background:#fffaf6;color:var(--wine);border:1px solid #d9b5ac}.btn-sm{padding:8px 11px}.section-head{display:flex;align-items:center;justify-content:space-between;margin:27px 0 14px;gap:12px}.section-head h2{font-family:Georgia,serif;font-weight:500;font-size:23px;margin:0}.muted{color:var(--muted);font-size:12px}.stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin:20px 0}.stat,.panel,.category,.product-card{background:var(--white);border:1px solid var(--line);border-radius:14px}.stat{padding:18px}.stat .number{font-size:27px;color:var(--wine);font-family:Georgia,serif;margin-top:7px}.stat .label{font-size:12px;color:var(--muted)}.categories{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:13px}.category{overflow:hidden;transition:.2s}.category:hover,.product-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px #5b172610}.category img{width:100%;height:112px;object-fit:cover;display:block}.category strong{display:block;padding:12px 13px;color:var(--wine);font-size:13px}.products{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}.product-card{overflow:hidden;transition:.2s}.product-card img{height:175px;width:100%;object-fit:cover;background:#f1e1d9}.product-info{padding:14px}.product-info h3{font-size:14px;margin:0 0 5px}.price{font-weight:700;color:var(--wine);font-size:14px}.badge{display:inline-block;border-radius:20px;padding:5px 9px;background:#f4e3dc;color:var(--wine);font-size:10px}.panel{padding:20px}.table-wrap{overflow:auto}table{width:100%;border-collapse:collapse;font-size:12px}th,td{text-align:left;padding:13px 10px;border-bottom:1px solid var(--line);white-space:nowrap}th{color:var(--muted);font-weight:600;background:#fcf5f0}.form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.field{display:flex;flex-direction:column;gap:7px;font-size:12px}.field.full{grid-column:1/-1}.field input,.field select,.field textarea,.search-input{width:100%;padding:12px;border:1px solid #e4d5cc;border-radius:9px;background:#fffdfa;outline-color:var(--gold)}.field textarea{min-height:105px;resize:vertical}.alert{padding:12px 15px;border-radius:10px;margin-bottom:16px;font-size:13px;background:#e5f4e8;color:#24643b}.alert.error{background:#fae5e3;color:#912d2d}.empty{text-align:center;padding:45px 20px;color:var(--muted)}.empty h3{color:var(--wine)}.product-layout{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:28px}.product-hero{width:100%;max-height:490px;object-fit:cover;border-radius:16px;border:1px solid var(--line)}.pagination{display:flex;gap:6px;flex-wrap:wrap;margin-top:18px}.pagination a,.pagination span{padding:8px 11px;border:1px solid var(--line);border-radius:7px;background:#fff;font-size:12px}.pagination .active{background:var(--wine);color:#fff}.footer-note{font-size:11px;color:var(--muted);margin-top:28px}
@media(max-width:1000px){.sidebar{width:205px}.products{grid-template-columns:repeat(2,minmax(0,1fr))}.categories{grid-template-columns:repeat(2,minmax(0,1fr))}.content{padding:20px}.welcome-art{width:35%}}
@media(max-width:700px){.shell{display:block}.sidebar{width:100%;padding:15px}.brand{font-size:21px}.brand-sub{padding-bottom:12px}.nav{display:flex;overflow-x:auto}.nav-label{display:none}.nav a{white-space:nowrap;font-size:11px;padding:10px}.topbar{height:60px;padding:0 16px}.content{padding:15px}.welcome-copy{max-width:100%;padding:22px}.welcome-art{opacity:.2;width:70%}.welcome h1{font-size:26px}.stats{grid-template-columns:1fr}.categories{grid-template-columns:repeat(2,minmax(0,1fr))}.products{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.product-card img{height:135px}.product-layout,.form-grid{grid-template-columns:1fr}.field.full{grid-column:auto}.section-head{align-items:flex-start}.section-head h2{font-size:20px}}
</style>
</head>
<body>
<div class="shell">
<aside class="sidebar">
<a class="brand" href="{{ route('customer.dashboard') }}">VELOURA</a>
<div class="brand-sub">A Scent That Becomes You</div>
<div class="nav-label">Menu Customer</div>
<nav class="nav">
<a class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">⌂ &nbsp; Dashboard</a>
<a class="{{ request()->routeIs('customer.catalog') || request()->routeIs('customer.products.show') ? 'active' : '' }}" href="{{ route('customer.catalog') }}">✧ &nbsp; Katalog Produk</a>
<a class="{{ request()->routeIs('customer.cart*') || request()->routeIs('customer.checkout*') ? 'active' : '' }}" href="{{ route('customer.cart') }}">♡ &nbsp; Keranjang</a>
<a class="{{ request()->routeIs('customer.orders*') || request()->routeIs('customer.order.show') ? 'active' : '' }}" href="{{ route('customer.orders') }}">▤ &nbsp; Pesanan Saya</a>
<a class="{{ request()->routeIs('customer.transactions') ? 'active' : '' }}" href="{{ route('customer.transactions') }}">◷ &nbsp; Riwayat Transaksi</a>
<a class="{{ request()->routeIs('customer.profile*') ? 'active' : '' }}" href="{{ route('customer.profile') }}">♙ &nbsp; Profil Saya</a>
</nav>
<div class="footer-note" style="color:#d9b6b9;padding:20px 12px">Elegance in every note.</div>
</aside>
<main class="main">
<header class="topbar">
<div><strong>{{ auth()->user()->name }}</strong><br><small>Customer Veloura</small></div>
<div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
<form method="POST" action="{{ route('logout') }}">@csrf<button class="logout" type="submit">Keluar</button></form>
</header>
<div class="content">
@if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert error">{{ session('error') }}</div>@endif
@if($errors->any())<div class="alert error">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
@yield('content')
</div>
</main>
</div>
</body>
</html>
