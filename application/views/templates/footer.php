  </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer bg-white py-3">
    <div class="container-fluid ">
      <div class="row">
      <p style="margin: 0; font-size: 14px; color: #555;"> &copy; <?= date("Y") ?> <a href="#" style="color: #007bff; text-decoration: none; font-weight: bold;">Kepegawaian</a> SMKN 2 Pekanbaru - made by <span style="color: #007bff; font-weight: bold;">Zulkarnain</span> </p>  
      </div>
    </div>
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url('assets/template') ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/template') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/template') ?>/plugins/select2/js/select2.full.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url('assets/template') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/template') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/template') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/template') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/template') ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/template') ?>/dist/js/demo.js"></script>
<!-- Bootstrap 4 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script> 
<!-- Full Calender -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>


<!-- Script Data Table -->
<script>
  $(document).ready(function() {
    // Inisialisasi DataTable pada tab yang aktif saat halaman dimuat
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    // Fungsi untuk menginisialisasi DataTable
    function initializeDataTable(tableId) {
      $(tableId).DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    }

    // Event listener untuk tab pengajuan cuti
    $('a[href="#pengajuanCuti"]').on('shown.bs.tab', function (e) {
      if (!$.fn.DataTable.isDataTable('#example1')) {
        initializeDataTable('#example1');
      }
    });

    // Event listener untuk tab approve cuti
    $('a[href="#approveCuti"]').on('shown.bs.tab', function (e) {
      if (!$.fn.DataTable.isDataTable('#example2')) {
        initializeDataTable('#example2');
      }
    });

    // Event listener untuk tab data cuti
    $('a[href="#dataCuti"]').on('shown.bs.tab', function (e) {
      if (!$.fn.DataTable.isDataTable('#example3')) {
        initializeDataTable('#example3');
      }
    });

    // Event listener untuk tab data pegawai tidak aktif
    $('a[href="#nonaktif"]').on('shown.bs.tab', function (e) {
      if (!$.fn.DataTable.isDataTable('#example2')) {
        initializeDataTable('#example2');
      }
    });

    // Event listener untuk tab approve SK
    $('a[href="#ajukanSK"]').on('shown.bs.tab', function (e) {
      if (!$.fn.DataTable.isDataTable('#example4')) {
        initializeDataTable('#example4');
      }
    });

    // Event listener untuk tab data SK
    $('a[href="#dataSK"]').on('shown.bs.tab', function (e) {
      if (!$.fn.DataTable.isDataTable('#example5')) {
        initializeDataTable('#example5');
      }
    });

    // Event listener untuk tab data ST
    $('a[href="#dataST"]').on('shown.bs.tab', function (e) {
      if (!$.fn.DataTable.isDataTable('#example8')) {
        initializeDataTable('#example8');
      }
    });

  });
</script>

<!-- Script Select2 -->
<script>
  $(document).ready(function() {
    // Inisialisasi Select2 untuk semua elemen dengan class select2
    $('.select2').select2({
      theme: 'bootstrap4', // Tema Bootstrap 4
      width: '100%' // Lebar 100% dari parent container
    });
  });
</script>

<!-- Script Dashboard --> 
<script>
    $(function () {
        // Data untuk Donut Chart (Pegawai Berdasarkan Gender)
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
        var donutData = {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [
                {
                    data: [<?php echo $pegawai_by_gender[0]->jumlah_pegawai; ?>, <?php echo $pegawai_by_gender[1]->jumlah_pegawai; ?>],
                    backgroundColor: ['#f56954', '#00a65a'],
                }
            ]
        };
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        };
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        });

        

        // Data untuk Bar Chart (Pegawai Berdasarkan Golongan)
        var barChartCanvas = $('#barChart').get(0).getContext('2d');
        var barChartData = {
            labels: [
                <?php foreach ($pegawai_by_golongan as $golongan) {
                    echo "'" . $golongan->nama_golongan . "', ";
                } ?>
            ],
            datasets: [
                {
                    label: 'Jumlah Pegawai',
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: [
                        <?php foreach ($pegawai_by_golongan as $golongan) {
                            echo $golongan->jumlah_pegawai . ", ";
                        } ?>
                    ]
                }
            ]
        };
        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        };
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });
</script>

<!-- Script Non Aktif Pegawai -->
<script>
  $(document).ready(function() {
    $('#nonaktifModal').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var pegawai_id = button.data('pegawaiid');
      var modal = $(this);
      modal.find('.modal-body #pegawai_id').val(pegawai_id);
    });

    $('#alasan_nonaktif').change(function() {
      if ($(this).val() === 'Lainnya') {
        $('#alasan_lainnya_group').removeClass('d-none');
        $('#alasan_lainnya').attr('required', true);
      } else {
        $('#alasan_lainnya_group').addClass('d-none');
        $('#alasan_lainnya').removeAttr('required');
      }
    });
    
    $('[data-toggle="tooltip"]').tooltip(); 
  });

  $('#nonaktifModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var pegawaiId = button.data('pegawaiid');
    var modal = $(this);
    modal.find('.modal-body #pegawai_id').val(pegawaiId);
  });

  $('#aktifModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var pegawaiId = button.data('pegawaiid');
    var modal = $(this);
    modal.find('.modal-body #pegawai_id_aktif').val(pegawaiId);
  });

  $('#resetModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var pegawaiId = button.data('pegawaiid');
    var modal = $(this);
    modal.find('.modal-body #pegawai_id_reset').val(pegawaiId);
  });
</script>

<script>
  $(document).ready(function() {
      $('#nama').change(function() {
          var selected = $(this).find('option:selected');
          var nip = selected.data('nip');
          var jabatan = selected.data('jabatan');
          var golongan = selected.data('golongan');
          var status = selected.data('status');

          $('#nip').val(nip);
          $('#jabatan').val(jabatan);
          $('#golongan').val(golongan);
          $('#status').val(status);
      });
  });
</script>

</body>
</html>

