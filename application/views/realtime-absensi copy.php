<body class="bg-light" style="margin:0; padding:0;">
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand navbar-dark bg-success" style="margin-bottom:0;">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">
                <img src="<?= base_url('assets/template/') ?>dist/img/logosmk.png" alt="Logo" class="brand-image img-circle elevation-2" style="height:32px;">
                <span class="brand-text font-weight-bold text-white ml-2">SisWai SMKN 2 PKU</span>
            </a>
            <ul class="navbar-nav ml-auto">
                <!-- <li class="nav-item">
                    <span class="nav-link text-white">Hallo, <?= $this->session->userdata('user') ?></span>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('Login/logout') ?>" class="nav-link text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li> -->
            </ul>
        </div>
    </nav>
    <!-- End Header -->

    <div class="container-fluid mt-4" style="padding-top:0;">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="text-center mb-4">
                    <h2 class="font-weight-bold text-success">Absensi Realtime Pegawai</h2>
                    <p class="text-muted">Data absensi pegawai yang masuk secara realtime</p>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-striped" id="realtimeAbsensiTable">
                            <thead class="thead-success bg-success text-white">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($absensi as $row): ?>
                                    <tr class="text-center">
                                        <td><?= $i++ ?></td>
                                        <td><?= $row->name ?></td>
                                        <td><?= $row->nip ?? '-' ?></td>
                                        <td><?= htmlspecialchars($row->nama_jabatan ?? 'N/A'); ?></td>
                                        <td><?= isset($row->tanggal) ? date('d-m-Y', strtotime($row->tanggal)) : '-' ?></td>
                                        <td><?= $row->jam ? date('H:i:s', strtotime($row->jam)) : '-' ?></td>
                                        <td>
                                            <?php
                                            if ($row->jam) {
                                                if ($row->jam > '08:00:00' && $row->jam < '12:00:00') {
                                                    echo '<span class="badge badge-danger">Terlambat</span>';
                                                } elseif ($row->jam <= '08:00:00') {
                                                    echo '<span class="badge badge-success">Tepat Waktu</span>';
                                                } elseif ($row->jam >= '12:00:00' && $row->jam < '15:30:00') {
                                                    echo '<span class="badge badge-warning">Pulang Cepat</span>';
                                                } elseif ($row->jam >= '15:30:00') {
                                                    echo '<span class="badge badge-primary">Pulang Normal</span>';
                                                } else {
                                                    echo '<span class="badge badge-secondary">Absen</span>';
                                                }
                                            } else {
                                                echo '<span class="badge badge-secondary">Belum Absen</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($absensi)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Belum ada data absensi realtime.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted" style="font-size:13px;">
                    &copy; <?= date('Y') ?> SMKN 2 Pekanbaru - Realtime Absensi
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: DataTables & Bootstrap JS -->
    <script src="<?= base_url('assets/template') ?>/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/template') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- <script>
        $(document).ready(function() {
            $('#realtimeAbsensiTable').DataTable({
                "order": [
                    [4, "asc"],
                    [5, "desc"]
                ],
                "pageLength": 10
            });
        });
    </script> -->
    <script>
        $(document).ready(function() {
            $('#realtimeAbsensiTable').DataTable({
                "ajax": {
                    "url": "<?= base_url('RealtimeAbsensi/get_realtime_json') ?>",
                    "dataSrc": "data"
                },
                "columns": [{
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "name",
                        "defaultContent": "-"
                    },
                    {
                        "data": "nip",
                        "defaultContent": "-"
                    },
                    {
                        "data": "nama_jabatan",
                        "defaultContent": "-"
                    },
                    {
                        "data": "tanggal",
                        "render": function(data) {
                            return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                        }
                    },
                    {
                        "data": "jam",
                        "render": function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        "data": "jam",
                        "render": function(data, type, row) {
                            if (data) {
                                if (data > '08:00:00' && data < '12:00:00') {
                                    return '<span class="badge badge-danger">Terlambat</span>';
                                } else if (data <= '08:00:00') {
                                    return '<span class="badge badge-success">Tepat Waktu</span>';
                                } else if (data >= '12:00:00' && data < '15:30:00') {
                                    return '<span class="badge badge-warning">Pulang Cepat</span>';
                                } else if (data >= '15:30:00') {
                                    return '<span class="badge badge-primary">Pulang Normal</span>';
                                } else {
                                    return '<span class="badge badge-secondary">Absen</span>';
                                }
                            } else {
                                return '<span class="badge badge-secondary">Belum Absen</span>';
                            }
                        }
                    }
                ],
                "order": [
                    [4, "desc"],
                    [5, "desc"]
                ],
                "pageLength": 10,
                "responsive": true
            });

            // Auto refresh data setiap 5 detik
            setInterval(function() {
                $('#realtimeAbsensiTable').DataTable().ajax.reload(null, false);
            }, 5000);
        });
    </script>
</body>