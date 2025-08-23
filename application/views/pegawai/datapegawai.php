<?= $this->session->flashdata('pesan');?>
<!-- Main content (Table Data Pegawai) -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <?php if ($this->session->userdata('role') == 'Admin Kepegawaian') : ?>
          <div class="card-header">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#aktif" data-toggle="tab">Pegawai Aktif</a></li>
              <li class="nav-item"><a class="nav-link" href="#nonaktif" data-toggle="tab">Pegawai Tidak Aktif</a></li>
            </ul>
          </div>
        <?php endif; ?>

        <div class="tab-content">
          <!-- Tab Pegawai Aktif -->
          <div class="tab-pane active" id="aktif">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tabel Data Pegawai</h5>
                    <?php if ($this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                      <div class="d-flex justify-content-end">
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalSinkronisasi">
                              <i class="fas fa-sync-alt mr-1"></i> Sinkronisasi
                          </button>
                          <button type="button" class="btn btn-secondary btn-sm ml-2" data-toggle="modal" data-target="#modalCetakPegawai">
                              <i class="fas fa-print mr-1"></i> Cetak Laporan
                          </button>
                          <a href="<?= site_url('Pegawai/tambahpegawai') ?>" class="btn btn-success btn-sm ml-2">
                              <i class="fas fa-plus mr-1"></i> Tambah Pegawai
                          </a>
                      </div>
                    <?php endif; ?>
            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Golongan</th> 
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($pegawai_aktif as $pg) : ?>
                    <tr class="text-center">
                      <td><?= $no++ ?></td>
                      <td><?= $pg->nama ?></td>
                      <td><?= $pg->nip ?></td>
                      <td><?= $pg->nama_golongan ?? '-' ?></td>
                      <td><?= $pg->nama_jabatan ?? '-' ?></td>
                      <td><?= $pg->nama_status?? '-' ?></td>
                      <td>
                        <a href="<?= site_url('Pegawai/detailpegawai/' . $pg->id_pegawai) ?>" 
                          class="btn btn-outline-info btn-sm">
                          <i class="fas fa-info-circle"></i> Lihat Detail
                        </a>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /Tab Pegawai Aktif -->

          <!-- Tab Pegawai Tidak Aktif -->
          <div class="tab-pane" id="nonaktif">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tabel Data Pegawai Tidak Aktif</h5>
                </div>  
            </div>
            <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Jenis Kelamin</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($pegawai_tidak_aktif as $pta) : ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= $pta->nama ?></td>
                                <td><?= $pta->nip ?></td>
                                <td><?= $pta->jenis_kelamin ?></td>
                                <td><?= $pta->jenis_status_kerja ?></td>
                                <td>
                                  <a href="<?= site_url('Pegawai/detailpegawai/' . $pta->id_pegawai) ?>" 
                                    class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-info-circle"></i> Lihat Detail
                                  </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
          </div>

          <!-- /Tab Pegawai Tidak Aktif -->
        </div>
      </div>
    </div>
  </div>
</section>


<div class="modal fade" id="modalCetakPegawai" tabindex="-1" role="dialog" aria-labelledby="modalCetakLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalCetakLabel"><i class="fas fa-print"></i> Cetak Laporan Pegawai</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="<?= site_url('laporan/cetak_laporan_pegawai') ?>" method="post" target="_blank">
                <div class="modal-body">
                    <p>Silakan pilih format laporan dan filter data yang diinginkan.</p>
                    <hr>
                    
                    <div class="form-group">
                        <label for="tipe_laporan" class="font-weight-bold">Format Laporan <span class="text-danger">*</span></label>
                        <select name="tipe_laporan" id="tipe_laporan" class="form-control" required>
                            <option value="">-- Pilih Format --</option>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="excellengkap">Excel (Lengkap)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Filter Berdasarkan Status Pegawai <span class="text-danger">*</span></label>
                        <div class="p-2 border rounded" style="max-height: 150px; overflow-y: auto;">
                            <?php
                            // Ambil data status dari model
                            $all_status = $this->Status_model->get_data();
                            foreach ($all_status as $status) {
                                echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="checkbox" name="status_pegawai[]" value="' . $status->id_status_pegawai . '" id="modal_status_' . $status->id_status_pegawai . '">';
                                echo '<label class="form-check-label" for="modal_status_' . $status->id_status_pegawai . '">' . $status->nama_status . '</label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <small class="text-muted">Pilih satu atau lebih status.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSinkronisasi" tabindex="-1" role="dialog" aria-labelledby="modalSinkronisasiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalSinkronisasiLabel"><i class="fas fa-sync-alt"></i> Konfirmasi Sinkronisasi</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin melakukan sinkronisasi data?</p>
                <p class="text-muted small">Proses ini akan membandingkan data dari mesin absensi dengan data di sistem dan mungkin membutuhkan beberapa saat.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                <a href="<?= site_url('Pegawai/sinkronisasi') ?>" class="btn btn-info btn-sm"><i class="fas fa-check"></i> Ya, Lanjutkan</a>
            </div>
        </div>
    </div>
</div>