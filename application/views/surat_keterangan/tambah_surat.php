<section class="content">
    <div class="container-fluid">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-plus"></i> Form Tambah Surat Keterangan</h3>
            </div>
            <?= form_open('SuratKeterangan/tambah_aksi'); ?>
            <div class="card-body">
                <?php if (validation_errors()): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                    <?= validation_errors(); ?>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group"><label>No. Surat <span class="text-danger">*</span></label><input type="text" class="form-control" name="no_surat" value="<?= set_value('no_surat') ?>" placeholder="Contoh: 800/123/SMKN.02/2025" required></div>
                        <div class="form-group"><label>Bidang Studi <span class="text-danger">*</span></label><input type="text" class="form-control" name="bidang_studi" value="<?= set_value('bidang_studi') ?>" placeholder="Contoh: Teknik Komputer dan Jaringan" required></div>
                        <div class="form-group"><label>Keperluan Surat <span class="text-danger">*</span></label><textarea class="form-control" name="keperluan_surat" rows="3" placeholder="Contoh: Untuk pengajuan pinjaman bank." required><?= set_value('keperluan_surat') ?></textarea></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pegawai <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="id_pegawai" style="width: 100%;" required>
                                <option value="">-- Pilih Pegawai --</option>
                                <?php foreach ($pegawai as $p): ?>
                                    <option value="<?= $p->id_pegawai; ?>" <?= set_select('id_pegawai', $p->id_pegawai); ?>><?= $p->nama; ?> (NIP: <?= $p->nip ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group"><label>Kabupaten/Kota <span class="text-danger">*</span></label><input type="text" class="form-control" name="kab_kota" value="<?= set_value('kab_kota', 'Pekanbaru') ?>" required></div>
                        <div class="form-group"><label>Keterangan <span class="text-danger">*</span></label><textarea class="form-control" name="keterangan" rows="5"><?= set_value('keterangan', 'Nama yang tercantum di atas adalah benar Guru PPPK pada SMK Negeri 2 Pekanbaru sampai dengan sekarang dan akan tetap diperpanjang sampai dengan waktu pembiayaan selesai / Lunas.') ?></textarea></div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="<?= base_url('SuratKeterangan'); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                <button type="reset" class="btn btn-outline-danger btn-sm"><i class="fas fa-undo"></i> Reset</button>
                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>