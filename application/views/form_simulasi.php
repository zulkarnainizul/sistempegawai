<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Simulasi Absensi'; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0"><i class="fas fa-magic mr-2"></i><?= isset($title) ? htmlspecialchars($title) : 'Simulasi Absensi'; ?></h5>
            </div>
            <div class="card-body">

                <?php if($this->session->flashdata('pesan')): ?>
                    <?= $this->session->flashdata('pesan'); ?>
                <?php endif; ?>

                <form action="<?= base_url('simulasi/proses'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="userid" class="font-weight-bold">Nama Yang Absen <span class="text-danger">*</span></label>
                            <select name="userid" id="userid" class="form-control">
                                <option value="">-- Pilih Pegawai --</option>
                                <?php if(isset($users)) foreach ($users as $user): ?>
                                    <option value="<?= $user->userid; ?>" <?= set_select('userid', $user->userid); ?>>
                                        <?= htmlspecialchars($user->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('userid', '<small class="text-danger mt-1 d-block">', '</small>'); ?>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="SN" class="font-weight-bold">Mesin Absensi (SN) <span class="text-danger">*</span></label>
                            <select name="SN" id="SN" class="form-control">
                                <option value="">-- Pilih Mesin --</option>
                                <?php if(isset($machines)) foreach ($machines as $machine): ?>
                                    <option value="<?= $machine->SN; ?>" <?= set_select('SN', $machine->SN); ?>>
                                        <?= htmlspecialchars($machine->SN); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('SN', '<small class="text-danger mt-1 d-block">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <h6 class="font-weight-bold">Informasi Absen Otomatis</h6>
                        <dl class="row mb-0">
                            <dt class="col-sm-3">Waktu Akan Direkam</dt>
                            <dd class="col-sm-9">: <?= date('d F Y, H:i:s'); ?></dd>

                            <dt class="col-sm-3">Tipe Akan Direkam</dt>
                            <dd class="col-sm-9">: 
                                <?php 
                                    $jam = date('H');
                                    $tipe = ($jam < 13) ? 'Jam Masuk' : 'Jam Keluar';
                                    $badge_class = ($jam < 13) ? 'badge-success' : 'badge-danger';
                                    echo "<span class='badge $badge_class'>$tipe</span>";
                                ?>
                            </dd>
                        </dl>
                        <small class="form-text text-muted mt-2">Waktu dan Tipe Absen akan ditentukan saat tombol Simpan ditekan.</small>
                    </div>

                    <hr>
                    <div class="text-right">
                        <button type="submit" class="btn btn-dark"><i class="fas fa-save mr-2"></i>Simpan Simulasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>