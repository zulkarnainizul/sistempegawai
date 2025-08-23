<?php 
    function formatTanggalIndonesia($tanggal) {
        $bulanInggris = array(
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        );

        $bulanIndonesia = array(
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );

        $tanggalBaru = date('d F Y', strtotime($tanggal));
        $tanggalBaru = str_replace($bulanInggris, $bulanIndonesia, $tanggalBaru);
        
        return $tanggalBaru;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan</title>
    <style>
        @page {
            margin: 0.5cm 2.5cm 2.5cm 2.5cm;
        }
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
            line-height: 1.5; /* Line spacing set to 1.5 */
        }
        .container {
            margin: 0;
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
            font-size: 18pt;
            text-decoration: underline;
            margin: 0;
        }
        .header p {
            margin: 0;
            font-size: 12pt;
        }
        .content {
            margin: 0;
            line-height: 1.5; /* Line spacing for content set to 1.5 */
            text-align: justify; /* Justify the content */
        }
        .content p {
            margin: 12px 0; /* Paragraph spacing set to 1.5 */
            line-height: 1.5;
        }
        .content .label {
            display: inline-block;
            width: 160px;
            margin-right: 20px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature .name {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0;
        }
        .signature p {
            margin: 0;
            font-size: 12pt;
        }
        table {
            margin-left: 50px; /* Optional, for overall indentation */
        }
        td.label {
            padding-right: 0px; /* Adjust the space between label and value */
            vertical-align: top;
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
    <!-- Isi Surat -->  
    <div class="header">
        <h1>SURAT KETERANGAN</h1>
        <p>No: <?= $surat->no_surat; ?></p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala Sekolah Menengah Kejuruan (SMK) Negeri 2 Pekanbaru, dengan ini menerangkan bahwa:</p>
        <table>
            <tr>
                <td class="label">Nama</td>
                <td>: <?= $surat->nama; ?></td>
            </tr>
            <tr>
                <td class="label">NIP/NUPTK</td>
                <td>: <?= $surat->nip; ?></td>
            </tr>
            <tr>
                <td class="label">Tempat/Tgl. Lahir</td>
                <td>: <?= $surat->tempat_lahir ?>, <?= formatTanggalIndonesia($surat->tanggal_lahir) ?></td>
            </tr>
            <tr>
                <td class="label">Nama Instansi</td>
                <td>: SMK Negeri 2 Pekanbaru</td>
            </tr>
            <tr>
                <td class="label">Bidang Studi</td>
                <td>: <?= $surat->bidang_studi; ?></td>
            </tr>
            <tr>
                <td class="label">Kabupaten/Kota</td>
                <td>: <?= $surat->kab_kota; ?></td>
            </tr>
        </table>

        <p><?= $surat->keterangan; ?></p>

        <p>Demikian surat keterangan ini diberikan untuk dapat dipergunakan sebagaimana mestinya.</p>
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

