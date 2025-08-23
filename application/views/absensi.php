<!-- Alert Pesan Berhasil -->
<?= $this->session->flashdata('pesan');?>
<!-- Isi Data -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Button Tambah -->
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><h5>Tabel Data Absensi</h5></span>
                        <?php if ($this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                            <div>
                                <button type="button" class="btn btn-secondary btn-sm mr-2" data-toggle="modal" data-target="#modalCetakAbsensi">
                                    <i class="fas fa-print"></i> Cetak Laporan Absensi
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Body Tabel -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <!-- <th>User ID</th>
                                <th>SN Mesin</th> -->
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (!empty($pegawai_absensi)) :
                                foreach ($pegawai_absensi as $pg) : ?>
                                    <tr class="text-center">
                                        <td><?= $no++ ?></td>
                                        <!-- <td><?= $pg -> userid ?></td>
                                        <td><?= $pg -> SN ?></td> -->
                                        <td><?= htmlspecialchars($pg->nip ?? 'N/A'); ?></td>
                                        <td class="text-left"><?= htmlspecialchars($pg->name); ?></td>
                                        <td class="text-left"><?= htmlspecialchars($pg->nama_jabatan ?? 'N/A'); ?></td>
                                        <td>
                                            <a href="<?= site_url('Absensi/detail_absen/' . $pg->userid) ?>" class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-info-circle"></i> Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            else : ?>
                                <tr>
                                    <td colspan="5">Tidak ada data pegawai di mesin absensi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

<div class="modal fade" id="modalCetakAbsensi" tabindex="-1" role="dialog" aria-labelledby="modalCetakLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalCetakLabel"><i class="fas fa-print"></i>  Cetak Laporan Rekapitulasi Absensi</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('laporan/excel_absensi') ?>" method="post" target="_blank">
                <div class="modal-body">
                    <p>Silakan pilih rentang tanggal untuk membuat laporan Excel.</p>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date" class="font-weight-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date" class="font-weight-bold">Tanggal Akhir <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Buat Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>