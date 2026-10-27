<?php

// Mengimpor kelas Application untuk merepresentasikan aplikasi Laravel.
use Illuminate\Foundation\Application;
// Mengimpor kelas Request untuk menangani permintaan dari browser.
use Illuminate\Http\Request;

// Menyimpan waktu awal aplikasi Laravel mulai dijalankan.
// Waktu ini bisa digunakan untuk menghitung durasi pemrosesan.
define('LARAVEL_START', microtime(true));

// Memeriksa apakah aplikasi sedang dalam mode pemeliharaan.
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance; // Memeriksa apakah aplikasi sedang dalam mode pemeliharaan.
}

// Memuat Composer autoloader agar kelas yang dibutuhkan
require __DIR__.'/../vendor/autoload.php';

// Memuat bootstrap aplikasi Laravel.
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Mengambil permintaan HTTP dari browser,
$app->handleRequest(Request::capture());
