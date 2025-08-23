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
                            <a class="nav-link" href="<?= base_url('RiwayatJabatan/index/' . $id_pegawai) ?>">Riwayat Jabatan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= base_url('RiwayatStatusPegawai/index/' . $id_pegawai) ?>">Riwayat Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('RiwayatStatusKerja/index/' . $id_pegawai) ?>">Riwayat Bekerja</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Riwayat Status Pegawai</h5>
                        <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                            <button data-toggle="modal" data-target="#tambahRSP" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Tambah Riwayat
                            </button>
                        <?php endif; ?>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Status</th>
                                <th>TMT Status</th>
                                <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($riwayat_status_pegawai)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted font-italic">
                                        Tidak ada data riwayat status kepegawaian untuk ditampilkan.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php $no = 1;
                                foreach ($riwayat_status_pegawai as $index => $rsp) : ?>
                                    <tr class="text-center">
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?= $rsp->nama_status ?? '-' ?>
                                            <?php if ($index === 0) : ?>
                                                <span class="badge badge-success ml-2">Terbaru</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= format_tanggal($rsp->tmt_status) ?></td>
                                        <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editRSP<?= $rsp->id_riwayat_status_pegawai ?>" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusRSP<?= $rsp->id_riwayat_status_pegawai ?>" title="Hapus">
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

<div class="modal fade" id="tambahRSP" tabindex="-1" aria-labelledby="tambahRSPLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahRSPLabel">Tambah Riwayat Status</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="<?= base_url('RiwayatStatusPegawai/tambah') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                    <div class="form-group">
                        <label for="status_pegawai" class="font-weight-bold">Status Pegawai <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="status_pegawai" name="id_status_pegawai" required>
                            <option value="">Pilih Status</option>
                            <?php foreach ($status_pegawai as $sp) : ?>
                                <option value="<?= $sp->id_status_pegawai ?>" <?= set_select('id_status_pegawai', $sp->id_status_pegawai); ?>><?= $sp->nama_status ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_status_pegawai', '<div class="text-small text-danger mt-1">', '</div>'); ?>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">TMT Status <span class="text-danger">*</span></label>
                        <input type="date" name="tmt_status" class="form-control" required>
                         <?= form_error('tmt_status', '<div class="text-small text-danger mt-1">', '</div>'); ?>
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

<?php foreach ($riwayat_status_pegawai as $rsp) : ?>
    <div class="modal fade" id="editRSP<?= $rsp->id_riwayat_status_pegawai ?>" tabindex="-1" aria-labelledby="editRSPLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editRSPLabel">Edit Riwayat Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url('RiwayatStatusPegawai/edit/' . $rsp->id_riwayat_status_pegawai) ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                        <input type="hidden" name="id_riwayat_status_pegawai" value="<?= $rsp->id_riwayat_status_pegawai ?>">
                        <div class="form-group">
                            <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                            <select name="id_status_pegawai" class="form-control select2" required>
                                <option value="">Pilih Status</option>
                                <?php foreach ($status_pegawai as $sp) : ?>
                                    <option value="<?= $sp->id_status_pegawai ?>" <?= $sp->id_status_pegawai == $rsp->id_status_pegawai ? 'selected' : '' ?>>
                                        <?= $sp->nama_status ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <?= form_error('id_status_pegawai', '<div class="text-small text-danger mt-1">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">TMT Status <span class="text-danger">*</span></label>
                            <input type="date" name="tmt_status" class="form-control" value="<?= $rsp->tmt_status ?>" required>
                            <?= form_error('tmt_status', '<div class="text-small text-danger mt-1">', '</div>'); ?>
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

    <div class="modal fade" id="hapusRSP<?= $rsp->id_riwayat_status_pegawai ?>" tabindex="-1" aria-labelledby="modalHapusRSPLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusRSPLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus riwayat status:</p>
                    <p><strong><?= $rsp->nama_status ?></strong>?</p>
                    <p class="text-muted small">Tindakan ini akan menghapus data secara permanen.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <a href="<?= base_url('RiwayatStatusPegawai/delete/' . $rsp->id_riwayat_status_pegawai . '/' . $id_pegawai) ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>