<?= $this->session->flashdata('pesan');?>
<!-- Isi Konten -->
<section class="content">
  <div class="row">
    <div class="col-12">
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link active" href="<?= base_url('Pegawai/detailpegawai/' . $id_pegawai) ?>">Informasi Pegawai</a>
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
          <a class="nav-link" href="<?= base_url('RiwayatStatusPegawai/index/' . $id_pegawai) ?>">Riwayat Status</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('RiwayatStatusKerja/index/' . $id_pegawai) ?>">Riwayat Bekerja</a>
        </li>
      </ul>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Informasi Detail Pegawai</h4>
            <div class="text-end">
                <a href="<?= base_url('Pegawai') ?>" class="btn btn-sm btn-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
              <?php if ($this->session->userdata('role') == 'Admin Kepegawaian') : ?>
                <?php if ($pegawai->pegawai_status == 1): ?>
                    <button type="button" class="btn btn-sm btn-warning me-2" data-toggle="modal" data-target="#editPegawaiModal">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-danger me-2" data-toggle="modal" data-target="#deletePegawaiModal<?= $pegawai->id_pegawai ?>">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#nonaktifPegawaiModal<?= $pegawai->id_pegawai ?>">
                        <i class="fas fa-user-slash me-1"></i>Nonaktifkan
                    </button>
                <?php else: ?>
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#aktifkanPegawaiModal<?= $pegawai->id_pegawai ?>">
                        <i class="fas fa-user-check me-1"></i>Aktifkan Pegawai
                    </button>
                <?php endif; ?>
              <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-5 mb-4 text-center">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php
                            $avatar = 'avatar-girl.jpg'; // Default
                            if (isset($pegawai->jenis_kelamin) && $pegawai->jenis_kelamin == 'L') {
                                $avatar = 'avatar-man.jpg';
                            }
                        ?>
                        <img src="<?= base_url('assets/img/' . $avatar) ?>"
                            alt="Foto Pegawai: <?= $pegawai->nama ?>"
                            class="img-fluid rounded-circle mb-3"
                            style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #adb5bd;">
                        
                        <h5 class="card-text mb-2"><?= $pegawai->nama ?></h5>
                        <p class="card-text text-muted mb-2">NIP: <?= $pegawai->nip ?></p>
                        <?php if ($pegawai->pegawai_status == 1): ?>
                            <span class="badge badge-success"><i class="fas fa-check-circle me-1"></i> Aktif</span>
                        <?php else: ?>
                            <span class="badge badge-danger"><i class="fas fa-times-circle me-1"></i> Tidak Aktif</span>
                            <?php if(isset($pegawai->jenis_status_kerja) && $pegawai->jenis_status_kerja): ?>
                                <p class="text-muted small mt-1">(Alasan: <?= $pegawai->jenis_status_kerja ?> <?= (isset($pegawai->alasan_lainnya) && $pegawai->alasan_lainnya) ? '- ' . $pegawai->alasan_lainnya : '' ?>)</p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Rincian Data Pegawai</h6>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4"><i class="fas fa-venus-mars me-2 text-muted"></i> Jenis Kelamin</dt>
                            <dd class="col-sm-8">: <?= ($pegawai->jenis_kelamin == 'L') ? 'Laki-Laki' : 'Perempuan' ?></dd>

                            <dt class="col-sm-4"><i class="fas fa-birthday-cake me-2 text-muted"></i> Tempat, Tgl Lahir</dt>
                            <dd class="col-sm-8">:
                                <?php
                                    // Gabungkan tempat lahir dan tanggal lahir yang sudah diformat
                                    $parts = [
                                        !empty($pegawai->tempat_lahir) ? $pegawai->tempat_lahir : null,
                                        format_tanggal($pegawai->tanggal_lahir) != '-' ? format_tanggal($pegawai->tanggal_lahir) : null
                                    ];
                                    echo implode(', ', array_filter($parts)) ?: '-';
                                ?>
                            </dd>
                            <dt class="col-sm-4"><i class="fas fa-mobile-alt me-2 text-muted"></i> No HP</dt>
                            <dd class="col-sm-8">: <?= $pegawai->no_hp ?: '-' ?></dd>

                            <dt class="col-sm-4"><i class="fas fa-map-marker-alt me-2 text-muted"></i> Alamat</dt>
                            <dd class="col-sm-8">: <?= $pegawai->alamat ?: '-' ?></dd>

                            <dt class="col-sm-4"><i class="fas fa-calendar-alt me-2 text-muted"></i> Mulai Bertugas</dt>
                            <dd class="col-sm-8">:
                                <?= format_tanggal($pegawai->tanggal_mulai_bertugas) ?: '-' ?>
                            </dd>
                            <dt class="col-sm-4"><i class="fas fa-fingerprint me-2 text-muted"></i> ID Absensi</dt>
                            <dd class="col-sm-8">: <?= $pegawai->userid_absen ?: '-' ?></dd>

                            <dt class="col-sm-4"><i class="fas fa-desktop me-2 text-muted"></i> Nomor Mesin</dt>
                            <dd class="col-sm-8">: <?= $pegawai->SN_Absen ?: '-' ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>

<div class="modal fade" id="deletePegawaiModal<?= $pegawai->id_pegawai ?>" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-dark">
        <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Hapus Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah Anda yakin ingin menghapus data pegawai <strong><?= $pegawai->nama ?></strong>?</p>
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
          <i class="fas fa-times"></i> Batal
        </button>
      <a href="<?= base_url('Pegawai/delete/' . $pegawai->id_pegawai) ?>" class="btn btn-danger btn-sm">
          <i class="fas fa-trash"></i> Hapus
        </a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="nonaktifPegawaiModal<?= $pegawai->id_pegawai ?>" tabindex="-1" aria-labelledby="nonaktifLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('Pegawai/nonaktifkan/' . $pegawai->id_pegawai) ?>" method="post">
        <div class="modal-header bg-secondary text-white">
          <h5 class="modal-title" id="nonaktifLabel">Nonaktifkan Pegawai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menonaktifkan pegawai <strong><?= $pegawai->nama ?></strong>?</p>
          <hr>
          <div class="form-group">
            <label for="jenis_status_kerja_nonaktif_<?= $pegawai->id_pegawai ?>">Alasan Nonaktif <span class="text-danger">*</span></label>
            <select name="jenis_status_kerja" id="jenis_status_kerja_nonaktif_<?= $pegawai->id_pegawai ?>" class="form-control select2" onchange="toggleAlasanLainnya(this, 'inputAlasanLainnya_<?= $pegawai->id_pegawai ?>')">
              <option value="">-- Pilih Alasan --</option>
              <option value="Resign">Resign</option>
              <option value="Pensiun">Pensiun</option>
              <option value="Habis Kontrak">Habis Kontrak</option>
              <option value="Meninggal Dunia">Meninggal Dunia</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="form-group d-none" id="inputAlasanLainnya_<?= $pegawai->id_pegawai ?>">
            <label for="alasan_lainnya_nonaktif_<?= $pegawai->id_pegawai ?>">Alasan Lainnya</label>
            <input type="text" name="alasan_lainnya" id="alasan_lainnya_nonaktif_<?= $pegawai->id_pegawai ?>" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times me-1"></i> Batal</button> 
          <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-user-slash me-1"></i> Nonaktifkan</button>
        </div>  
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="aktifkanPegawaiModal<?= $pegawai->id_pegawai ?>" tabindex="-1" aria-labelledby="aktifkanLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('Pegawai/aktifkan/' . $pegawai->id_pegawai) ?>" method="post">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="aktifkanLabel">Aktifkan Pegawai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin mengaktifkan kembali pegawai <strong><?= $pegawai->nama ?></strong>?</p>
        </div>
        <div class="modal-footer">  
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times me-1"></i> Batal</button>
          <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-user-check me-1"></i> Aktifkan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editPegawaiModal" tabindex="-1" aria-labelledby="editPegawaiModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="editPegawaiModalLabel"><i class="fas fa-edit me-2"></i>Edit Informasi Pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('Pegawai/edit/' . $pegawai->id_pegawai) ?>" method="post" id="formEditPegawai">
        <div class="modal-body">
          <input type="hidden" name="id_pegawai" value="<?= $pegawai->id_pegawai ?>">

          <?php if($this->session->flashdata('error_edit')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error_edit'); ?>
                <?php // echo validation_errors(); // Jika Anda mengirimkan validation_errors() ?>
            </div>
          <?php endif; ?> 

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit_nama">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_nama" name="nama" value="<?= set_value('nama', $pegawai->nama) ?>" >
                <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit_nip">NIP <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_nip" name="nip" value="<?= set_value('nip', $pegawai->nip) ?>">
                <?= form_error('nip', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit_jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                <select class="form-control select2" id="edit_jenis_kelamin" name="jenis_kelamin" >
                  <option value="">-- Pilih Jenis Kelamin --</option>
                  <option value="L" <?= set_select('jenis_kelamin', 'L', ($pegawai->jenis_kelamin == 'L')) ?>>Laki-Laki</option>
                  <option value="P" <?= set_select('jenis_kelamin', 'P', ($pegawai->jenis_kelamin == 'P')) ?>>Perempuan</option>
                </select>
                <?= form_error('jenis_kelamin', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit_tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="edit_tempat_lahir" name="tempat_lahir" value="<?= set_value('tempat_lahir', $pegawai->tempat_lahir) ?>" >
                <?= form_error('tempat_lahir', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                value="<?= set_value('tanggal_lahir', $pegawai->tanggal_lahir ? date('Y-m-d', strtotime($pegawai->tanggal_lahir)) : '') ?>" >
                <?= form_error('tanggal_lahir', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit_tanggal_mulai_bertugas">Tanggal Mulai Bekerja <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="edit_tanggal_mulai_bertugas" name="tanggal_mulai_bertugas"
                value="<?= set_value('tanggal_mulai_bertugas', $pegawai->tanggal_mulai_bertugas ? date('Y-m-d', strtotime($pegawai->tanggal_mulai_bertugas)) : '') ?>" >
                <?= form_error('tanggal_mulai_bertugas', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="userid_absen">User ID Absen <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="userid_absen" name="userid_absen"
                value="<?= set_value('userid_absen', $pegawai->userid_absen ? $pegawai->userid_absen : '') ?>">
                <?= form_error('userid_absen', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="SN_Absen">Nomor Mesin Absensi<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="SN_Absen" name="SN_Absen"
                value="<?= set_value('SN_Absen', $pegawai->SN_Absen ? $pegawai->SN_Absen : '') ?>">
                <?= form_error('SN_Absen', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
          </div>

          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="edit_no_hp">No HP</label>
                <input type="tel" class="form-control" id="edit_no_hp" name="no_hp" value="<?= set_value('no_hp', $pegawai->no_hp) ?>" placeholder="Contoh: 08123456789">
                <?= form_error('no_hp', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
            <div class="col-md-6"> <div class="form-group">
                <label for="edit_alamat">Alamat</label>
                <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"><?= set_value('alamat', $pegawai->alamat) ?></textarea>
                <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
              </div>
            </div>
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
</section>


<script>
// Cek jika ada parameter error_modal di URL untuk membuka modal secara otomatis
// Ini berguna jika validasi gagal dan Anda redirect kembali ke halaman detail
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error_modal')) {
        // Pastikan jQuery dan Bootstrap JS sudah dimuat
        if (typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined') {
            $('#editPegawaiModal').modal('show');
        } else {
            console.error('jQuery atau Bootstrap Modal tidak ditemukan.');
        }
    }
});
</script>

<script>
  function toggleAlasanLainnya(selectElement, inputDivId) {
    const inputDiv = document.getElementById(inputDivId);
    const inputField = inputDiv.querySelector('input[name="alasan_lainnya"]');
    if (selectElement.value === 'Lainnya') {
      inputDiv.classList.remove('d-none');
      if (inputField) inputField.setAttribute('required', 'required');
    } else {
      inputDiv.classList.add('d-none');
      if (inputField) {
        inputField.removeAttribute('required');
        inputField.value = '';
      }
    }
  }
  document.addEventListener('DOMContentLoaded', function() {
    const selectNonaktif = document.querySelector('#nonaktifPegawaiModal<?= $pegawai->id_pegawai ?> select[name="jenis_status_kerja"]');
    if (selectNonaktif) {
        toggleAlasanLainnya(selectNonaktif, 'inputAlasanLainnya_<?= $pegawai->id_pegawai ?>');
    }
  });
</script>