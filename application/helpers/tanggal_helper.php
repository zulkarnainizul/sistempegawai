<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('format_tanggal')) {
    /**
     * Format tanggal ke dalam format Indonesia (contoh: 18 Juni 2025).
     * Mengembalikan '-' jika tanggal tidak valid.
     */
    function format_tanggal($tanggal_db)
    {
        // Jika tanggal kosong atau tidak valid, langsung kembalikan strip
        if (empty($tanggal_db) || $tanggal_db == '0000-00-00') {
            return '-';
        }

        // Daftar nama bulan dalam Bahasa Indonesia
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Konversi tanggal dari database menjadi timestamp (angka)
        $timestamp = strtotime($tanggal_db);

        // Ambil bagian-bagian dari tanggal menggunakan variabel $timestamp
        $hari   = date('d', $timestamp);
        $bln    = $bulan[(int)date('m', $timestamp)];
        $tahun  = date('Y', $timestamp); // <--- INI BAGIAN YANG DIPERBAIKI

        return $hari . ' ' . $bln . ' ' . $tahun;
    }

    
}

if (!function_exists('format_hari')) {
    /**
     * Mengubah nama hari ke dalam format Indonesia (contoh: Senin).
     */
    function format_hari($tanggal_db)
    {
        if (empty($tanggal_db) || $tanggal_db == '0000-00-00') {
            return '-';
        }
        $hari_en = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $hari_id = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $nama_hari = date('l', strtotime($tanggal_db));
        return str_replace($hari_en, $hari_id, $nama_hari);
    }
}

