<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai SMKN 2 Pekanbaru</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11pt;
        }
        .logo {
            width: 85px;
            height: auto;
        }
        .kop-surat {
            position: relative;
            text-align: center;
            line-height: 1.2;
            margin-bottom: 12px;
        }
        .kop-surat h1 {
            font-size: 18pt; 
            font-weight: bold; 
            margin: 0;
        }

        .kop-surat h4 {
            font-size: 12pt; 
            font-weight: bold; 
            margin: 0;
        }

        .kop-surat p {
            font-size: 10pt; 
            font-weight: normal;
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
        .judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th, .data-table td {
            border: 1px solid black;
            padding: 5px 6px; 
            text-align: left; 
            font-size: 10pt;
        }
        .data-table th {
            text-align: center;
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .data-table .no, .data-table .jenis-kelamin {
            text-align: center;
        }
    </style>
</head>
<body>
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

    <div class="judul">DAFTAR PEGAWAI SMKN 2 PEKANBARU</div>

    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Status</th>
                <th>Jabatan</th>
                <th>Golongan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pegawai as $pg) : ?>
                <tr>
                    <td class="no"><?= $no++ ?></td>
                    <td><?= $pg->nip ?? '-' ?></td>
                    <td><?= $pg->nama ?? '-' ?></td>
                    <td class="jenis-kelamin"><?= $pg->jenis_kelamin ?? '-' ?></td>
                    <td><?= $pg->nama_status ?? '-' ?></td>
                    <td><?= $pg->nama_jabatan ?? '-' ?></td>
                    <td><?= $pg->nama_golongan ?? '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>