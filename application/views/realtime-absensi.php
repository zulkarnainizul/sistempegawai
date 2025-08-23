<body class="bg-light" style="margin:0; padding:0;">
    <nav class="navbar navbar-expand navbar-dark bg-success" style="margin-bottom:0;">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">
                <img src="<?= base_url('assets/template/') ?>dist/img/logosmk.png" alt="Logo" class="brand-image img-circle elevation-2" style="height:32px;">
                <span class="brand-text font-weight-bold text-white ml-2">SisWai SMKN 2 PKU</span>
            </a>
            <ul class="navbar-nav ml-auto">
                </ul>
        </div>
    </nav>
    <div class="container-fluid mt-4" style="padding-top:0;">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="text-center mb-4">
                    <h2 class="font-weight-bold text-success">Absensi Realtime Pegawai</h2>
                    <p class="text-muted">Data absensi pegawai terbaru yang diperbarui secara otomatis.</p>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-striped w-100" id="realtimeAbsensiTable">
                            <thead class="thead-success">
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

    <script src="<?= base_url('assets/template/') ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/template/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/template/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/template/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
    $(document).ready(function() {
        toastr.options = {  
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000", 
        };
        
        let latestKnownId = null;
        
        var table = $('#realtimeAbsensiTable').DataTable({
            // 1. Matikan pesan "processing..." bawaan
            "processing": false, 
            
            "ajax": {
                "url": "<?= base_url('RealtimeAbsensi/get_realtime_json') ?>",
                // 2. Kita gunakan dataSrc untuk "mencegat" data sebelum ditampilkan
                "dataSrc": function(json) {
                    // Pastikan ada data yang diterima
                    if (!json.data || json.data.length === 0) {
                        return [];
                    }

                    // Ambil data absensi paling baru (ada di baris pertama karena query diurutkan)
                    const latestRecord = json.data[0];
                    const newLatestId = latestRecord.id; // Pastikan ada kolom 'id' unik di data Anda

                    // 3. Logika untuk menampilkan notifikasi
                    // 'latestKnownId !== null' -> agar notifikasi tidak muncul saat pertama kali halaman dimuat
                    // 'newLatestId !== latestKnownId' -> jika ID terbaru berbeda dari yang kita simpan
                    if (latestKnownId !== null && newLatestId !== latestKnownId) {
                        // 1. Buat objek waktu saat ini juga
                        const now = new Date();

                        // 2. Format jam, menit, dan detik
                        const hours = ('0' + now.getHours()).slice(-2);
                        const minutes = ('0' + now.getMinutes()).slice(-2);
                        const seconds = ('0' + now.getSeconds()).slice(-2);
                        const formattedTime = `${hours}:${minutes}:${seconds}`;

                        toastr.success( 
                            latestRecord.name + ' berhasil melakukan absensi pada pukul ' + formattedTime
                        );
                    }   
                    latestKnownId = newLatestId;

                    return json.data;
                }   
            },
            "columns": [
                { "data": null, "className": "text-center", "orderable": false, "searchable": false, "render": function (data, type, row, meta) {
                    return meta.row + 1;
                }},
                { "data": "name" },
                { "data": "nip", "defaultContent": "-" },
                { "data": "nama_jabatan", "defaultContent": "N/A" },
                { "data": "tanggal", "className": "text-center", "render": function(data) {
                    if (!data) return '-';
                    let date = new Date(data);
                    let day = ('0' + date.getDate()).slice(-2);
                    let month = ('0' + (date.getMonth() + 1)).slice(-2);
                    let year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                }},
                { "data": "jam", "className": "text-center" },
                { "data": "jam", "className": "text-center", "render": function(data) {
                    if (data) {
                        if (data > '08:00:00' && data < '12:00:00') {
                            return '<span class="badge badge-danger">Terlambat</span>';
                        } else if (data <= '08:00:00') {
                            return '<span class="badge badge-success">Tepat Waktu</span>';
                        } else if (data >= '15:30:00') {
                            return '<span class="badge badge-primary">Pulang Normal</span>';
                        } else if (data >= '12:00:00') {
                            return '<span class="badge badge-warning">Pulang Cepat</span>';
                        }
                    }
                    return '<span class="badge badge-secondary">Belum Absen</span>';
                }}
            ],
            "order": [
                [4, "desc"], 
                [5, "desc"]
            ],
            "pageLength": 10,
            "responsive": true,
            "searching": false,
            "lengthChange": false,
            "info": true,
            "language": {
                "emptyTable": "Tidak ada data absensi",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
            }
        });

        setInterval(function() {
            table.ajax.reload(null, false);
        }, 3000);
    });
    </script>   
</body>
</html>