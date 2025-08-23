<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $total_pegawai_aktif + $total_pegawai_tidak_aktif; ?></h3>
                        <p>Total Pegawai</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $total_pegawai_aktif; ?></h3>
                        <p>Pegawai Aktif</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-check"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $total_pegawai_tidak_aktif; ?></h3>
                        <p>Pegawai Tidak Aktif</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-slash"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $kehadiran_hari_ini; ?></h3>
                        <p>Kehadiran Hari Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-clipboard-check"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header border-0">
                        <h3 class="card-title">Statistik Kehadiran Pegawai</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Dashboard'); ?>" method="GET" class="form-inline mb-3">
                            <div class="form-group">
                                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $active_start_date; ?>">
                            </div>
                            <div class="form-group mx-sm-3">
                                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $active_end_date; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        <div class="position-relative" style="height: 350px;">
                            <canvas id="attendance-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header border-0">
                        <h3 class="card-title">Pegawai Berdasarkan Golongan</h3>
                    </div>
                    <div class="card-body">
                                <div class="position-relative" style="height: 350px;">
                            <canvas id="rank-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card" style="height: 400px;">
                    <div class="card-header border-0">
                        <h3 class="card-title">Pegawai Berdasarkan Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="position-relative h-100">
                            <canvas id="status-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card" style="height: 400px;">
                    <div class="card-header border-0">
                        <h3 class="card-title">Pegawai Berdasarkan Jabatan</h3>
                    </div>
                    <div class="card-body">
                        <div class="position-relative h-100">
                            <canvas id="position-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            
        </div> 
    
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Palet warna statis untuk menggantikan fungsi warna acak
    // Anda bisa menambah atau mengubah warna di sini sesuai selera
    const colorPalette = [
        '#3498db', '#2ecc71', '#f1c40f', '#e74c3c', '#9b59b6',
        '#34495e', '#1abc9c', '#e67e22', '#7f8c8d', '#f39c12',
        '#d35400', '#c0392b', '#bdc3c7', '#8e44ad', '#27ae60'
    ];

    // 1. Grafik Pegawai Berdasarkan Jabatan
    const positionLabels = <?= json_encode(array_column($summary_jabatan, 'nama_jabatan')); ?>;
    const positionData = <?= json_encode(array_column($summary_jabatan, 'total')); ?>;
    new Chart(document.getElementById('position-chart'), {
        type: 'bar',
        data: {
            labels: positionLabels,
            datasets: [{
                label: 'Jumlah Pegawai',
                data: positionData,
                backgroundColor: colorPalette // MENGGUNAKAN PALET STATIS
            }]
        },
        options: {
            // -- MULAI PERUBAHAN --
            responsive: true,
            maintainAspectRatio: false,
            // -- AKHIR PERUBAHAN --
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Opsional: Memastikan skala Y hanya menampilkan bilangan bulat (1, 2, 3,...)
                        // karena jumlah pegawai tidak mungkin desimal.
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // 2. Grafik Pegawai Berdasarkan Status
    const statusLabels = <?= json_encode(array_column($summary_status, 'nama_status')); ?>;
    const statusData = <?= json_encode(array_column($summary_status, 'total')); ?>;
    new Chart(document.getElementById('status-chart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: colorPalette // MENGGUNAKAN PALET STATIS
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });

    // 3. Grafik Pegawai Berdasarkan Golongan
    const rankLabels = <?= json_encode(array_column($summary_golongan, 'nama_golongan')); ?>;
    const rankData = <?= json_encode(array_column($summary_golongan, 'total')); ?>;
    new Chart(document.getElementById('rank-chart'), {
        type: 'pie',
        data: {
            labels: rankLabels,
            datasets: [{
                data: rankData,
                backgroundColor: colorPalette // MENGGUNAKAN PALET STATIS
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
    
    // 4. Grafik Statistik Kehadiran (Kode ini tidak diubah karena sudah menggunakan warna statis)
    <?php
        $attendance_labels = [];
        foreach (array_keys($statistik_kehadiran) as $tanggal) {
            $day_name = ['Sun'=>'Min','Mon'=>'Sen','Tue'=>'Sel','Wed'=>'Rab','Thu'=>'Kam','Fri'=>'Jum','Sat'=>'Sab'];
            $attendance_labels[] = $day_name[date('D', strtotime($tanggal))] . ', ' . date('d M', strtotime($tanggal));
        }
        $attendance_data = array_values($statistik_kehadiran);
    ?>
    const attendanceLabels = <?= json_encode($attendance_labels); ?>;
    const attendanceData = <?= json_encode($attendance_data); ?>;

    new Chart(document.getElementById('attendance-chart'), {
        type: 'line',
        data: {
            labels: attendanceLabels,
            datasets: [{
                label: 'Jumlah Kehadiran',
                data: attendanceData,
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>