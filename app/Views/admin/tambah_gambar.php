<?= $this->extend('template/temp') ?>
<?= $this->section('css') ?>
<?= $this->endSection() ?> 

<?= $this->extend('template/temp') ?>
<?= $this->section('konten') ?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h5 class="m-0">Tambah Gambar</h5> Nota No. <?= $nt;?>
          </div>
          <div class="col-sm-6">
            <!-- <button type="button" class="btn btn-sm btn-primary float-right" id="openModalBtn"><i class="fas fa-arrow-circle-left"></i> Kembali</button> -->
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 table-responsive">
            <?= form_open_multipart(base_url('admin/simpan_gambar/'.$nt));?>
            <table class="table table-sm table-borderless">
            <tr><td>Stempel</td><td>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="stamp" id="stamp">
                    <label class="custom-file-label" for="stamp">Pilih gambar format png</label>
                </div>
                </td></tr>
                <tr><td>Background Depan</td><td>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="bg1" id="bg1">
                    <label class="custom-file-label"  for="bg1">Pilih gambar format png</label>
                </div>
                </td></tr>
                <tr><td>Background Belakang</td><td>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="bg2" id="bg2">
                    <label class="custom-file-label" for="bg2">Pilih gambar format png</label>
                </div>
                </td></tr>
            </table>
              <button type="submit" class="btn btn-sm btn-primary float-right ml-3"><i class="fas fa-save"></i> Simpan</button>
              <button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
            <?= form_close();?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection() ?> 

<?= $this->extend('template/temp') ?>
<?= $this->section('js') ?>
<script>
    // Menangkap perubahan pada input file
    $('.custom-file-input').on('change', function () {
        var fileName = $(this).val().split('\\').pop(); // Mengambil nama file dari path lengkap
        var label = $(this).next('.custom-file-label');
        label.html(fileName); // Menampilkan nama file di label
    });
</script>
<?= $this->endSection() ?> 