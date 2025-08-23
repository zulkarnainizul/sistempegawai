<?php 
    function formatTanggalIndonesia($tanggal) {
        $bulanInggris = array(
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        );
        $bulanIndonesia = array(
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        $tanggalBaru = date('d F Y', strtotime($tanggal));
        return str_replace($bulanInggris, $bulanIndonesia, $tanggalBaru);
    }

    function formatHariIndonesia($tanggal) {
        $hariInggris = array(
            'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
        );
        $hariIndonesia = array(
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        );
        $hari = date('l', strtotime($tanggal));
        return str_replace($hariInggris, $hariIndonesia, $hari);
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas</title>
    <style>
        @page {
            margin: 0.5cm 2.5cm 2.5cm 2.5cm;
        }
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        .kop-surat {
            position: relative;
            text-align: center;
            line-height: 1.2;
            margin-bottom: 12px;
        }
        .kop-surat h1 {
            font-size: 18pt; /* Sesuaikan ukuran font di sini */
            font-weight: bold; /* Tambahkan ini jika ingin teks lebih tebal */
            margin: 0;
        }

        .kop-surat h4 {
            font-size: 12pt; /* Sesuaikan ukuran font di sini */
            font-weight: bold; /* Pastikan font-weight sesuai dengan keinginan */
            margin: 0;
        }

        .kop-surat p {
            font-size: 10pt; /* Sesuaikan ukuran font di sini */
            font-weight: normal; /* Pastikan font-weight sesuai dengan keinginan */
            margin: 0;
        }

        .kop-surat img {
            width: 85px;
            height: auto;
            position: absolute;
            top: 10px;
        }
        .kop-surat img.left {
            left: 0;
        }
        .kop-surat img.right {
            right: 0;
        }

        .garis {
            border-top: 3px solid black;
            margin: 10px 0;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0;
            text-decoration: underline;
        }
        .header p {
            margin: 0;
            font-size: 12pt;
        }
        .content {
            text-align: justify;
        }
        .content p {
            margin: 8px 0;
        }
        .content .label {
            display: inline-block;
            width: 160px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12pt;
        }
        
        table th, table td {
            border: none;
            padding: 2px;
            vertical-align: top;
        }
        table th {
            text-align: center;
        }
        
        /* === STYLE BARU UNTUK TABEL DENGAN BORDER === */
        .bordered-table {
            border-collapse: collapse;
            width: 100%;
        }
        .bordered-table th, .bordered-table td {
            border: 1px solid black;
            padding: 3px 5px; /* PERBAIKAN: Padding diperkecil */
            vertical-align: middle;
            line-height: 1.15;   /* TAMBAHAN: Jarak antar baris dirapatkan */
        }
        .bordered-table th {
            text-align: center;
            background-color: #f2f2f2;
        }
        /* ============================================== */

        .info-table {
            margin-top: 8px;
            width: 100%;
            font-size: 12pt;
            border: none;
        }
        .info-table td {
            vertical-align: top;
            padding: 2px;
        }
        .info-label {
            width: 20%;
            font-weight: bold;
            line-height: 1.15;
            white-space: nowrap;
        }
        .signature {
            margin-top: 30px;
            text-align: right;
            line-height: 1.15;
        }
        .signature p {
            margin: 2px 0;
        }
        .signature .name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="kop-surat">
        <img src="<?= base_url('assets/template/dist/img/logoriau.jpg'); ?>" class="left">
        <img src="<?= base_url('assets/template/dist/img/logotutwuri.jpg'); ?>" class="right">
        <h4>PEMERINTAH PROVINSI RIAU</h4>
        <h4>DINAS PENDIDIKAN</h4>
        <h1>SEKOLAH MENENGAH KEJURUAN</h1>
        <h1>(SMK) NEGERI 2 PEKANBARU</h1>
        <p>Alamat: Jalan Pattimura No. 14 Pekanbaru, Telepon/ Faximile: 0761-571240/0761-23326</p>
        <p>Website: http://www.smkn2pekanbaru.sch.id, Email: smkn2.pku@gmail.com</p>
        <p>NSS: 321096005001, NIS: 320010, NPSN: 10403926</p>
        <p>AKREDITASI: A</p>
    </div>
    <div class="garis"></div>
    <div class="header">
        <h1>SURAT TUGAS</h1>
        <p>Nomor: <?= $surat->no_surat; ?></p>
    </div>

    <div class="content">
    <table>
        <tr>
            <td style="width: 110px;"><b>Dasar</b></td>
            <td>:</td>
            <td><?= $surat -> dasar_surat?></td>
        </tr>
        <tr>
            <td style="width: 110px;"><b>Pemberi Tugas</b></td>
            <td>:</td>
            <td><?= $surat -> pemberi_tugas?> </td>
        </tr>
    </table>

        <p><b>Ditugaskan kepada</b> :</p>

        <table class="bordered-table">
            <thead>
                <tr>
                    <th style="width: 2%;">NO</th>
                    <th style="width: 23%;">NAMA/NIP/NIPPPK/GOLONGAN</th>
                    <th style="width: 15%;">PEKERJAAN</th>
                    <th style="width: 10%;">KET</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($pelaksana as $p): ?>
                <tr>
                    <td style="text-align: center;"><?= $no++; ?></td>
                    <td>
                        <?= htmlspecialchars($p->nama) ?><br>
                        <?php
                            // Tentukan label NIP berdasarkan status
                            $label_nip = 'NUPTK'; // Default label
                            if ($p->nama_status == 'PNS') {
                                $label_nip = 'NIP';
                            } elseif ($p->nama_status == 'PPPK') {
                                $label_nip = 'NIPPPK';
                            }
                            
                            // Tampilkan label dan nilainya
                            echo $label_nip . '. ' . htmlspecialchars($p->nip);
                        ?>
                        <?php if (!empty($p->nama_golongan)) : ?>
                            <br><?= htmlspecialchars($p->nama_golongan) ?>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $p->nama_jabatan ?> di SMKN 2 Pekanbaru
                    </td>
                    <td></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Untuk <b>Mengikuti Kegiatan <?= htmlspecialchars($surat->nama_kegiatan) ?></b>, yang dilaksanakan pada :</p>
        <table style="margin-left: 50px; border: none;">
            <tr>
                <td style="width: 100px;" class="info-label">Hari</td>
                <td>:</td>
                <td>
                    <?php
                        $mulai = new DateTime($surat->tanggal_mulai);
                        $akhir = new DateTime($surat->tanggal_akhir);
                        if ($mulai->format('Y-m-d') == $akhir->format('Y-m-d')) {
                            echo formatHariIndonesia($surat->tanggal_mulai);
                        } else {
                            echo formatHariIndonesia($surat->tanggal_mulai) . ' s/d ' . formatHariIndonesia($surat->tanggal_akhir);
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="info-label">Tanggal</td>
                <td>:</td>
                <td>
                    <?php
                        $mulai = new DateTime($surat->tanggal_mulai);
                        $akhir = new DateTime($surat->tanggal_akhir);
                        if ($mulai->format('Y-m-d') == $akhir->format('Y-m-d')) {
                            echo formatTanggalIndonesia($surat->tanggal_mulai);
                        } else {
                            echo formatTanggalIndonesia($surat->tanggal_mulai) . ' s/d ' . formatTanggalIndonesia($surat->tanggal_akhir);
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="info-label">Tempat</td>
                <td>:</td>
                <td><?= $surat->tempat_kegiatan; ?><br><?= $surat->lokasi_kegiatan; ?></td>
            </tr>
        </table>

        <p>Demikian surat ini dibuat, untuk dapat dilaksanakan dengan penuh tanggung jawab.</p>
    </div>

    <div class="signature">
        <p>Pekanbaru, <?= formatTanggalIndonesia($surat->date_create); ?></p>
        <p>Kepala Sekolah,</p>
        <br><br><br>
        <?php if ($kepala_sekolah): ?>
            <p class="name"><?= htmlspecialchars($kepala_sekolah->nama) ?></p>
            <p>NIP. <?= htmlspecialchars($kepala_sekolah->nip) ?></p>
        <?php else: ?>
            <p class="name">(Nama Kepala Sekolah Tidak Ditemukan)</p>
            <p>NIP. (NIP Tidak Tersedia)</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>