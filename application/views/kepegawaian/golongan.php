<?= $this->session->flashdata('pesan');?>
<!-- Isi Konten -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <span><h5>Tabel Data Golongan</h5></span>
            <div>
              <button data-toggle="modal" data-target="#tambah" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Golongan</button>
            </div>
          </div>
        </div>  
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Golongan Pegawai</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php $no = 1;
            foreach($golongan as $gl) : ?>
                <tr class="text-center">
                  <td><?= $no++ ?></td>
                  <td><?= $gl->nama_golongan?></td>
                  <td>
                    <div class="btn-group" role="group">
                      <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-toggle="tooltip" title="Edit"  data-target="#edit<?= $gl->id_golongan ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-toggle="tooltip" title="Hapus" data-target="#delete<?= $gl->id_golongan ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Golongan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('Golongan/tambah') ?>" method="POST">
          <div class="form-group">
              <label>Golongan <span class="text-danger">*</span></label>
              <input type="text" name="nama_golongan" class="form-control">
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

<!-- Modal Edit -->
<?php foreach($golongan as $gl) { ?>
  <div class="modal fade" id="edit<?= $gl->id_golongan ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title" id="exampleModalLabel">Edit Golongan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="<?= base_url('Golongan/edit/' . $gl->id_golongan) ?>" method="POST">
            <div class="form-group">
              <label>Golongan <span class="text-danger">*</span></label>
              <input type="text" name="nama_golongan" class="form-control" value="<?= $gl->nama_golongan ?>">
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
<?php foreach($golongan as $gl) { ?>
  <div class="modal fade" id="delete<?= $gl->id_golongan ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-dark">
          <h5 class="modal-title" id="exampleModalLabel"> Konfirmasi Hapus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin ingin menghapus golongan <strong><?= $gl->nama_golongan ?></strong>?</p>
          <p class="text-muted small">Tindakan ini akan menghapus data golongan yang bersangkutan secara permanen.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
          <a href="<?= base_url('Golongan/hapus/') . $gl->id_golongan ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Ya, Hapus</a>
        </div>  
      </div>
    </div>
  </div>
<?php } ?>
