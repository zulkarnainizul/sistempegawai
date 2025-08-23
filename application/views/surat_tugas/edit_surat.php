<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-edit"></i> Form Edit Surat Tugas</h3>
            </div>
            <?= form_open('SuratTugas/edit_aksi/' . $surat_tugas->id_surat_tugas); ?>
            <div class="card-body">

                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Gagal!</h5>
                        <?= validation_errors() ?>
                    </div>
                <?php endif; ?>

                <fieldset class="border rounded-3 p-3 mb-4">
                    <legend class="float-none w-auto px-2 h6 text-muted">DETAIL SURAT & KEGIATAN</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3"><label>No. Surat <span class="text-danger">*</span></label><input type="text" class="form-control" name="no_surat" value="<?= set_value('no_surat', $surat_tugas->no_surat) ?>" required></div>
                            <div class="form-group mb-3"><label>Pemberi Tugas <span class="text-danger">*</span></label><input type="text" class="form-control" name="pemberi_tugas" value="<?= set_value('pemberi_tugas', $surat_tugas->pemberi_tugas) ?>" required></div>
                            <div class="form-group mb-3"><label>Nama Kegiatan <span class="text-danger">*</span></label><textarea class="form-control" name="nama_kegiatan" rows="2" required><?= set_value('nama_kegiatan', $surat_tugas->nama_kegiatan) ?></textarea></div>
                            <div class="form-group mb-3"><label>Dasar Surat <span class="text-danger">*</span></label><textarea class="form-control" name="dasar_surat" rows="3" required><?= set_value('dasar_surat', $surat_tugas->dasar_surat) ?></textarea></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3"><label>Tempat Kegiatan <span class="text-danger">*</span></label><input type="text" class="form-control" name="tempat_kegiatan" value="<?= set_value('tempat_kegiatan', $surat_tugas->tempat_kegiatan) ?>" required></div>
                            <div class="form-group mb-3"><label>Alamat Kegiatan <span class="text-danger">*</span></label><textarea class="form-control" name="lokasi_kegiatan" rows="2" required><?= set_value('lokasi_kegiatan', $surat_tugas->lokasi_kegiatan) ?></textarea></div>
                            <div class="row">
                                <div class="col-sm-6 form-group"><label>Tanggal Mulai <span class="text-danger">*</span></label><input type="date" class="form-control" name="tanggal_mulai" value="<?= set_value('tanggal_mulai', $surat_tugas->tanggal_mulai) ?>" required></div>
                                <div class="col-sm-6 form-group"><label>Tanggal Berakhir <span class="text-danger">*</span></label><input type="date" class="form-control" name="tanggal_akhir" value="<?= set_value('tanggal_akhir', $surat_tugas->tanggal_akhir) ?>" required></div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="border rounded-3 p-3">
                    <legend class="float-none w-auto px-2 h6 text-muted">PELAKSANA TUGAS</legend>
                    <div class="row">
                        <div class="col-md-7">
                            <label class="form-label">Daftar Petugas Terpilih</label>
                            <div style="max-height: 180px; overflow-y: auto;">
                                <table class="table table-sm table-bordered table-hover">
                                    <thead class="thead-light" style="position: sticky; top: 0; z-index: 1;">
                                        <tr><th class="text-center" width="10%">No</th><th>Nama Pelaksana</th><th class="text-center" width="15%">Aksi</th></tr>
                                    </thead>
                                    <tbody id="tabel-pelaksana">
                                        <?php if(!empty($surat_tugas->pelaksana)): foreach($surat_tugas->pelaksana as $p_edit): ?>
                                        <tr data-id="<?= $p_edit->id_pegawai ?>">
                                            <td class="text-center"></td>
                                            <td>
                                                <?= $p_edit->nama ?>
                                                <input type="hidden" name="pelaksana[]" value="<?= $p_edit->id_pegawai ?>">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm btn-hapus-pelaksana"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="pegawai-select" class="form-label">Pilih & Tambah Pegawai <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="pegawai-select" data-placeholder="-- Cari Nama atau NIP Pegawai --">
                                    <option></option>
                                    <?php foreach ($pegawai as $p): ?>
                                        <option value="<?= $p->id_pegawai ?>" data-nama="<?= $p->nama ?>"><?= $p->nama ?> - <?= $p->nip ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-primary w-100 mt-2" id="add-pelaksana">
                                    <i class="fas fa-plus-circle"></i> Tambah ke Daftar
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
            <div class="card-footer text-right">
                <a href="<?= base_url('SuratTugas') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                <button type="reset" class="btn btn-outline-danger btn-sm"><i class="fas fa-undo"></i> Reset</button>
                <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-save"></i> Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectPegawai = $('#pegawai-select');
    const tabelPelaksana = $('#tabel-pelaksana');
    const btnAdd = $('#add-pelaksana');
    const addedIds = new Set();

    // Inisialisasi daftar ID yang sudah ada dari tabel
    function initializeAddedIds() {
        addedIds.clear();
        tabelPelaksana.find('tr').each(function() {
            const id = $(this).data('id');
            addedIds.add(String(id));
        });
        
        // Nonaktifkan opsi yang sudah ada di select2
        selectPegawai.find('option').each(function() {
            const id = $(this).val();
            $(this).prop('disabled', addedIds.has(id));
        });
    }

    // Inisialisasi Select2
    selectPegawai.select2({
        placeholder: '-- Cari Nama atau NIP Pegawai --',
        width: '100%'
    });
    
    // Panggil fungsi inisialisasi saat halaman dimuat
    initializeAddedIds();
    perbaruiNomorUrut();

    btnAdd.on('click', function () {
        const selectedOption = selectPegawai.find('option:selected');
        const id = selectedOption.val();
        const nama = selectedOption.data('nama');

        if (!id) { alert('Silakan pilih pegawai.'); return; }
        if (addedIds.has(id)) { alert('Pegawai ini sudah ada dalam daftar.'); return; }

        addedIds.add(id);
        const newRow = `<tr data-id="${id}"><td class="text-center"></td><td>${nama}<input type="hidden" name="pelaksana[]" value="${id}"></td><td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-hapus-pelaksana"><i class="fas fa-trash-alt"></i></button></td></tr>`;
        tabelPelaksana.append(newRow);
        perbaruiNomorUrut();
        
        selectPegawai.find(`option[value='${id}']`).prop('disabled', true);
        selectPegawai.val(null).trigger('change');
    });

    tabelPelaksana.on('click', '.btn-hapus-pelaksana', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        
        addedIds.delete(String(id));
        selectPegawai.find(`option[value='${id}']`).prop('disabled', false);
        row.remove();
        perbaruiNomorUrut();
    });

    function perbaruiNomorUrut() {
        tabelPelaksana.find('tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }
});
</script>