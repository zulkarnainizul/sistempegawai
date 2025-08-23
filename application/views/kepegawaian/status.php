<?= $this->session->flashdata('pesan');?>
<!-- Isi Konten -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <span><h5>Tabel Data Status</h5></span>             
              <div>
                <button data-toggle="modal" data-target="#tambah" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Status</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>No</th>
                  <th>Status Pegawai</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php $no = 1; foreach($status as $st) : ?>
                <tr class="text-center">
                  <td><?= $no++ ?></td>
                  <td><?= $st-> nama_status?></td>
                  <td>
                    <div class="btn-group" role="group">
                      <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-toggle="tooltip" title="Edit" data-target="#edit<?= $st->id_status_pegawai?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-toggle="tooltip" title="Hapus" data-target="#delete<?= $st->id_status_pegawai ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-dark">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('Status/tambah') ?>" method="POST">
          <div class="form-group">
            <label>Status <span class="text-danger">*</span></label>
            <input type="text" name="nama_status" class="form-control"> 
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
<?php foreach($status as $st) { ?>
  <div class="modal fade" id="edit<?= $st->id_status_pegawai ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="exampleModalLabel">Edit Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?= base_url('Status/edit/' . $st->id_status_pegawai) ?>" method="POST">
            <div class="form-group">
              <label>Status <span class="text-danger">*</span></label>
              <input type="text" name="nama_status" class="form-control" value="<?= $st->nama_status ?>">
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
<?php foreach($status as $st) { ?>
  <div class="modal fade" id="delete<?= $st->id_status_pegawai ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-dark">
          <h5 class="modal-title" id="exampleModalLabel"> Konfirmasi Hapus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin ingin menghapus status <strong><?= $st->nama_status ?></strong>?</p>
          <p class="text-muted small">Tindakan ini akan menghapus data status yang bersangkutan secara permanen.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          <a href="<?= base_url('Status/hapus/') . $st->id_status_pegawai ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
        </div>  
      </div>
    </div>
  </div>
<?php } ?>