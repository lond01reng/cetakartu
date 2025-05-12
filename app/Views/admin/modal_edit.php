<div class="modal fade" id="edModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Biodata</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">

            <?= form_open(base_url('admin/simpan_biodata/'.$data->ag_nisn));?>
              <table class="table table-sm table-borderless">
                <tr><td>NISN</td><td><?=$data->ag_nisn;?></td></tr>
                <tr><td>Nama</td><td><input type="text" name="bio_nama" class="form-control" value="<?=$data->ag_nama;?>"></td></tr>
                <tr><td>Lahir</td><td>
                <div class="d-inline">
                  <input type="text" name="bio_tempat" class="form-control w-auto d-inline" value="<?=$data->ag_tempat;?>"> <input type="date" name="bio_tgl" class="form-control w-auto d-inline" value="<?=$data->ag_tgl;?>">
                </div>
                </td></tr>
                <tr><td>Ortu</td><td><input type="text" name="bio_bapak" class="form-control" value="<?=$data->ag_bapak;?>"></td></tr>
                <tr><td>Alamat</td><td>
                <div class="d-flex">
                  <div class="d-inline me-2">
                    RT <input type="text" name="bio_rt" class="form-control w-75" value="<?=$data->ag_rt;?>">
                  </div>
                  <div class="d-inline">
                    RW <input type="text" name="bio_rw" class="form-control w-75" value="<?=$data->ag_rw;?>">
                  </div>
                  <div class="d-inline">
                    Dusun <input type="text" name="bio_dusun" class="form-control w-auto" value="<?=$data->ag_dusun;?>">
                  </div>
                </div>
                <div class="d-flex">
                  <div class="d-inline me-2">
                    Desa <input type="text" name="bio_desa" class="form-control" value="<?=$data->ag_desa;?>">
                  </div>
                  <div class="d-inline">
                    Kec <input type="text" name="bio_kec" class="form-control" value="<?=$data->ag_kec;?>">
                  </div>
                </div>
                </td></tr>
                <tr><td>Status</td><td>
                  <div class="custom-control custom-switch">
                  <input type="checkbox" name="bio_dl" class="custom-control-input" value="<?= !empty($data->ag_dl)?"0":"1";?>" id="status" <?= empty($data->ag_dl)?"checked":""?>>
                  <label class="custom-control-label" for="status"><?= empty($data->ag_dl)?"Aktif":"Tidak Aktif";?></label>
                </div>
                </td></tr>
              </table>
              <button type="submit" class="btn btn-sm btn-primary float-right ml-3"><i class="fas fa-save"></i> Simpan</button>
              <button type="button" class="btn btn-sm btn-danger float-right" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
            <?= form_close();?>
            </div>

        </div>
    </div>
</div>
