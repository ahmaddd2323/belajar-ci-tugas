# Toko Online CodeIgniter 4

Proyek ini adalah platform toko online yang dibangun menggunakan [CodeIgniter 4](https://codeigniter.com/). Sistem ini menyediakan beberapa fungsionalitas untuk toko online, termasuk manajemen produk, keranjang belanja, dan sistem transaksi.

## Daftar Isi

- [Fitur](#fitur)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Struktur Proyek](#struktur-proyek)

## Fitur

- Katalog Produk
  - Tampilan produk dengan gambar
  - Pencarian produk
- Keranjang Belanja
  - Tambah/hapus produk
  - Update jumlah produk
- Sistem Transaksi
  - Proses checkout
  - Riwayat transaksi
- Panel Admin
  - Manajemen produk (CRUD)
  - Manajemen kategori
  - Laporan transaksi
  - Export data ke PDF
- Sistem Autentikasi
  - Login/Register pengguna
  - Manajemen akun
- UI Responsif dengan NiceAdmin template

## Persyaratan Sistem

- PHP >= 7.4
- Composer
- Web server (XAMPP)

## Instalasi

1. **Clone repository ini**
   ```bash
   git clone [URL repository]
   cd belajar-ci-tugas
   ```
2. **Install dependensi**
   ```bash
   composer install
   ```
3. **Konfigurasi database**

   - Start module Apache dan MySQL pada XAMPP
   - Buat database **db_ci4** di phpmyadmin.
   - copy file .env dari tutorial https://www.notion.so/april-ns/Codeigniter4-Migration-dan-Seeding-045ffe5f44904e5c88633b2deae724d2

4. **Jalankan migrasi database**
   ```bash
   php spark migrate
   ```
5. **Seeder data**
   ```bash
   php spark db:seed ProductSeeder
   ```
   ```bash
   php spark db:seed UserSeeder
   ```
6. **Jalankan server**
   ```bash
   php spark serve
   ```
7. **Akses aplikasi**
   Buka browser dan akses `http://localhost:8080` untuk melihat aplikasi.

## Struktur Proyek

Proyek menggunakan struktur MVC CodeIgniter 4:

- app/Controllers - Logika aplikasi dan penanganan request
  - AuthController.php - Autentikasi pengguna
  - ProdukController.php - Manajemen produk
  - TransaksiController.php - Proses transaksi
  - DiscountController.php - Diskon
- app/Models 
  - ProductModel.php - Model produk
  - ProductCategoryModel.php - Model kategori produk
  - UserModel.php - Model pengguna
  - TransactionModel.php - Model transaksi produk
  - TransactionDetailModel.php - Model detail transaksi produk
  - DiscountModel.php - Model diskon produk
- app/Views 
  - v_login - Tampilan awal login
  - v_checkout - Tampilan saat checkout
  - v_contact - Tampilan contact 
  - v_discount - Tampilan discount
  - v_home - Tampilan awal setelah login
  - v_produk.php - Tampilan produk
  - v_keranjang.php - Halaman keranjang
  - v_produkkategori - Tampilan kategori produk
  - v_produkPDF - Tampilan saat data di download menjadi pdf
  - v_profile - Tampilan profile
- public/img - Gambar produk dan aset
- public/NiceAdmin - Template admin
