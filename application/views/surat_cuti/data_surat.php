<?= $this->session->flashdata('pesan');?>
<!-- Isi Konten -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
              <h5 class="m-0 font-weight">Tabel Data Surat Cuti</h5>
              <a href="<?= base_url('SuratCuti/tambah') ?>" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Surat</a>
            </div>
          </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Pemohon</th>
                                    <th>NIP</th>
                                    <th>Jenis Cuti</th>
                                    <th>Lama Cuti</th>
                                    <th>Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($surat_cuti as $cuti) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $cuti->nama_pemohon; ?></td>
                                    <td class="text-center"><?= $cuti->nip_pemohon; ?></td>
                                    <td class="text-center"><?= $cuti->jenis_cuti; ?></td>
                                    <td class="text-center"><?= $cuti->lama_cuti; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('Laporan/pdf_surat_cuti/'.$cuti->id_surat_cuti); ?>" class="btn btn-outline-success btn-sm rounded-pill" target="_blank">
                                            <i class="fas fa-print"></i> Cetak
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="<?= base_url('SuratCuti/detail/' . $cuti->id_surat_cuti) ?>" class="btn btn-outline-secondary btn-sm" title="Detail"><i class="fas fa-info-circle"></i></a>
                                            <a href="<?= base_url('SuratCuti/edit/' . $cuti->id_surat_cuti) ?>" class="btn btn-outline-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $cuti->id_surat_cuti ?>" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php foreach ($surat_cuti as $cuti) : ?>
    <div class="modal fade" id="hapus<?= $cuti->id_surat_cuti ?>" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="hapusLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus surat cuti dari <strong><?= $cuti->nama_pemohon ?></strong>?</p>
                    <p class="text-muted small">Tindakan ini akan menghapus data surat secara permanen dan tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <a href="<?= base_url('SuratCuti/hapus/' . $cuti->id_surat_cuti) ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

</section>

