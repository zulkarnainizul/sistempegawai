<section class="content">
    <div class="container-fluid">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-plus"></i> Form Tambah Surat Tugas</h3>
            </div>
            <?= form_open('SuratTugas/tambah_aksi'); ?>
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
                            <div class="form-group mb-3">
                                <label for="no_surat" class="form-label">No. Surat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_surat" name="no_surat" placeholder="Contoh: 01/420/SMKN.02/TU.03/2025" value="<?= set_value('no_surat') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="pemberi_tugas" class="form-label">Pemberi Tugas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pemberi_tugas" id="pemberi_tugas" placeholder="Contoh: Kepala SMKN 2 Pekanbaru" value="<?= set_value('pemberi_tugas') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama_kegiatan" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="nama_kegiatan" name="nama_kegiatan" rows="2" placeholder="Contoh: Pelatihan Peningkatan Kompetensi Guru" required><?= set_value('nama_kegiatan') ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="dasar_surat" class="form-label">Dasar Surat <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="dasar_surat" name="dasar_surat" rows="3" placeholder="Contoh: Surat dari Dinas Pendidikan Provinsi Riau No. 123/ABC/2025" required><?= set_value('dasar_surat') ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tempat_kegiatan" class="form-label">Tempat Kegiatan (Nama Gedung/Venue) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tempat_kegiatan" name="tempat_kegiatan" placeholder="Contoh: Hotel Grand Zuri, Aula SMKN 2" value="<?= set_value('tempat_kegiatan') ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="lokasi_kegiatan" class="form-label">Alamat Lengkap Kegiatan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="lokasi_kegiatan" name="lokasi_kegiatan" rows="2" placeholder="Contoh: Jl. Jend. Sudirman No. 88, Pekanbaru" required><?= set_value('lokasi_kegiatan') ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= set_value('tanggal_mulai') ?>" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= set_value('tanggal_akhir') ?>" required>
                                </div>
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
                                        <tr>
                                            <th class="text-center" width="10%">No</th>
                                            <th>Nama Pelaksana</th>
                                            <th class="text-center" width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-pelaksana">
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
                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Simpan</button>
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

    // Inisialisasi Select2
    selectPegawai.select2({
        placeholder: '-- Cari Nama atau NIP Pegawai --',
        width: '100%'
    });

    // Fungsi untuk menambah pelaksana
    btnAdd.on('click', function () {
        const selectedOption = selectPegawai.find('option:selected');
        const id = selectedOption.val();
        const nama = selectedOption.data('nama');

        if (!id) {
            alert('Silakan pilih pegawai terlebih dahulu.');
            return;
        }

        if (addedIds.has(id)) {
            alert('Pegawai ini sudah ada dalam daftar.');
            return;
        }

        addedIds.add(id);
        const newRow = `
            <tr data-id="${id}">
                <td class="text-center"></td>
                <td>
                    ${nama}
                    <input type="hidden" name="pelaksana[]" value="${id}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-hapus-pelaksana"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>`;
        tabelPelaksana.append(newRow);
        perbaruiNomorUrut();
        
        // Nonaktifkan opsi yang sudah dipilih dan reset select2
        selectPegawai.find(`option[value='${id}']`).prop('disabled', true);
        selectPegawai.val(null).trigger('change');
    });

    // Fungsi untuk menghapus pelaksana
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

    // Reset form juga mereset daftar pelaksana
    $('button[type="reset"]').on('click', function() {
        tabelPelaksana.empty();
        addedIds.clear();
        selectPegawai.find('option').prop('disabled', false);
        selectPegawai.val(null).trigger('change');
    });
});
</script>