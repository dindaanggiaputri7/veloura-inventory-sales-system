# Veloura Inventory & Sales Management System

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![Database](https://img.shields.io/badge/Database-MySQL-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-In%20Development-9B6A76)

**Veloura Inventory & Sales Management System** adalah aplikasi web untuk membantu pengelolaan persediaan produk dan pencatatan transaksi dalam satu sistem. Aplikasi ini dikembangkan menggunakan Laravel dan MySQL, dengan akses yang dibedakan berdasarkan peran **Admin**, **Staff**, dan **Customer**.

> Status proyek: **Dalam pengembangan**. Dokumentasi visual, data demonstrasi, dan detail akun uji akan ditambahkan setelah konfigurasi serta pengujian fitur selesai.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Peran Pengguna](#peran-pengguna)
- [Teknologi](#teknologi)
- [Gambaran Alur Sistem](#gambaran-alur-sistem)
- [Persyaratan](#persyaratan)
- [Instalasi Lokal](#instalasi-lokal)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Struktur Data Utama](#struktur-data-utama)
- [Catatan Pengembangan](#catatan-pengembangan)

## Fitur Utama

- Pengelolaan produk, kategori, supplier, dan persediaan.
- Pencatatan penjualan langsung oleh Staff.
- Pencatatan pembelian stok dari supplier.
- Katalog produk yang tersedia untuk Customer.
- Keranjang belanja dan pembuatan pesanan Customer.
- Pembayaran pesanan online melalui transfer manual dengan status pembayaran yang dapat diperiksa Staff.
- Pemantauan status pesanan, riwayat transaksi, dan ringkasan dashboard.
- Pemisahan akses berdasarkan peran pengguna.

## Peran Pengguna

### Admin

- Memantau ringkasan inventaris dan transaksi pada dashboard.
- Mengelola kategori, produk, supplier, dan akun Staff.
- Melihat data penjualan, pembelian, serta laporan yang tersedia di aplikasi.
- Memantau penjualan langsung dan pesanan Customer yang pembayarannya telah tercatat lunas.

### Staff

- Memeriksa produk dan stok yang menipis.
- Mencatat penjualan langsung, termasuk produk, jumlah, diskon, dan metode pembayaran.
- Mencatat pembelian stok dari supplier; jumlah stok produk bertambah sesuai pembelian yang disimpan.
- Memeriksa pesanan Customer dan memperbarui status pesanan serta pembayaran sesuai alur yang diizinkan sistem.
- Melihat riwayat penjualan langsung dan pesanan Customer.

### Customer

- Melihat katalog dan detail produk yang tersedia.
- Menambahkan produk ke keranjang dan memperbarui jumlah barang.
- Membuat pesanan dengan mengisi alamat pengiriman.
- Melihat detail serta riwayat pesanan.
- Mengelola informasi profil.

## Teknologi

| Bagian | Teknologi |
|---|---|
| Backend | PHP 8.2+ dan Laravel 12 |
| Database | MySQL / MariaDB |
| Template tampilan | Laravel Blade |
| Asset frontend | Vite, JavaScript, CSS, dan dependensi frontend project |
| Pengembangan lokal | PHP, Composer, Node.js, dan npm |

## Gambaran Alur Sistem

1. Admin menyiapkan data kategori, produk, supplier, dan akun Staff.
2. Staff mencatat pembelian stok dari supplier atau mencatat penjualan langsung.
3. Customer memilih produk dari katalog, memasukkannya ke keranjang, lalu membuat pesanan.
4. Pesanan online tercatat dengan status pembayaran awal **belum dibayar** karena menggunakan alur transfer manual.
5. Staff memeriksa pesanan dan memperbarui status pembayaran maupun status pesanan sesuai aturan aplikasi.
6. Dashboard dan riwayat transaksi menampilkan data yang tersimpan di database.

## Persyaratan

Pastikan perangkat sudah memiliki:

- PHP 8.2 atau versi yang kompatibel dengan project.
- Composer.
- MySQL atau MariaDB (XAMPP dapat digunakan di Windows).
- Node.js dan npm.
- Git.

## Instalasi Lokal

### 1. Clone repository

```bash
git clone https://github.com/dindaanggiaputri7/veloura-inventory-sales-system.git
cd veloura-inventory-sales-system
```

### 2. Pasang dependensi PHP

```bash
composer install
```

### 3. Siapkan file environment

Di Windows Command Prompt:

```bat
copy .env.example .env
```

Jika file `.env` sudah ada, **jangan menimpanya**. Buka file tersebut dan sesuaikan konfigurasi database.

Contoh konfigurasi MySQL lokal:

```dotenv
APP_NAME="Veloura Inventory & Sales Management System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_sales
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan nama database, username, password, dan port dengan konfigurasi MySQL di perangkat masing-masing. Buat database `inventory_sales` terlebih dahulu melalui phpMyAdmin atau MySQL jika memang memakai nama tersebut.

### 4. Buat application key

```bash
php artisan key:generate
```

### 5. Siapkan database

Pastikan database yang dipilih pada `.env` sudah ada dan MySQL sedang berjalan, kemudian jalankan:

```bash
php artisan migrate
```

Perintah ini menjalankan migration yang tersedia di project. Sebelum menjalankan migration pada database yang sudah berisi data penting, buat backup terlebih dahulu. Jangan menggunakan `migrate:fresh` pada database yang berisi data karena perintah itu menghapus seluruh tabel.

### 6. Pasang dependensi frontend

```bash
npm install
npm run build
```

## Menjalankan Aplikasi

Jalankan server Laravel dari direktori project:

```bash
php artisan serve
```

Buka alamat berikut di browser:

```text
http://127.0.0.1:8000
```

Jika sedang mengembangkan asset frontend, gunakan terminal terpisah untuk:

```bash
npm run dev
```

### Akun pengguna

README ini tidak menetapkan username atau password demo karena akun awal harus disesuaikan dengan data pada database lokal. Gunakan mekanisme registrasi atau pengelolaan akun yang tersedia pada versi project yang sedang dijalankan. Jangan memasukkan password, token, atau isi file `.env` ke repository publik.

## Struktur Data Utama

Berikut kelompok data yang digunakan oleh fitur inti aplikasi:

- **Users**: akun dan peran pengguna.
- **Categories & Products**: kategori, informasi produk, harga, dan stok.
- **Suppliers & Purchases**: data supplier dan transaksi pembelian stok.
- **Purchase Items**: rincian item dalam pembelian.
- **Sales & Sale Items**: transaksi penjualan langsung beserta rincian produknya.
- **Customer Orders & Customer Order Items**: pesanan online dan rincian produk yang dipesan.

Nama tabel dan kolom definitif mengikuti migration yang ada di repository.

## Catatan Pengembangan

Project ini masih dikembangkan. Penyempurnaan dokumentasi dapat dilakukan bertahap, misalnya dengan menambahkan:

- Screenshot halaman Dashboard Admin, Staff, dan Customer.
- Diagram ERD dan penjelasan relasi tabel.
- Akun uji khusus demonstrasi (tanpa memakai password pribadi).
- Daftar skenario pengujian dan hasil pengujiannya.
- Panduan penggunaan untuk tiap peran.

## Repository

Source code: [dindaanggiaputri7/veloura-inventory-sales-system](https://github.com/dindaanggiaputri7/veloura-inventory-sales-system)
