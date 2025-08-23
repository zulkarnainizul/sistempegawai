<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-info-circle"></i> Detail Surat Cuti</h3>
                <div class="card-tools pr-2">
                    <a href="<?= base_url('SuratCuti') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <a href="<?= base_url('Laporan/pdf_surat_cuti/' . $cuti->id_surat_cuti); ?>" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak Surat</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-user"></i> Data Pegawai</strong>
                            </div>
                            <div class="card-body p-2">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <tr>
                                        <th style="width: 35%;">Nama Pemohon</th>
                                        <td><?= $cuti->nama_pemohon ?? 'N/A' ?></td>
                                    </tr>
                                    <tr>
                                        <th>NIP</th>
                                        <td><?= $cuti->nip_pemohon ?? 'N/A' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td><?= $cuti->jabatan ?? 'N/A' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Masa Kerja</th>
                                        <td><?= $cuti->masa_kerja_tahun ?? '0' ?> tahun, <?= $cuti->masa_kerja_bulan ?? '0' ?> bulan</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card border-info">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-file-alt"></i> Detail Cuti</strong>
                            </div>
                            <div class="card-body p-2">
                                <table class="table table-sm table-bordered table-striped mb-0">
                                    <tr>
                                        <th style="width: 35%;">Jenis Cuti</th>
                                        <td><?= $cuti->jenis_cuti ?? 'N/A' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Alasan Cuti</th>
                                        <td><?= $cuti->alasan_cuti ?? 'N/A' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Lama Cuti</th>
                                        <td><?= $cuti->lama_cuti ?? 'N/A' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td><?= date('d F Y', strtotime($cuti->tanggal_mulai)) ?> s.d. <?= date('d F Y', strtotime($cuti->tanggal_akhir)) ?></td>
                                    </tr>
                                     <tr>
                                        <th>Alamat Selama Cuti</th>
                                        <td><?= $cuti->alamat_selama_cuti ?? 'N/A' ?></td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td><?= $cuti->no_telp_cuti ?? 'N/A' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-5">
                        <div class="card border-secondary h-100">
                            <div class="card-header bg-light">
                                <strong><i class="fas fa-eye"></i> Pratinjau Surat Cuti</strong>
                            </div>
                            <div class="card-body p-2" style="min-height: 500px;">
                                <iframe 
                                    src="<?= base_url('Laporan/pdf_surat_cuti/' . $cuti->id_surat_cuti); ?>" 
                                    style="width: 100%; height: 100%; border: none;" 
                                    title="Pratinjau Surat Cuti">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>