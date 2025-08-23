<section class="content">
    <div class="container-fluid">
        <?= form_open('SuratCuti/tambah_aksi'); ?>
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-plus"></i> Form Tambah Surat Cuti</h3>
            </div>
            <div class="card-body">
                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">*</button>
                        <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <h5 class="mt-2 mb-3 text-muted font-weight-bold">DATA PEGAWAI</h5>
                <div class="form-group">
                    <label>Nama Pegawai <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="id_pegawai" required>
                        <option value="">-- Pilih Pegawai --</option>
                        <?php foreach ($pegawai as $p) : ?>
                            <option value="<?= $p->id_pegawai; ?>"><?= $p->nama; ?> (NIP: <?= $p->nip ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <h5 class="mt-4 mb-3 text-muted font-weight-bold">JENIS CUTI YANG DIAMBIL <span class="text-danger">*</span></h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_cuti" id="cuti_tahunan" value="Cuti Tahunan" required>
                            <label class="form-check-label" for="cuti_tahunan">Cuti Tahunan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_cuti" id="cuti_sakit" value="Cuti Sakit">
                            <label class="form-check-label" for="cuti_sakit">Cuti Sakit</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_cuti" id="cuti_alasan_penting" value="Cuti Karena Alasan Penting">
                            <label class="form-check-label" for="cuti_alasan_penting">Cuti Karena Alasan Penting</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_cuti" id="cuti_besar" value="Cuti Besar">
                            <label class="form-check-label" for="cuti_besar">Cuti Besar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_cuti" id="cuti_melahirkan" value="Cuti Melahirkan">
                            <label class="form-check-label" for="cuti_melahirkan">Cuti Melahirkan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_cuti" id="cuti_luar_tanggungan" value="Cuti di Luar Tanggungan Negara">
                            <label class="form-check-label" for="cuti_luar_tanggungan">Cuti di Luar Tanggungan Negara</label>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4 mb-3 text-muted font-weight-bold">ALASAN CUTI <span class="text-danger">*</span></h5>
                <div class="form-group">
                    <input type="text" name="alasan_cuti" class="form-control" placeholder="Tuliskan alasan cuti..." required>
                </div>

                <h5 class="mt-4 mb-3 text-muted font-weight-bold">LAMANYA CUTI</h5>
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="lama_cuti">Selama <span class="text-danger">*</span></label>
                            <input type="text" name="lama_cuti" class="form-control" placeholder="Contoh: 2 (Dua) Bulan" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal_mulai">Mulai tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-1 text-center pb-3">
                        <h5>s/d</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                             <label for="tanggal_akhir">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_akhir" class="form-control" required>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4 mb-3 text-muted font-weight-bold">ALAMAT SELAMA MENJALANKAN CUTI</h5>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <input type="text" name="alamat_selama_cuti" class="form-control" placeholder="Masukkan alamat lengkap" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Telp/HP. <span class="text-danger">*</span></label>
                            <input type="text" name="no_telp_cuti" class="form-control" placeholder="Masukkan nomor telepon aktif">
                        </div>
                    </div>
                </div>

                <h5 class="mt-4 mb-3 text-muted font-weight-bold">KEPUTUSAN PEJABAT YANG MEMBERIKAN CUTI</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body">
                             <h6 class="font-weight-bold">Atasan 1</h6>
                             <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan_atasan1" class="form-control" value="Kepala Dinas Pendidikan Provinsi Riau" required>
                             </div>
                             <div class="form-group">
                                <label>Nama Atasan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_atasan1" class="form-control" placeholder="Nama Kepala Dinas" required>
                             </div>
                             <div class="form-group">
                                <label>NIP Atasan <span class="text-danger">*</span></label>
                                <input type="text" name="nip_atasan1" class="form-control" placeholder="NIP Kepala Dinas" required>
                             </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                             <h6 class="font-weight-bold">Atasan 2</h6>
                             <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan_atasan2" class="form-control" value="Gubernur Riau" required>
                             </div>
                              <div class="form-group">
                                <label>Nama Atasan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_atasan2" class="form-control" placeholder="Nama Gubernur" required>
                             </div>
                             
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer text-right">
                <a href="<?= base_url('SuratCuti') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                <button type="reset" class="btn btn-outline-danger btn-sm"><i class="fas fa-undo"></i> Reset</button>
                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</section>