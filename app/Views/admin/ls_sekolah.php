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
            <h4 class="m-0">Daftar Sekolah</h4>
          </div>
          <div class="col-sm-6">
            <button class="btn btn-primary btn-sm float-right">Button</button>
          </div>

        </div>
      </div>
    </div>
<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>NPSN</th>
                <th>Nama</th>
                <th>Alamat</th>
              </tr>
            </thead>
            <tbody>
            <?php  foreach($sch as $sc): ?>
              <tr>
                <td><?= $sc->sch_npsn;?></td>
                <td><?= $sc->sch_nama;?></td>
                <td><?= $sc->sch_alamat;?></td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<?= $this->endSection() ?> 

<?= $this->extend('template/temp') ?>
<?= $this->section('js') ?>
<?= $this->endSection() ?> 