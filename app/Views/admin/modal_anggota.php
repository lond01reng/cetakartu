<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import Anggota, Nota No. <?=$nota;?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
             
            <?= form_open_multipart(base_url('admin/simpan_anggota/'.$nota));?>
              <table class="table table-sm table-borderless">
                <tr><td>Pilih csv</td><td>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="f_csv" id="f_csv">
                    <label class="custom-file-label"  for="f_csv">Pilih file format csv</label>
                </div>
                </td></tr>
              </table>
              <button type="submit" class="btn btn-sm btn-primary float-right ml-3"><i class="fas fa-save"></i> Simpan</button>
              <button type="submit" class="btn btn-sm btn-success"><a href="<?= base_url('template/tmp_anggota.csv')?>" class="text-white"><i class="fas fa-file-csv"></i> Download Template</a></button>
              <button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
            <?= form_close();?>
            </div>

        </div>
    </div>
</div>

<script>
    // Menangkap perubahan pada input file
    $('.custom-file-input').on('change', function () {
        var fileName = $(this).val().split('\\').pop(); // Mengambil nama file dari path lengkap
        var label = $(this).next('.custom-file-label');
        label.html(fileName); // Menampilkan nama file di label
    });
</script>
