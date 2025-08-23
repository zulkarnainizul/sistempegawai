<?= $this->session->flashdata('pesan'); ?>
<!-- Isi Data -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Button Tambah -->
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>
                            <h5>Tabel Data Absensi</h5>
                        </span>
                        <span>
                            <a href="<?= base_url('Absensi') ?>" class="btn btn-warning btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Nama:</strong> <?= $pegawai->nama ?? 'N/A' ?>
                        </div>
                        <div class="col-md-4">
                            <strong>NIP:</strong> <?= $pegawai->nip ?? 'N/A' ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Jabatan:</strong> <?= $pegawai->nama_jabatan ?? 'N/A' ?>
                        </div>
                    </div>
                    <!-- Filter Tanggal -->
                    <form method="get" action="" class="mt-3">
                        <?php
                        $date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d');
                        $date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d', strtotime('-6 days'));
                        ?>
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label for="date_start">Tanggal Awal</label>
                                <input type="date" id="date_start" name="date_start" class="form-control" value="<?= $date_start ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="date_end">Tanggal Akhir</label>
                                <input type="date" id="date_end" name="date_end" class="form-control" value="<?= $date_end ?>">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary mt-2">Filter</button>
                                <a href="<?= current_url(); ?>" class="btn btn-secondary mt-2">Reset</a>
                            </div>
                        </div>
                    </form>
                    <!-- End Filter Tanggal -->
                </div>

                <!-- Body Tabel -->
                <div class="card-body">

                    <?= $this->session->flashdata('message'); ?>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                                <?php if ($this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (!empty($absensi)): ?>
                                <?php foreach ($absensi as $row): ?>
                                    <tr class="text-center">
                                        <td><?php echo $i ?></td>
                                        <td><?= date('Y-m-d', strtotime($row->tanggal)); ?></td>
                                        <td><?= $row->jam_masuk ? date('H:i:s', strtotime($row->jam_masuk)) : '-'; ?></td>
                                        <td><?= $row->jam_keluar ? date('H:i:s', strtotime($row->jam_keluar)) : '-'; ?></td>
                                        <td>
                                        <?php
                                            // Variabel untuk menampung status masuk dan pulang
                                            $status_masuk = '';
                                            $status_pulang = '';

                                            // --- Logika untuk Status Masuk ---
                                            if ($row->jam_masuk) {
                                                if (strtotime($row->jam_masuk) > strtotime('07:30:59')) {
                                                    $status_masuk = '<span class="badge badge-danger">Terlambat</span>';
                                                } else {
                                                    $status_masuk = '<span class="badge badge-success">Tepat Waktu</span>';
                                                }
                                            } else {
                                                $status_masuk = '<span class="badge badge-secondary">Tidak Masuk</span>';
                                            }
                                            
                                            // --- Logika untuk Status Pulang ---
                                            if ($row->jam_keluar && $row->jam_masuk != $row->jam_keluar) {
                                                if (strtotime($row->jam_keluar) < strtotime('15:30:00')) {
                                                    $status_pulang = '<span class="badge badge-warning">Pulang Cepat</span>';
                                                } else {
                                                    $status_pulang = '<span class="badge badge-primary">Pulang Normal</span>';
                                                }
                                            } else {
                                                // =================================================================
                                                // PERBAIKAN: Logika baru berdasarkan tanggal
                                                // =================================================================
                                                $tanggal_absen = date('Y-m-d', strtotime($row->tanggal));
                                                $tanggal_hari_ini = date('Y-m-d');

                                                if ($tanggal_absen == $tanggal_hari_ini && $row->jam_masuk) {
                                                    // Jika absen hari ini dan sudah ada jam masuk
                                                    $status_pulang = '<span class="badge badge-info">Belum Absen Pulang</span>';
                                                } else {
                                                    // Jika tanggal sudah lewat atau belum masuk sama sekali
                                                    $status_pulang = '<span class="badge badge-secondary">Tidak Absen Pulang</span>';
                                                }
                                            }

                                            // Tampilkan kedua status dengan pemisah
                                            echo $status_masuk . ' | ' . $status_pulang;
                                        ?>
                                    </td>

                                        <?php if ($this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                                            <td><button data-toggle="modal" data-toggle="tooltip" title="Edit1"
                                                    data-target="#edit1<?= $row->id1 ?>" class="btn btn-success btn-sm">Change In
                                                    </i></button>
                                                <button data-toggle="modal" data-toggle="tooltip" title="Edit2"
                                                    data-target="#edit2<?= $row->id2 ?>" class="btn btn-warning btn-sm">Change out
                                                    </i></button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php $i++;
                                endforeach; ?>
                            <?php else: ?>
                                <tr class="text-center">
                                    <td colspan="6">Tidak ada data absensi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <?php
                    $total_pages = ceil($total / $limit);
                    if ($total_pages > 1): ?>
                        <nav>
                            <ul class="pagination">
                                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                                    <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
                                        <a class="page-link"
                                            href="<?= current_url() . '?date_start=' . $date_start . '&date_end=' . $date_end . '&page=' . $p ?>">
                                            <?= $p ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

<!-- Modal Edit 1-->
<?php foreach ($absensi as $jb) { ?>
    <div class="modal fade" id="edit1<?= $jb->id1 ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Absen Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('Absensi/catat_waktu/' . $jb->id1) ?>" method="POST">
                        <input type="hidden" name="jenis_aksi" value="masuk">
                        
                        <p>Anda yakin ingin mencatat waktu <strong>masuk</strong> sekarang?</p>
                        <p>Waktu server saat ini akan otomatis disimpan.</p>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Ya, Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<!-- Modal Edit 2-->
<?php foreach ($absensi as $jb) { ?>
    <div class="modal fade" id="edit2<?= $jb->id2 ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jam Keluar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('Absensi/edit2/' . $jb->id2) ?>" method="POST">
                        <input type="hidden" value="<?= $userid; ?>" name="userid">
                        <input type="hidden" value="edit2" name="jenis">
                        
                        <div class="form-group">
                            <label for="tanggal_keluar_<?= $jb->id2 ?>">Tanggal</label>
                            <input type="date" id="tanggal_keluar_<?= $jb->id2 ?>" name="tanggal" class="form-control"
                                   value="<?= date('Y-m-d', strtotime($jb->tanggal)); ?>">
                            <?= form_error('tanggal', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>

                        <div class="form-group">
                            <label for="jam_keluar_<?= $jb->id2 ?>">Jam Keluar</label>
                            <input type="time" id="jam_keluar_<?= $jb->id2 ?>" name="jam" class="form-control" step="1"
                                   value="<?= $jb->jam_keluar ? date('H:i:s', strtotime($jb->jam_keluar)) : ''; ?>">
                            <?= form_error('jam', '<div class="text-small text-danger">', '</div>'); ?>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-save"></i> Simpan</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                <i class="fas fa-times"></i> Tutup
                            </button>
                        </div>
                    </form>
                </div>
                </div>
        </div>
    </div>
<?php } ?>
</html>