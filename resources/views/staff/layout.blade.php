<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','Dashboard Staff') | Veloura</title>
<style>
*{box-sizing:border-box}:root{--wine:#57222f;--wine-dark:#461923;--wine-light:#7a414b;--cream:#f8f3ee;--border:#eadbd6;--muted:#99878b;--text:#3c292e}
body{margin:0;font-family:Arial,Helvetica,sans-serif;color:var(--text);background:var(--cream);font-size:13px}a{text-decoration:none}
.staff-sidebar{position:fixed;inset:0 auto 0 0;width:250px;padding:25px 16px 20px;overflow-y:auto;background:linear-gradient(180deg,var(--wine),var(--wine-dark));color:white;z-index:20}
.staff-brand{display:flex;align-items:center;gap:11px;padding:5px 5px 25px}.staff-brand-mark{display:grid;place-items:center;flex-shrink:0;width:43px;height:43px;border:1px solid #a77780;border-radius:12px;font-family:Georgia,serif;font-size:25px}
.staff-brand-name{font-size:21px;font-weight:800;letter-spacing:1.5px}.staff-brand-subtitle{margin-top:5px;color:#e8cfd0;font-size:9px;line-height:1.6;letter-spacing:.5px}
.staff-nav-heading{margin:23px 10px 10px;color:#d8b8bd;font-size:10px;font-weight:700;letter-spacing:1.2px}.staff-nav{display:flex;align-items:center;gap:11px;min-height:39px;margin-bottom:5px;padding:11px;border-radius:8px;color:#f8eaea;font-size:12px;transition:background .2s}
.staff-nav:hover,.staff-nav.active{background:var(--wine-light)}.staff-nav-icon{width:19px;text-align:center;font-size:15px}.staff-sidebar-bottom{margin-top:28px}
.staff-logout{width:100%;padding:11px;border:1px solid #a87880;border-radius:8px;color:white;background:transparent;cursor:pointer;font-size:12px}.staff-logout:hover{background:var(--wine-light)}
.staff-main{min-height:100vh;margin-left:250px;padding:26px 30px}.staff-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px}
.staff-page-title{margin:0;color:#352329;font-size:23px;font-weight:750}.staff-page-description{margin:7px 0 0;color:var(--muted);font-size:12px}
.staff-profile-chip{display:flex;align-items:center;gap:10px;padding:10px 13px;border:1px solid var(--border);border-radius:11px;background:white}.staff-profile-avatar{display:grid;place-items:center;flex-shrink:0;width:36px;height:36px;border-radius:10px;background:#f5e5e5;color:#642a3a;font-weight:800}
.staff-profile-name{font-size:12px;font-weight:700}.staff-profile-role{margin-top:4px;color:var(--muted);font-size:10px}
@media(max-width:1000px){.staff-sidebar{width:215px}.staff-main{margin-left:215px;padding:22px 18px}}@media(max-width:650px){.staff-sidebar{position:relative;width:100%;height:auto}.staff-main{margin-left:0;padding:18px 13px}.staff-header{align-items:flex-start;flex-direction:column}.staff-profile-chip{width:100%}}
</style>@stack('styles')</head>
<body><aside class="staff-sidebar">
<div class="staff-brand"><div class="staff-brand-mark">V</div><div><div class="staff-brand-name">VELOURA</div><div class="staff-brand-subtitle">INVENTORY &amp; SALES<br>MANAGEMENT SYSTEM</div></div></div>
<div class="staff-nav-heading">MENU UTAMA</div>
<a href="{{ route('staff.dashboard') }}" class="staff-nav {{ request()->routeIs('staff.dashboard')?'active':'' }}"><span class="staff-nav-icon">⌂</span>Dashboard</a>
<a href="{{ route('staff.products.index') }}" class="staff-nav {{ request()->routeIs('staff.products.*')?'active':'' }}"><span class="staff-nav-icon">◇</span>Produk &amp; Stok</a>
<a href="{{ route('staff.sales.index') }}" class="staff-nav {{ request()->routeIs('staff.sales.*')?'active':'' }}"><span class="staff-nav-icon">↗</span>Penjualan</a>
<a href="{{ route('staff.purchases.index') }}" class="staff-nav {{ request()->routeIs('staff.purchases.*')?'active':'' }}"><span class="staff-nav-icon">＋</span>Pembelian / Stock-in</a>
<a href="{{ route('staff.customer-orders.index') }}" class="staff-nav {{ request()->routeIs('staff.customer-orders.*')?'active':'' }}"><span class="staff-nav-icon">▣</span>Pesanan Customer</a>
<a href="{{ route('staff.transactions.index') }}" class="staff-nav {{ request()->routeIs('staff.transactions.*')?'active':'' }}"><span class="staff-nav-icon">◷</span>Riwayat Transaksi</a>
<div class="staff-nav-heading">AKUN</div><a href="{{ route('staff.profile') }}" class="staff-nav {{ request()->routeIs('staff.profile*')?'active':'' }}"><span class="staff-nav-icon">◎</span>Profil Saya</a>
<div class="staff-sidebar-bottom"><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="staff-logout">Keluar dari Akun</button></form></div>
</aside><main class="staff-main"><header class="staff-header"><div><h1 class="staff-page-title">@yield('page-heading','Dashboard Staff')</h1><p class="staff-page-description">@yield('page-description','Operasional Veloura.')</p></div><div class="staff-profile-chip"><div class="staff-profile-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div><div><div class="staff-profile-name">{{ auth()->user()->name }}</div><div class="staff-profile-role">Staff Operasional</div></div></div></header>@yield('content')</main>@stack('scripts')</body></html>
