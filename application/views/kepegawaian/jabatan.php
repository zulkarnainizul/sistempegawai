<?= $this->session->flashdata('pesan');?> 
<!-- Isi Konten -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">  
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <span><h5>Tabel Data Jabatan</h5></span>
              <div>
                <button data-toggle="modal" data-target="#tambah"class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Jabatan</button>
              </div>
            </div>
          </div>  
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Jabatan Pegawai</th>
                  <th>Jenis Jabatan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php $no = 1;
              foreach($jabatan as $jb) : ?>
                  <tr class="text-center">
                    <td><?= $no++ ?></td>
                    <td><?= $jb-> nama_jabatan?></td>
                    <td><?= $jb-> jenis_jabatan?></td>
                    <td>
                    <div class="btn-group" role="group">
                      <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-toggle="tooltip" title="Edit" data-target="#edit<?= $jb->id_jabatan?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-toggle="tooltip" title="Hapus" data-target="#delete<?= $jb->id_jabatan ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </div>
                    </td>
                  </tr>
              <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>


<!-- Modal Tambah-->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-dark"> 
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jabatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="<?= base_url('Jabatan/tambah') ?>" method="POST">
          <div class="form-group">
            <label>Nama Jabatan <span class="text-danger">*</span></label>
            <input type="text" name="nama_jabatan" class="form-control">
          </div>  
          <div class="form-group">
            <label>Jenis Jabatan <span class="text-danger">*</span></label>
            <select name="jenis_jabatan" class="form-control select2" style="width: 100%;">
              <option value="">-- Pilih Jenis Jabatan --</option>
              <option value="Struktural">Struktural</option>
              <option value="Fungsional">Fungsional</option>
            </select>
          </div>  

          <div class="modal-footer">  
            <button type="reset" class="btn btn-secondary btn-sm"><i class="fas fa-trash"></i> Reset</button>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Simpan</button>  
          </div>
        </form>
      </div>  
    </div>
  </div> 
</div>

<!-- Modal Edit-->
<?php foreach($jabatan as $jb) { ?>
  <div class="modal fade" id="edit<?= $jb->id_jabatan ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content"> 
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="exampleModalLabel">Edit Jabatan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>  
        
        <div class="modal-body">  
          <form action="<?= base_url('Jabatan/edit/' . $jb->id_jabatan) ?>" method="POST">
            <div class="form-group">
              <label>Jabatan <span class="text-danger">*</span></label>
              <input type="text" name="nama_jabatan" class="form-control" value="<?= $jb->nama_jabatan ?>"> 
            </div>
            <div class="form-group">
              <label>Jenis Jabatan <span class="text-danger">*</span></label>
              <select name="jenis_jabatan" class="form-control select2" style="width: 100%;">
                <option value="">-- Pilih Jenis Jabatan --</option>
                <option value="Struktural" <?= ($jb->jenis_jabatan == 'Struktural') ? 'selected' : ''; ?>>Struktural</option>
                <option value="Fungsional" <?= ($jb->jenis_jabatan == 'Fungsional') ? 'selected' : ''; ?>>Fungsional</option>
              </select>
            </div>  

            <div class="modal-footer">
              <button type="reset" class="btn btn-secondary btn-sm"><i class="fas fa-trash"></i> Reset</button>
              <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-save"></i> Simpan</button>
            </div>  
          </form>
        </div>
      </div>  
    </div>
  </div>
<?php } ?>



<!-- Modal Delete -->
<?php foreach($jabatan as $jb) { ?>
  <div class="modal fade" id="delete<?= $jb->id_jabatan ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-dark">
          <h5 class="modal-title" id="exampleModalLabel"> Konfirmasi Hapus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin ingin menghapus jabatan <strong><?= $jb->nama_jabatan ?></strong>??</p>
          <p class="text-muted small">Tindakan ini akan menghapus data jabatan yang bersangkutan secara permanen.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          <a href="<?= base_url('Jabatan/hapus/') . $jb->id_jabatan ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
        </div>  
      </div>
    </div>
  </div>
<?php } ?>