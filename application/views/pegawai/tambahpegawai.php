<div class="container mt-3">
  <div class="card">
    <div class="card-header bg-success text-white">
      <h5 class="card-title">Halaman Tambah Pegawai</h5>
    </div>
    <div class="card-body">
      <form action="<?= base_url('Pegawai/simpan') ?>" method="POST">

        <h6 class="text-dark font-weight-bold">Informasi Wajib Pegawai</h6>
        <hr class="mt-0">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label for="nama" class="font-weight-bold">Nama Lengkap</label>  <span class="text-danger">*</span>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= set_value('nama'); ?>">
              <?= form_error('nama', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>

            <div class="form-group">
              <label for="nip" class="font-weight-bold">NIP/ NUPTK</label>  <span class="text-danger">*</span>
              <input type="number" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" value="<?= set_value('nip'); ?>">
              <?= form_error('nip', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>

            <div class="form-group">
              <label class="font-weight-bold">Jenis Kelamin</label> 
               <span class="text-danger">*</span>
              <select name="jenis_kelamin" class="form-control select2">
                  <option value="">-- Pilih Jenis Kelamin --</option>
                  <option value="L" <?= set_select('jenis_kelamin', 'L'); ?>>Laki-Laki</option>
                  <option value="P" <?= set_select('jenis_kelamin', 'P'); ?>>Perempuan</option>
              </select>
              <?= form_error('jenis_kelamin', '<div class="text-small text-danger mt-1">', '</div>'); ?>
          </div>
          </div>

          <div class="col-md-7">
            <div class="form-row">
              <div class="form-group col-md-8">
                <label for="golongan" class="font-weight-bold">Golongan Pegawai</label>  <span class="text-danger">*</span>
                <select class="form-control select2" id="golongan" name="id_golongan">
                  <option value="">Pilih Golongan</option>
                  <?php foreach($golongan as $gl): ?>
                    <option value="<?= $gl->id_golongan ?>" <?= set_select('id_golongan', $gl->id_golongan); ?>><?= $gl->nama_golongan ?></option>
                  <?php endforeach; ?>
                </select>
                <?= form_error('id_golongan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="tmt_golongan" class="font-weight-bold">TMT Golongan</label>  <span class="text-danger">*</span>
                <input type="date" class="form-control" id="tmt_golongan" name="tmt_golongan" value="<?= set_value('tmt_golongan'); ?>">
                <?= form_error('tmt_golongan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-8">
                <label for="jabatan" class="font-weight-bold">Jabatan Pegawai</label>  <span class="text-danger">*</span>
                <select class="form-control select2" id="jabatan" name="id_jabatan">
                  <option value="">Pilih Jabatan</option>
                  <?php foreach($jabatan as $jb): ?>
                    <option value="<?= $jb->id_jabatan ?>" <?= set_select('id_jabatan', $jb->id_jabatan); ?>>
                      <?= $jb->nama_jabatan ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <?= form_error('id_jabatan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="tmt_jabatan" class="font-weight-bold">TMT Jabatan</label>  <span class="text-danger">*</span>
                <input type="date" class="form-control" id="tmt_jabatan" name="tmt_jabatan" value="<?= set_value('tmt_jabatan'); ?>">
                <?= form_error('tmt_jabatan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-8">
                <label for="status_pegawai" class="font-weight-bold">Status Pegawai</label>  <span class="text-danger">*</span>
                <select class="form-control select2" id="status_pegawai" name="id_status_pegawai">
                  <option value="">Pilih Status</option>
                  <?php foreach($status as $st): ?>
                    <option value="<?= $st->id_status_pegawai ?>" <?= set_select('id_status_pegawai', $st->id_status_pegawai); ?>><?= $st->nama_status ?></option>
                  <?php endforeach; ?>
                </select>
                <?= form_error('id_status_pegawai', '<div class="text-small text-danger mt-1">', '</div>'); ?>
              </div>
              <div class="form-group col-md-4">
                <label for="tmt_status" class="font-weight-bold">TMT Status</label>  <span class="text-danger">*</span>
                <input type="date" class="form-control" id="tmt_status" name="tmt_status" value="<?= set_value('tmt_status'); ?>">
                <?= form_error('tmt_status', '<div class="text-small text-danger mt-1">', '</div>'); ?>
              </div>
            </div>
          </div>
        </div>

        <h6 class="text-dark font-weight-bold mt-4">Informasi Lainnya</h6>
        <hr class="mt-0 mb-3">

        <p class="font-weight-bold text-secondary mb-2" style="font-size: 0.95rem;"><u><i>Data Pendidikan:</i></u></p>
        <div class="form-row">
            <div class="form-group col-md-5"> <label for="nama_jurusan" class="font-weight-bold">Nama Jurusan/Prodi</label>
                <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" placeholder="Nama Pendidikan/Jurusan" value="<?= set_value('nama_jurusan'); ?>">
                <?= form_error('nama_jurusan', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>
            <div class="form-group col-md-4"> <label for="tingkat_ijazah" class="font-weight-bold">Tingkat Ijazah</label>
                <select class="form-control select2" id="tingkat_ijazah" name="tingkat_ijazah">
                    <option value="">Pilih Tingkat</option>
                    <option value="SMA/SMK" <?= set_select('tingkat_ijazah', 'SMA/SMK'); ?>>SMA/SMK</option>
                    <option value="D3" <?= set_select('tingkat_ijazah', 'D3'); ?>>D3</option>
                    <option value="S1" <?= set_select('tingkat_ijazah', 'S1'); ?>>S1</option>
                    <option value="S2" <?= set_select('tingkat_ijazah', 'S2'); ?>>S2</option>
                    <option value="S3" <?= set_select('tingkat_ijazah', 'S3'); ?>>S3</option>
                </select>
                <?= form_error('tingkat_ijazah', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>
            <div class="form-group col-md-3"> <label for="tahun_lulus" class="font-weight-bold">Tahun Lulus</label>
                <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus" placeholder="Contoh: 2015" maxlength="4" value="<?= set_value('tahun_lulus'); ?>">
                <?= form_error('tahun_lulus', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>
        </div>

        <p class="font-weight-bold text-secondary mb-2 mt-3" style="font-size: 0.95rem;"><u><i>Data Pribadi Tambahan:</i></u></p>
        
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="no_hp" class="font-weight-bold">No HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="08xxxxxxxxxx" value="<?= set_value('no_hp'); ?>">
                <?= form_error('no_hp', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>
            <div class="form-group col-md-4">
                <label for="tempat_lahir" class="font-weight-bold">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="<?= set_value('tempat_lahir'); ?>">
                <?= form_error('tempat_lahir', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>
            <div class="form-group col-md-3">
                <label for="tanggal_lahir" class="font-weight-bold">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= set_value('tanggal_lahir'); ?>">
                <?= form_error('tanggal_lahir', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>
        </div>
        <div class="form-row">
              <div class="form-group col-md-5">
                  <label for="tanggal_mulai_bertugas" class="font-weight-bold">Tanggal Mulai Bekerja</label>  <span class="text-danger">*</span>
                  <input type="date" class="form-control" id="tanggal_mulai_bertugas" name="tanggal_mulai_bertugas" value="<?= set_value('tanggal_mulai_bertugas'); ?>">
                  <?= form_error('tanggal_mulai_bertugas', '<div class="text-small text-danger mt-1">', '</div>'); ?>
              </div>
              <div class="form-group col-md-7"> <label for="alamat" class="font-weight-bold">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan Alamat"><?= set_value('alamat'); ?></textarea>
                <?= form_error('alamat', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>
        </div>
        <p class="font-weight-bold text-secondary mb-2 mt-3" style="font-size: 0.95rem;"><u><i>Data Absensi:</i></u></p>

        <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="userid_absen" class="font-weight-bold">User ID Absen</label>  <span class="text-danger">*</span>
                  <input type="number" class="form-control" id="userid_absen" name="userid_absen" value="<?= set_value('userid_absen'); ?>">
                  <?= form_error('userid_absen', '<div class="text-small text-danger mt-1">', '</div>'); ?>
              </div>
              <div class="form-group col-md-6"> <label for="SN_Absen" class="font-weight-bold">Nomor Mesin Absensi</label><span class="text-danger">*</span>
                  <input type="text" class="form-control" id="SN_Absen" name="SN_Absen" value="<?= set_value('SN_Absen'); ?>">
                <?= form_error('SN_Absen', '<div class="text-small text-danger mt-1">', '</div>'); ?>
            </div>
        </div>

        <div class="mt-4 text-right">
          <a href="<?= base_url('Pegawai') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
                <button type="reset" class="btn btn-outline-danger btn-sm"><i class="fas fa-undo"></i> Reset</button>

          <button type="submit" class="btn btn-success btn-sm">
            <i class="fas fa-save"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>