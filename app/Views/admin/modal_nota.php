<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Nota Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
             
            <?= form_open(base_url('admin/simpan_nota'));?>
              <table class="table table-sm table-borderless">
                <tr><td>Sekolah</td><td>
                    <select class="custom-select" id="sch_npsn"  name="sch_id">
                        <option value="">--Pilih Sekolah--</option>
                    <?php
                        foreach($lsch as $sch){
                            echo '<option value="'.$sch->sch_npsn.'">'.$sch->sch_nama.'</option>';
                        }
                    ?>
                    </select>
                    </td>
                </tr>
                <tr><td>Kepala Sekolah</td><td><input type="text" name="ks_name" class="form-control"></td></tr>
                <tr><td>Tanggal</td><td><input type="date" name="tgl_ttd" class="form-control"></td></tr>
                <tr><td>Template</td><td><input type="text" name="tmpl" class="form-control"></td></tr>
              </table>
              <button type="submit" class="btn btn-sm btn-primary float-right ml-3"><i class="fas fa-save"></i> Simpan</button>
              <button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
            <?= form_close();?>
            </div>

        </div>
    </div>
</div>
