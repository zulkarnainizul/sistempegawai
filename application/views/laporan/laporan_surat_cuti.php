<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Cuti - <?= $cuti->nama_pemohon ?></title>
    <style>
        @page {
            margin: 1.5cm; /* Margin halaman yang ideal */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9.5pt; /* Ukuran font dirapatkan */
            line-height: 1.25; /* Jarak baris dirapatkan */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .main-table, .main-table td {
            border: 1px solid black;
        }
        td, th {
            padding: 2px 4px; /* Padding minimal untuk kerapatan */
            vertical-align: top;
        }
        .center { text-align: center; }
        .strong { font-weight: bold; }
        .underline { text-decoration: underline; }
        .title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }
        .no-border, .no-border td {
            border: none;
            padding: 0;
        }
        .check {
            font-family: "DejaVu Sans", sans-serif;
            font-weight: bold;
            font-size: 11pt; /* <-- Ukuran diperkecil agar pas */
            line-height: 1;  /* Tambahan: Mengatur jarak baris khusus untuk ceklis */
        }
        .signature-box {
            height: 55px; /* Ruang tanda tangan disesuaikan */
        }
        .note {
            font-size: 7pt;
            margin-top: 5px;
            line-height: 1.2;
        }
        .sub-header {
            font-weight: bold;
            background-color: #E9E9E9;
        }
        .check-col {
            width: 5%;
            border-left: 1px solid black;
        }
        
    </style>
</head>
<body>
    <table class="no-border">
        <tr>
            <td width="75%"></td>
            <td width="25%">
                Pekanbaru, <?= format_tanggal($cuti->date_create) ?><br>
                Kepada<br>
                Yth. <?= $cuti->jabatan_atasan2 ?><br>
                di<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tempat
            </td>
        </tr>
    </table>
            <br>

    <div class="title"><span class="underline">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</span></div>

    <table class="main-table">
        <tr>
        <td colspan="4" class="sub-header">&nbsp;I. DATA PEGAWAI</td>
        </tr>
        <tr>
            <td width="20%">Nama</td>
            <td width="30%"><?= $cuti->nama_pemohon ?></td>
            <td width="20%">NIP</td>
            <td width="30%"><?= $cuti->nip_pemohon ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td><?= $cuti->jabatan ?></td>
            <td>Masa Kerja</td>
            <td><?= $cuti->masa_kerja_tahun ?> tahun <?= $cuti->masa_kerja_bulan ?> bulan</td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td colspan="3"><?= $cuti->unit_kerja ?></td>
        </tr>

        
        <tr><td colspan="4" class="sub-header">&nbsp;II. JENIS CUTI YANG DIAMBIL***</td></tr>
        <tr>
            <td width="45%" style="border-right: 1px solid black;">1. Cuti Tahunan</td><td width="5%" class="check-col center"> <?= ($cuti->jenis_cuti == 'Cuti Tahunan') ? '<span class="check">✓</span>' : '' ?></td>
            <td width="45%" style="border-right: 1px solid black;">2. Cuti Besar</td><td width="5%" class="check-col center"> <?= ($cuti->jenis_cuti == 'Cuti Besar') ? '<span class="check">✓</span>' : '' ?></td>
        </tr>
        <tr>
            <td style="border-right: 1px solid black;">3. Cuti Sakit</td><td class="check-col center"> <?= ($cuti->jenis_cuti == 'Cuti Sakit') ? '<span class="check">✓</span>' : '' ?></td>
            <td style="border-right: 1px solid black;">4. Cuti Melahirkan</td><td class="check-col center"><?= ($cuti->jenis_cuti == 'Cuti Melahirkan') ? '<span class="check">✓</span>' : '' ?></td>
        </tr>
        <tr>
            <td style="border-right: 1px solid black;">5. Cuti Karena Alasan Penting</td><td class="check-col center"> <?= ($cuti->jenis_cuti == 'Cuti Karena Alasan Penting') ? '<span class="check">✓</span>' : '' ?></td>
            <td style="border-right: 1px solid black;">6. Cuti di Luar Tanggungan Negara</td><td class="check-col center"> <?= ($cuti->jenis_cuti == 'Cuti di Luar Tanggungan Negara') ? '<span class="check">✓</span>' : '' ?></td>
        </tr>

        <tr><td colspan="4" class="sub-header">&nbsp;III. ALASAN CUTI</td></tr>
        <tr><td colspan="4" style="height: 15px;"><?= $cuti->alasan_cuti ?></td></tr>

        <tr><td colspan="4" class="sub-header">&nbsp;IV. LAMANYA CUTI</td></tr>
        <tr>
            <td colspan="2">Selama <?= $cuti->lama_cuti ?></td>
            <td colspan="2">Mulai tanggal <?= date('d-m-Y', strtotime($cuti->tanggal_mulai)) ?> s/d <?= date('d-m-Y', strtotime($cuti->tanggal_akhir)) ?></td>
        </tr>

        <tr><td colspan="4" class="sub-header">&nbsp;V. CATATAN CUTI</td></tr>
        <tr>
            <td colspan="2" style="padding:0; vertical-align:top;">
                <table class="no-border" style="width:100%;">
                    <tr><td class="strong center" width="50%" style="border-bottom:1px solid black; border-right:1px solid black;">TAHUN</td><td class="strong center" width="50%" style="border-bottom:1px solid black;">SISA</td></tr>
                    <tr><td class="center" style="height:18px; border-bottom:1px solid black; border-right:1px solid black;">N - 2</td><td style="border-bottom:1px solid black;"></td></tr>
                    <tr><td class="center" style="height:18px; border-bottom:1px solid black; border-right:1px solid black;">N - 1</td><td style="border-bottom:1px solid black;"></td></tr>
                    <tr><td class="center" style="height:18px; border-bottom:1px solid black; border-right:1px solid black;">N    </td><td style="border-bottom:1px solid black;"></td></tr>
                </table>
            </td>
            <td colspan="2" style="padding:0; vertical-align:top;">
                 <table class="no-border" style="width:100%;">
                    <tr><td colspan="2" class="strong center" style="border-bottom:1px solid black;">KETERANGAN</td></tr>
                    <?php
                        $keterangan_cuti = ['Cuti Besar', 'Cuti Sakit', 'Cuti Melahirkan', 'Cuti Karena Alasan Penting', 'Cuti di Luar Tanggungan Negara'];
                        foreach ($keterangan_cuti as $i => $value) {
                            $is_last = ($i == count($keterangan_cuti) - 1);
                            $border_style = $is_last ? '' : 'border-bottom:1px solid black;';
                            echo '<tr style="height:19.2px;"><td style="padding:2px 4px; '.$border_style.' border-right:1px solid black;">'.($i+8).'. '.strtoupper($value).'</td><td class="center" style="width:10%; '.$border_style.'">'.($cuti->jenis_cuti == $value ? '<span class="check">✓</span>' : '').'</td></tr>';
                        }
                    ?>
                </table>
            </td>
        </tr>

        <tr><td colspan="2" class="sub-header">&nbsp;VI. ALAMAT SELAMA MENJALANKAN CUTI</td><td colspan="2" class="sub-header center">Hormat Saya,</td></tr>
        <tr>
            <td colspan="2" style="height: 75px;"><?= $cuti->alamat_selama_cuti ?><br>Telp/HP. <?= $cuti->no_telp_cuti ?></td>
            <td colspan="2" class="center"><div class="signature-box"></div>(<span class="strong underline"><?= $cuti->nama_pemohon ?></span>)<br>NIP. <?= $cuti->nip_pemohon ?></td>
        </tr>
        
        <tr><td colspan="4" style="padding:0;">
            <table class="no-border" style="width:100%;">
                <tr>
                    <td style="width:50%; padding:0; border-right:1px solid black;">
                        <table class="no-border" style="width:100%;">
                            <tr><td class="sub-header" style="border:none; border-bottom:1px solid black;">&nbsp;VII. PERTIMBANGAN ATASAN LANGSUNG**</td></tr>
                            <tr><td class="center" style="height:25px; border-bottom:1px solid black;"> DISETUJUI/PERUBAHAN/DITANGGUHKAN/TIDAK DISETUJUI****</td></tr>
                            <tr><td class="center" style="height:80px;">Hormat Saya, <div class="signature-box"></div>(<span class="strong underline"><?= $kepala_sekolah->nama ?? '' ?></span>)<br>NIP. <?= $kepala_sekolah->nip ?? '' ?></td></tr>
                        </table>
                    </td>
                    <td style="width:50%; padding:0;">
                         <table class="no-border" style="width:100%;">
                            <tr><td class="sub-header" style="border:none; border-bottom:1px solid black;">&nbsp;VIII. KEPUTUSAN PEJABAT YANG BERWENANG...**</td></tr>
                            <tr><td class="center" style="height:25px; border-bottom:1px solid black;"> DISETUJUI/PERUBAHAN/DITANGGUHKAN/TIDAK DISETUJUI***</td></tr>
                            <tr><td class="center" style="height:80px;">
                                <div><?= $cuti->jabatan_atasan1 ?></div>
                                <div class="signature-box"></div>
                                (<span class="strong underline"><?= $cuti->nama_atasan1 ?></span>)<br>NIP. <?= $cuti->nip_atasan1 ?>
                            </td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td></tr>

        <tr>
            <td colspan="4" style="padding:3;">
                <table class="no-border" style="width:100%;">
                    <tr>
                        <td style="width:50%;"></td>
                        <td style="width:50%;" class="center" style="height:80px;">
                            <div><?= $cuti->jabatan_atasan2 ?></div>
                            <div class="signature-box"></div>
                            (<span class="strong underline"><?= $cuti->nama_atasan2 ?></span>)
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>