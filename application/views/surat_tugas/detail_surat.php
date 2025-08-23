<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Detail Surat Tugas</h3>
                <div class="card-tools pr-2">
                    <a href="<?= base_url('SuratTugas') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <a href="<?= base_url('Laporan/pdf_surat_tugas/'.$surat_tugas->id_surat_tugas); ?>" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak Surat</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card border-info mb-3">
                            <div class="card-header bg-light"><strong><i class="fas fa-file-alt"></i> Informasi Surat Tugas</strong></div>
                            <div class="card-body p-2">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <tr><th width="35%">No. Surat</th><td><?= $surat_tugas->no_surat ?></td></tr>
                                    <tr><th>Tanggal Pengajuan</th><td><?= format_tanggal($surat_tugas->date_create) ?></td></tr>
                                    <tr><th>Dasar Surat</th><td><?= nl2br($surat_tugas->dasar_surat) ?></td></tr>  
                                    <tr><th>Nama Kegiatan</th><td><?= $surat_tugas->nama_kegiatan ?></td></tr>
                                    <tr><th>Tanggal Kegiatan</th><td><?= format_tanggal($surat_tugas->tanggal_mulai) ?> s.d <?= format_tanggal($surat_tugas->tanggal_akhir) ?></td></tr>
                                    <tr><th>Tempat</th><td><?= $surat_tugas->tempat_kegiatan ?></td></tr>
                                    <tr><th>Lokasi Kegiatan</th><td><?= $surat_tugas->lokasi_kegiatan ?></td></tr>
                                    <tr><th>Pemberi Tugas</th><td><?= $surat_tugas->pemberi_tugas ?></td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="card border-secondary">
                            <div class="card-header bg-light"><strong><i class="fas fa-users"></i> Daftar Pelaksana</strong></div>
                            <div class="card-body p-2 table-responsive">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <thead class="thead-light"><tr><th>No</th><th>Nama</th><th>NIP</th></tr></thead>
                                    <tbody>
                                    <?php $no_pelaksana = 1; if (!empty($surat_tugas->pelaksana)): ?>
                                        <?php foreach($surat_tugas->pelaksana as $p): ?>
                                            <tr><td><?= $no_pelaksana++ ?></td><td><?= $p->nama ?></td><td><?= $p->nip ?></td></tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center">Tidak ada pelaksana tugas.</td></tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card border-secondary h-100">
                            <div class="card-header bg-light"><strong><i class="fas fa-eye"></i> Pratinjau Surat</strong></div>
                            <div class="card-body p-2" style="min-height: 500px;">
                                <iframe src="<?= base_url('Laporan/pdf_surat_tugas/'.$surat_tugas->id_surat_tugas); ?>" style="width: 100%; height: 100%; border: none;" title="Pratinjau Surat Tugas"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>