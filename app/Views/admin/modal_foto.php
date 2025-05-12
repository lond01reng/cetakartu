<div class="modal fade" id="ftModal" tabindex="-1" role="dialog" aria-labelledby="ftModalLabel" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ftModalLabel">Upload</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
             
            <?= form_open_multipart('', ['id' => 'fotoForm']);?>
              <div id="ft_id">
              </div>
              <input type="file" name="foto" accept="image/jpeg, image/png" required>
              <button type="submit" class="btn btn-sm btn-primary float-right ml-3"><i class="fas fa-save"></i> Simpan</button>
              <button type="button" class="btn btn-sm btn-danger float-right" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
            <?= form_close();?>
            </div>

        </div>
    </div>
</div>
