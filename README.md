# Veloura Inventory & Sales Management System

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![Database](https://img.shields.io/badge/Database-MySQL%20%2F%20MariaDB-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/Status-In%20Development-9B6A76)

**Veloura Inventory & Sales Management System** adalah aplikasi web untuk membantu pengelolaan persediaan produk, transaksi, dan pesanan pelanggan dalam satu sistem. Aplikasi dikembangkan menggunakan Laravel dan MySQL/MariaDB dengan pemisahan akses berdasarkan peran **Admin**, **Staff**, dan **Customer**.

> **Status proyek:** Dalam pengembangan. Fitur dan tampilan pada dokumentasi ini mengikuti versi proyek saat ini dan dapat berubah selama proses pengembangan serta pengujian.

## Daftar Isi

- [Tampilan Aplikasi](#tampilan-aplikasi)
- [Fitur Utama](#fitur-utama)
- [Peran Pengguna](#peran-pengguna)
- [Teknologi](#teknologi)
- [Gambaran Alur Sistem](#gambaran-alur-sistem)
- [Struktur Data Utama](#struktur-data-utama)
- [Persyaratan](#persyaratan)
- [Instalasi Lokal](#instalasi-lokal)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Catatan Keamanan dan Pengembangan](#catatan-keamanan-dan-pengembangan)

## Tampilan Aplikasi

Screenshot berikut menunjukkan tampilan antarmuka aplikasi Veloura.

### 1. Halaman Utama

Halaman utama memperkenalkan Veloura Parfum serta menyediakan navigasi menuju koleksi, katalog produk, informasi brand, login, dan pendaftaran.

<img width="1350" height="635" alt="image" src="https://github.com/user-attachments/assets/3b5885f2-f518-44b0-8d9d-898aeb7ce980" />


### 2. Koleksi Parfum

Bagian koleksi menampilkan pilihan kategori aroma untuk membantu Customer menjelajahi koleksi parfum.

<img width="1349" height="631" alt="image" src="https://github.com/user-attachments/assets/77c8c767-ed62-4192-8125-c8430883ec9f" />


### 3. Katalog Produk

Katalog menampilkan produk parfum, gambar, kode produk, nama, dan deskripsi singkat untuk membantu Customer mengenali produk yang tersedia.

<img width="1349" height="626" alt="image" src="https://github.com/user-attachments/assets/ed68a3ed-b904-4b59-b996-afa0a8e38d69" />


### 4. Cerita Veloura

Bagian ini menampilkan identitas dan cerita brand sebagai bagian dari halaman utama.

<img width="1357" height="636" alt="image" src="https://github.com/user-attachments/assets/29eb1da9-f1ee-47af-bc96-eb04d51e1a33" />


### 5. Halaman Login

Halaman login digunakan pengguna untuk masuk dengan email dan password yang terdaftar.

<img width="1350" height="638" alt="image" src="https://github.com/user-attachments/assets/726c642f-a69b-45b8-a87a-560524325eca" />


### 6. Halaman Pendaftaran

Halaman pendaftaran menyediakan formulir pembuatan akun baru sesuai dengan mekanisme registrasi yang tersedia pada aplikasi.

<img width="1354" height="633" alt="image" src="https://github.com/user-attachments/assets/9b7aae9d-db33-42c3-aa99-ce9e48c8244f" />


### 7. Dashboard Admin

Dashboard Admin menampilkan ringkasan operasional, antara lain total produk, stok menipis, pembelian, dan penjualan. Menu di sisi halaman menyediakan akses ke pengelolaan data sesuai hak akses Admin.

<img width="1349" height="637" alt="image" src="https://github.com/user-attachments/assets/ef908db6-5428-47cc-8336-ffd0ab73e7b4" />


### 8. Dashboard Staff

Dashboard Staff merangkum informasi inventaris, penjualan, pembelian stok, dan pesanan Customer yang perlu diproses.

<img width="1352" height="632" alt="image" src="https://github.com/user-attachments/assets/2ff077c5-af4c-4bf6-ac78-0301cd8c7a40" />


### 9. Dashboard Customer

Dashboard Customer menyediakan akses ke katalog produk, keranjang, pesanan, riwayat transaksi, dan profil pengguna.

<img width="1345" height="636" alt="image" src="https://github.com/user-attachments/assets/ce1268a1-fe9b-4f24-8526-7156a2d49bb1" />


## Fitur Utama

- Pengelolaan produk, kategori, supplier, dan persediaan.
- Pencatatan penjualan langsung oleh Staff.
- Pencatatan pembelian stok dari supplier.
- Katalog produk yang dapat dilihat Customer.
- Keranjang belanja dan pembuatan pesanan Customer.
- Alur pembayaran pesanan melalui transfer manual dengan pemeriksaan oleh Staff.
- Pemantauan status pesanan dan riwayat transaksi.
- Dashboard yang menampilkan ringkasan sesuai peran pengguna.
- Pemisahan akses untuk Admin, Staff, dan Customer.

## Peran Pengguna

### Admin

- Melihat ringkasan inventaris dan transaksi melalui dashboard.
- Mengelola kategori, produk, supplier, dan akun Staff.
- Melihat data penjualan, pembelian, dan laporan yang tersedia di aplikasi.
- Memantau aktivitas transaksi dan pesanan Customer sesuai fitur yang tersedia.

### Staff

- Memeriksa data produk dan kondisi stok.
- Mencatat penjualan langsung, termasuk rincian produk, jumlah, diskon, dan metode pembayaran jika tersedia pada formulir transaksi.
- Mencatat pembelian stok dari supplier.
- Memeriksa pesanan Customer dan memperbarui status pesanan atau pembayaran sesuai alur aplikasi.
- Melihat riwayat transaksi yang tersedia pada dashboard Staff.

### Customer

- Melihat katalog dan detail produk yang tersedia.
- Menambahkan produk ke keranjang dan memperbarui jumlah barang.
- Membuat pesanan dengan mengisi informasi pengiriman.
- Melihat detail serta riwayat pesanan.
- Mengelola informasi profil.

## Teknologi

| Bagian | Teknologi |
|---|---|
| Backend | PHP 8.2+ dan Laravel 12 |
| Database | MySQL atau MariaDB |
| Template tampilan | Laravel Blade |
| Asset frontend | Vite, JavaScript, CSS, dan dependensi frontend proyek |
| Pengembangan lokal | Composer, Node.js, npm, Git, dan PHP |
| Server lokal yang dapat digunakan | `php artisan serve` dan XAMPP untuk layanan database bila diperlukan |

## Gambaran Alur Sistem

1. Admin menyiapkan dan mengelola data kategori, produk, supplier, serta akun Staff.
2. Staff mencatat pembelian stok dari supplier atau mencatat penjualan langsung.
3. Customer membuka katalog, memilih produk, memasukkannya ke keranjang, lalu membuat pesanan.
4. Pesanan dengan alur transfer manual tercatat dan menunggu proses pembayaran atau verifikasi sesuai status yang diterapkan aplikasi.
5. Staff memeriksa pesanan dan memperbarui status pembayaran serta status pesanan sesuai hak aksesnya.
6. Data yang tersimpan digunakan untuk menampilkan ringkasan dashboard dan riwayat transaksi.

## Struktur Data Utama

Aplikasi menggunakan beberapa kelompok tabel untuk mendukung fitur utamanya. Nama dan kolom definitif mengikuti migration yang tersedia di proyek.

- **Users** — data akun pengguna dan perannya.
- **Categories** — kategori produk.
- **Products** — informasi produk, harga, dan stok.
- **Suppliers** — data supplier.
- **Purchases** dan **Purchase Items** — transaksi pembelian stok dan rincian item pembelian.
- **Sales** dan **Sale Items** — transaksi penjualan langsung dan rincian produknya.
- **Customer Orders** dan **Customer Order Items** — pesanan Customer dan rincian produk dalam pesanan.

## Persyaratan

Pastikan perangkat sudah memiliki:

- PHP 8.2 atau versi yang kompatibel dengan proyek.
- Composer.
- MySQL atau MariaDB. XAMPP dapat digunakan di Windows.
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

Di Windows Command Prompt, salin file contoh konfigurasi:

```bat
copy .env.example .env
```

Jika file `.env` sudah ada, jangan menimpanya. Buka file itu dan sesuaikan konfigurasi database.

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

Sesuaikan nama database, username, password, dan port dengan konfigurasi di perangkat masing-masing. Buat database `inventory_sales` terlebih dahulu melalui phpMyAdmin atau MySQL jika menggunakan nama tersebut.

### 4. Buat application key

```bash
php artisan key:generate
```

### 5. Jalankan migration

Pastikan database sudah dibuat dan layanan MySQL/MariaDB sedang berjalan, kemudian jalankan:

```bash
php artisan migrate
```

Perintah ini menjalankan migration yang tersedia. Jika database telah berisi data penting, buat backup terlebih dahulu sebelum mengubah struktur database. **Jangan menjalankan `php artisan migrate:fresh` pada database berisi data yang ingin dipertahankan**, karena perintah tersebut menghapus tabel yang dikelola oleh migration.

### 6. Pasang dan build asset frontend

```bash
npm install
npm run build
```

## Menjalankan Aplikasi

Jalankan server Laravel dari direktori utama proyek:

```bash
php artisan serve
```

Buka alamat berikut di browser:

```text
http://127.0.0.1:8000
```

Saat mengembangkan asset frontend, jalankan perintah berikut di terminal terpisah:

```bash
npm run dev
```

### Akun Pengguna

README ini tidak mencantumkan username atau password demo. Gunakan registrasi atau mekanisme pengelolaan akun yang tersedia pada versi proyek yang sedang dijalankan. Pastikan akun Admin dan Staff disiapkan melalui cara yang sesuai dengan konfigurasi aplikasi.

## Catatan Keamanan dan Pengembangan

- Jangan mengunggah file `.env`, password, token, atau kredensial pribadi ke repository publik.
- Jangan menggunakan data pelanggan atau transaksi yang bersifat sensitif dalam screenshot demonstrasi.
- Status proyek masih dalam pengembangan; lakukan pengujian pada setiap peran pengguna sebelum digunakan untuk operasional nyata.
- Dokumentasi dapat dikembangkan lebih lanjut dengan diagram ERD, skenario pengujian, serta panduan penggunaan tiap peran.

## Repository

Source code: [dindaanggiaputri7/veloura-inventory-sales-system](https://github.com/dindaanggiaputri7/veloura-inventory-sales-system)
