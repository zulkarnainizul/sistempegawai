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
                            <a class="nav-link active" href="<?= base_url('RiwayatGolongan/index/' . $id_pegawai) ?>">Riwayat Golongan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('RiwayatJabatan/index/' . $id_pegawai) ?>">Riwayat Jabatan</a>
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
                        <h5 class="mb-0">Riwayat Golongan Pegawai</h5>
                        <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                            <button data-toggle="modal" data-target="#tambahrg" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Tambah Riwayat
                            </button>
                        <?php endif; ?>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Golongan</th>
                                <th>TMT Golongan</th>
                                <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($riwayat_golongan)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted font-italic">
                                        Tidak ada data riwayat golongan untuk ditampilkan.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php $no = 1;
                                foreach ($riwayat_golongan as $index => $rg) : ?>
                                    <tr class="text-center">
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?= $rg->nama_golongan ?? '-' ?>
                                            <?php if ($index === 0) : ?>
                                                <span class="badge badge-success ml-2">Terbaru</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= format_tanggal($rg->tmt_golongan) ?></td>
                                        <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editRG<?= $rg->id_riwayat_golongan_pegawai ?>" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusRG<?= $rg->id_riwayat_golongan_pegawai ?>" title="Hapus">
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

<div class="modal fade" id="tambahrg" tabindex="-1" aria-labelledby="modalTambahRGLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTambahRGLabel">Tambah Riwayat Golongan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="<?= base_url('RiwayatGolongan/tambah') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                    <div class="form-group">
                        <label for="golongan" class="font-weight-bold">Golongan Pegawai <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="golongan" name="id_golongan" required>
                            <option value="">Pilih Golongan</option>
                            <?php foreach ($golongan as $gl) : ?>
                                <option value="<?= $gl->id_golongan ?>" <?= set_select('id_golongan', $gl->id_golongan); ?>><?= $gl->nama_golongan ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_golongan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">TMT Golongan <span class="text-danger">*</span></label>
                        <input type="date" name="tmt_golongan" class="form-control" required>
                        <?= form_error('tmt_golongan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
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

<?php foreach ($riwayat_golongan as $rg) : ?>
    <div class="modal fade" id="editRG<?= $rg->id_riwayat_golongan_pegawai ?>" tabindex="-1" aria-labelledby="modalEditRGLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditRGLabel">Edit Riwayat Golongan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url('RiwayatGolongan/edit/' . $rg->id_riwayat_golongan_pegawai) ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                        <input type="hidden" name="id_riwayat_golongan_pegawai" value="<?= $rg->id_riwayat_golongan_pegawai ?>">

                        <div class="form-group">
                            <label class="font-weight-bold">Golongan <span class="text-danger">*</span></label>
                            <select name="id_golongan" class="form-control select2" required>
                                <option value="">Pilih Golongan</option> 
                                <?php foreach ($golongan as $gl) : ?>
                                    <option value="<?= $gl->id_golongan ?>" <?= $gl->id_golongan == $rg->id_golongan ? 'selected' : '' ?>>
                                        <?= $gl->nama_golongan ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <?= form_error('id_golongan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">TMT Golongan <span class="text-danger">*</span></label>
                            <input type="date" name="tmt_golongan" class="form-control" value="<?= $rg->tmt_golongan ?>" required>
                            <?= form_error('tmt_golongan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
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

    <div class="modal fade" id="hapusRG<?= $rg->id_riwayat_golongan_pegawai ?>" tabindex="-1" aria-labelledby="modalHapusRGLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusRGLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus riwayat golongan:</p>
                    <p><strong><?= $rg->nama_golongan ?></strong>?</p>
                    <p class="text-muted small">Tindakan ini akan menghapus data secara permanen.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <a href="<?= base_url('RiwayatGolongan/delete/' . $rg->id_riwayat_golongan_pegawai . '/' . $id_pegawai) ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>