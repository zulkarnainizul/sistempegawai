<?= $this->session->flashdata('pesan'); ?>
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
                            <a class="nav-link active" href="<?= base_url('RiwayatJabatan/index/' . $id_pegawai) ?>">Riwayat Jabatan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('RiwayatStatusPegawai/index/' . $id_pegawai) ?>">Riwayat Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('RiwayatStatusKerja/index/' . $id_pegawai) ?>">Riwayat Bekerja</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Riwayat Jabatan Pegawai</h5>
                        <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                        <button data-toggle="modal" data-target="#tambahRJ" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Tambah Riwayat
                        </button>
                        <?php endif; ?>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Jabatan</th>
                                <th>Jenis Jabatan</th>
                                <th>TMT Jabatan</th>
                                <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($riwayat_jabatan)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted font-italic">
                                        Tidak ada data riwayat jabatan untuk ditampilkan.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php $no = 1;
                                foreach ($riwayat_jabatan as $index => $rj) : ?>
                                    <tr class="text-center">
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?= $rj->nama_jabatan ?? '-' ?>
                                            <?php if ($index === 0) : ?>
                                                <span class="badge badge-success ml-2">Terbaru</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $rj->jenis_jabatan ?? '-' ?></td>
                                        <td><?= format_tanggal($rj->tmt_jabatan) ?></td>
                                        <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editRJ<?= $rj->id_riwayat_jabatan_pegawai ?>" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusRJ<?= $rj->id_riwayat_jabatan_pegawai ?>" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="tambahRJ" tabindex="-1" aria-labelledby="tambahRJLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahRJLabel">Tambah Riwayat Jabatan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="<?= base_url('RiwayatJabatan/tambah') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                    <div class="form-group">
                        <label for="jabatan" class="font-weight-bold">Jabatan Pegawai <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="jabatan" name="id_jabatan" required>
                            <option value="">Pilih Jabatan</option>
                            <?php foreach ($jabatan as $jb) : ?>
                                <option value="<?= $jb->id_jabatan ?>" <?= set_select('id_jabatan', $jb->id_jabatan); ?>><?= $jb->nama_jabatan ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_jabatan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">TMT Jabatan <span class="text-danger">*</span></label>
                        <input type="date" name="tmt_jabatan" class="form-control" required>
                        <?= form_error('tmt_jabatan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary btn-sm"><i class="fas fa-trash"></i> Reset</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php foreach ($riwayat_jabatan as $rj) : ?>
    <div class="modal fade" id="editRJ<?= $rj->id_riwayat_jabatan_pegawai ?>" tabindex="-1" aria-labelledby="editRJLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editRJLabel">Edit Riwayat Jabatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url('RiwayatJabatan/edit/' . $rj->id_riwayat_jabatan_pegawai) ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_riwayat_jabatan_pegawai" value="<?= $rj->id_riwayat_jabatan_pegawai ?>">
                        <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                        <div class="form-group">
                            <label class="font-weight-bold">Jabatan <span class="text-danger">*</span></label>
                            <select name="id_jabatan" class="form-control select2" required>
                                <option value="">Pilih Jabatan</option> <?php foreach ($jabatan as $jb) : ?>
                                    <option value="<?= $jb->id_jabatan ?>" <?= $jb->id_jabatan == $rj->id_jabatan ? 'selected' : '' ?>>
                                        <?= $jb->nama_jabatan ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <?= form_error('id_jabatan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                             <label class="font-weight-bold">TMT Jabatan <span class="text-danger">*</span></label>
                            <input type="date" name="tmt_jabatan" class="form-control" value="<?= $rj->tmt_jabatan ?>" required>
                             <?= form_error('tmt_jabatan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary btn-sm"><i class="fas fa-trash"></i> Reset</button>
                        <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hapusRJ<?= $rj->id_riwayat_jabatan_pegawai ?>" tabindex="-1" aria-labelledby="modalHapusRJLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusRJLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus riwayat jabatan:</p>
                    <p><strong><?= $rj->nama_jabatan ?></strong>?</p>
                    <p class="text-muted small">Tindakan ini akan menghapus data secara permanen.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <a href="<?= base_url('RiwayatJabatan/delete/' . $rj->id_riwayat_jabatan_pegawai . '/' . $id_pegawai) ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>