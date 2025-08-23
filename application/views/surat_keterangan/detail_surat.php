<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-info-circle"></i> Detail Surat Keterangan</h3>
                <div class="card-tools pr-2">
                    <a href="<?= base_url('SuratKeterangan'); ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <a href="<?= base_url('Laporan/pdf_surat_keterangan/'.$surat->id_surat_keterangan); ?>" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak Surat</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card border-info mb-3">
                            <div class="card-header bg-light"><strong><i class="fas fa-user"></i> Data Pegawai</strong></div>
                            <div class="card-body p-2">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <tr><th width="35%">Nama Pegawai</th><td><?= $surat->nama ?></td></tr>
                                    <tr><th>NIP</th><td><?= $surat->nip ?></td></tr>
                                    <tr><th>Tempat, Tanggal Lahir</th><td><?= $surat->tempat_lahir ?>, <?= format_tanggal($surat->tanggal_lahir) ?></td></tr>
                                    <tr><th>Bidang Studi</th><td><?= $surat->bidang_studi ?></td></tr>
                                    <tr><th>Kabupaten/Kota</th><td><?= $surat->kab_kota ?></td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="card border-secondary">
                            <div class="card-header bg-light"><strong><i class="fas fa-file-alt"></i> Informasi Surat</strong></div>
                            <div class="card-body p-2">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <tr><th width="40%">No. Surat</th><td><?= $surat->no_surat ?></td></tr>
                                    <tr><th>Tanggal Pengajuan</th><td><?= format_tanggal($surat->date_create) ?></td></tr>
                                    <tr><th>Keperluan</th><td><?= nl2br($surat->keperluan_surat) ?></td></tr>
                                    <tr><th>Keterangan</th><td><?= nl2br($surat->keterangan) ?></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card border-secondary h-100">
                            <div class="card-header bg-light"><strong><i class="fas fa-eye"></i> Pratinjau Surat</strong></div>
                            <div class="card-body p-2" style="min-height: 500px;">
                                <iframe src="<?= base_url('Laporan/pdf_surat_keterangan/'.$surat->id_surat_keterangan); ?>" style="width: 100%; height: 100%; border: none;" title="Pratinjau Surat Keterangan"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>