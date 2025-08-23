# Sistem Informasi Kepegawaian SMK N 2 Pekanbaru

Sistem ini adalah aplikasi berbasis web yang dirancang untuk mengelola data kepegawaian dan administrasi di SMK Negeri 2 Pekanbaru. Aplikasi ini dikembangkan untuk mengatasi keterbatasan pengelolaan data manual yang seringkali tidak efisien dan rentan terhadap inkonsistensi data.

## Fitur Utama

Aplikasi ini menyediakan berbagai modul untuk mempermudah pekerjaan staf kepegawaian, di antaranya:

* **Dashboard**: Tampilan ringkasan data kepegawaian dan performa absensi secara visual.
* **Data Pegawai**: Manajemen data lengkap setiap pegawai.
* **Absensi Pegawai**: Pencatatan dan pemantauan absensi pegawai secara *real-time*.
* **Surat Menyurat**: Pembuatan surat tugas, surat cuti, dan surat keterangan secara otomatis.
* **Manajemen Master Data**: Pengelolaan data dasar seperti golongan, jabatan, dan status pegawai untuk memastikan data yang terstruktur.

## Teknologi yang Digunakan

* **Framework**: CodeIgniter 3
* **Bahasa**: PHP
* **Database**: MySQL
* **Metodologi Pengembangan**: Prototyping

## Cara Pemasangan

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Kloning repositori ini**:
    ```bash
    git clone [https://github.com/akun_anda/nama_repo.git](https://github.com/akun_anda/nama_repo.git)
    ```
2.  **Impor database**:
    * Buat database baru di server MySQL Anda (misalnya: `db_kepegawaian_smkn2`).
    * Impor file `.sql` yang ada di dalam repositori (jika tersedia) ke database yang baru dibuat.
3.  **Konfigurasi koneksi database**:
    * Buka file `database.php` yang terletak di `application/config/database.php`.
    * Ubah konfigurasi `$db['default']` sesuai dengan pengaturan database Anda.
    ```php
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'sisfopegawai',
    ```
4.  **Jalankan aplikasi**:
    * Tempatkan folder proyek di dalam direktori `htdocs` (untuk XAMPP) atau `www` (untuk WampServer).
    * Buka browser dan akses aplikasi melalui `http://localhost/sistempegawai`.
