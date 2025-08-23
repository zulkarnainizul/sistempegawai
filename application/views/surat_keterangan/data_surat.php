<?= $this->session->flashdata('pesan');?>
<!-- Isi Konten -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
                            <h5 class="m-0 font-weight">Tabel Data Surat Keterangan</h5>
                            <a href="<?= base_url('SuratKeterangan/tambah') ?>" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Surat</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Tgl Pengajuan</th>
                                    <th>Nama Pegawai</th>
                                    <th>Keperluan</th>
                                    <th>Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($surat_keterangan as $sk) : ?>
                                <tr class="text-center">
                                    <td><?= $no++ ?></td>
                                    <td><?= format_tanggal($sk->date_create); ?></td>
                                    <td class="text-left"><?= $sk->nama; ?></td>
                                    <td class="text-left"><?= $sk->keperluan_surat; ?></td>
                                    <td>
                                        <a href="<?= base_url('Laporan/pdf_surat_keterangan/'.$sk->id_surat_keterangan); ?>" class="btn btn-outline-success btn-sm rounded-pill" target="_blank">
                                            <i class="fas fa-print"></i> Cetak
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('SuratKeterangan/detail/' . $sk->id_surat_keterangan) ?>" class="btn btn-outline-secondary btn-sm" title="Detail"><i class="fas fa-info-circle"></i></a>
                                            <a href="<?= base_url('SuratKeterangan/edit/' . $sk->id_surat_keterangan) ?>" class="btn btn-outline-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $sk->id_surat_keterangan ?>" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php foreach ($surat_keterangan as $sk) : ?>
    <div class="modal fade" id="hapus<?= $sk->id_surat_keterangan ?>" tabindex="-1" aria-labelledby="hapusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="hapusLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus surat keterangan dari <strong><?= $sk->nama ?></strong>?</p>
                    <p class="text-muted small">Tindakan ini akan menghapus data surat secara permanen dan tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <a href="<?= base_url('SuratKeterangan/hapus/' . $sk->id_surat_keterangan) ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

</section>

