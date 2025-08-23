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
                            <a class="nav-link active" href="<?= base_url('RiwayatPendidikan/index/' . $id_pegawai) ?>">Riwayat Pendidikan</a>
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
                            <a class="nav-link" href="<?= base_url('RiwayatStatusKerja/index/' . $id_pegawai) ?>">Riwayat Bekerja</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Riwayat Pendidikan Pegawai</h5>
                        <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                        <button data-toggle="modal" data-target="#tambahPendidikan" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Tambah Riwayat
                        </button>
                        <?php endif; ?>
                    </div>

                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Jurusan/Prodi</th>
                                <th>Tahun Lulus</th>
                                <th>Tingkat Ijazah</th>
                                <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                    <th>Action</th>
                                <?php endif; ?>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($riwayat_pendidikan)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted font-italic">
                                        Tidak ada data riwayat pendidikan untuk ditampilkan.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php $no = 1;
                                foreach ($riwayat_pendidikan as $index => $rp) : ?>
                                    <tr class="text-center">
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <?= $rp->nama_jurusan ?? '-' ?>
                                            <?php if ($index === 0) : ?>
                                                <span class="badge badge-success ml-2">Terbaru</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $rp->tahun_lulus ?? '-' ?></td>
                                        <td><?= $rp->tingkat_ijazah ?? '-' ?></td>
                                        <?php if ($pegawai->pegawai_status == 1 && $this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editPendidikan<?= $rp->id_riwayat_pendidikan_pegawai ?>" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#hapusPendidikan<?= $rp->id_riwayat_pendidikan_pegawai ?>" title="Hapus">
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

<div class="modal fade" id="tambahPendidikan" tabindex="-1" aria-labelledby="tambahPendidikanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahPendidikanLabel">Tambah Riwayat Pendidikan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('RiwayatPendidikan/tambah') ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">

                    <div class="form-group">
                        <label class="font-weight-bold">Nama Jurusan/Prodi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_jurusan" placeholder="Masukkan Nama Jurusan/Prodi" required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Tahun Lulus <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tahun_lulus" placeholder="Contoh: 2020" maxlength="4" required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Tingkat Ijazah <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="tingkat_ijazah" required>
                            <option value="">Pilih Tingkat</option>
                            <option value="SMA/SMK">SMA/SMK</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
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


<?php foreach ($riwayat_pendidikan as $rp) : ?>
    <div class="modal fade" id="editPendidikan<?= $rp->id_riwayat_pendidikan_pegawai ?>" tabindex="-1" aria-labelledby="editPendidikanLabel<?= $rp->id_riwayat_pendidikan_pegawai ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editPendidikanLabel<?= $rp->id_riwayat_pendidikan_pegawai ?>">Edit Riwayat Pendidikan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('RiwayatPendidikan/edit/' . $rp->id_riwayat_pendidikan_pegawai) ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                        <input type="hidden" name="id_riwayat_pendidikan_pegawai" value="<?= $rp->id_riwayat_pendidikan_pegawai ?>">

                        <div class="form-group">
                            <label class="font-weight-bold">Nama Jurusan/Prodi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_jurusan" value="<?= $rp->nama_jurusan ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Tahun Lulus <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tahun_lulus" maxlength="4" value="<?= $rp->tahun_lulus ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Tingkat Ijazah <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="tingkat_ijazah" required>
                                <option value="">Pilih Tingkat</option>
                                <option value="SMA/SMK" <?= ($rp->tingkat_ijazah == 'SMA/SMK') ? 'selected' : '' ?>>SMA/SMK</option>
                                <option value="D3" <?= ($rp->tingkat_ijazah == 'D3') ? 'selected' : '' ?>>D3</option>
                                <option value="S1" <?= ($rp->tingkat_ijazah == 'S1') ? 'selected' : '' ?>>S1</option>
                                <option value="S2" <?= ($rp->tingkat_ijazah == 'S2') ? 'selected' : '' ?>>S2</option>
                                <option value="S3" <?= ($rp->tingkat_ijazah == 'S3') ? 'selected' : '' ?>>S3</option>
                            </select>
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

    <div class="modal fade" id="hapusPendidikan<?= $rp->id_riwayat_pendidikan_pegawai ?>" tabindex="-1" aria-labelledby="modalHapusPendidikanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalHapusPendidikanLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus riwayat pendidikan:</p>
                    <p><strong><?= $rp->nama_jurusan ?> (Lulus: <?= $rp->tahun_lulus ?>)</strong>?</p>
                    <p class="text-muted small">Tindakan ini akan menghapus data secara permanen.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <a href="<?= base_url('RiwayatPendidikan/delete/' . $rp->id_riwayat_pendidikan_pegawai . '/' . $id_pegawai) ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>