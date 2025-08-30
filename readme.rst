===================================================================================
Sistem Informasi Kepegawaian SMKN 2 Pekanbaru
===================================================================================

Sistem ini adalah aplikasi berbasis web yang dirancang untuk mengelola data kepegawaian dan
administrasi di **SMK Negeri 2 Pekanbaru**. Aplikasi ini dikembangkan untuk mengatasi
keterbatasan pengelolaan data manual yang seringkali tidak efisien dan rentan terhadap
inkonsistensi data.

-----

Fitur Utama
===========

Aplikasi ini menyediakan berbagai modul untuk mempermudah pekerjaan staf kepegawaian, di antaranya:

* Dashboard - Tampilan ringkasan data kepegawaian dan performa absensi secara visual.
* Data Pegawai - Manajemen data lengkap setiap pegawai.
* Absensi Pegawai - Pencatatan dan pemantauan absensi pegawai secara *real-time*.
* Surat Menyurat - Pembuatan surat tugas, surat cuti, dan surat keterangan secara otomatis.
* Manajemen Master Data - Pengelolaan data dasar seperti golongan, jabatan, dan status pegawai
  untuk memastikan data yang terstruktur.

-----

Teknologi yang Digunakan
========================

* Framework : CodeIgniter 3
* Bahasa Pemrograman : PHP
* Database : MySQL
* Metodologi Pengembangan : Prototyping

-----

Cara Instalasi & Pemasangan
===========================

1. Kloning Repository

   .. code-block:: bash

      git clone https://github.com/akun_anda/nama_repo.git

2. Impor Database

   Buat database baru di MySQL:
   
   .. code-block:: sql
   
      CREATE DATABASE db_kepegawaian_smkn2;
   
   Impor file .sql ke database yang sudah dibuat (gunakan phpMyAdmin atau perintah MySQL berikut):
   
   .. code-block:: bash
   
      mysql -u root -p db_kepegawaian_smkn2 < file_database.sql

3. Konfigurasi Database

   Buka file: ``application/config/database.php`` lalu sesuaikan dengan pengaturan server MySQL Anda:

   .. code-block:: php

      'hostname' => 'localhost',
      'username' => 'root',
      'password' => '',
      'database' => 'sisfopegawai',

4. Jalankan Aplikasi

   Pindahkan folder proyek ke dalam direktori server lokal (misalnya `htdocs/` untuk XAMPP atau `www/` untuk WampServer).

   Akses aplikasi melalui browser:
   
   .. code-block::
   
      http://localhost/sistempegawai

-----

Kontributor
===========

* Tim Pengembang Sistem Informasi Kepegawaian
* SMK Negeri 2 Pekanbaru

-----

Lisensi
=======

Proyek ini dibuat untuk kebutuhan internal **SMK Negeri 2 Pekanbaru**. Penggunaan di luar sekolah
harus mendapat izin dari pihak pengembang.
