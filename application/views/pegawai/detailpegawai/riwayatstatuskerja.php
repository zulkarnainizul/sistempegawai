<section class="content">
  <div class="row">
    <div class="col-12">
  <div class="card">
    <div class="card-header">
        <ul class="nav nav-pills">
            <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Pegawai/detailpegawai/' . $id_pegawai) ?>">Informasi Pegawai</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?= base_url('RiwayatPendidikan/index/' . $id_pegawai) ?>">Riwayat Pendidikan</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?= base_url('RiwayatGolongan/index/' . $id_pegawai) ?>">Riwayat Golongan</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?= base_url('RiwayatJabatan/index/' . $id_pegawai) ?>">Riwayat Jabatan</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?= base_url('RiwayatStatusPegawai/index/' . $id_pegawai) ?>">Riwayat Status</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" href="<?= base_url('RiwayatStatusKerja/index/' . $id_pegawai) ?>">Riwayat Bekerja</a>
            </li>
        </ul>
    </div>

    <div class="card-body"> 
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Riwayat Status Kerja</h5>
      </div>

      <table class="table table-bordered table-striped">  
        <thead class="text-center">
          <tr>
            <th>No</th>
            <th>Status Kerja</th>
            <th>TMT Kerja</th>
          </tr>
        </thead>

        <tbody>
            <?php if (empty($riwayat_status_kerja)): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted font-italic">
                        Tidak ada data riwayat status kerja untuk ditampilkan.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($riwayat_status_kerja as $index => $rsk) : ?>
                    <tr class="text-center">
                        <td><?= $no++ ?></td>
                        <td>
                            <?= $rsk->jenis_status_kerja ?? '-' ?>
                            <?php if ($index === 0): ?>
                                <span class="badge badge-success ml-2">Terbaru</span>
                            <?php endif; ?>
                        </td>
                        <td><?= format_tanggal($rsk->tmt_status_kerja)?> </td>
                    </tr>
                <?php endforeach ?>
            <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</section>
