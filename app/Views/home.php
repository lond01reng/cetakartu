<?= $this->extend('template/tpublik') ?>
<?= $this->section('konten') ?>
  <?php if (! empty(session()->getFlashdata('nodata'))): ?>
    <div class="alert alert-danger alert-dismissible fade show col-sm-6 mx-auto" role="alert">
      <?= session('nodata');?>
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
  <?php endif ?>
  <form action="<?= base_url('pencarian'); ?>" method="POST">
  <?= csrf_field() ?>
    <div class="row justify-content-center mb-3">
      <div class="col-sm-3">
        <div class="form-group">
          <label class="d-block text-left mb-n1">NISN</label>
          <input type="text" name="nisn" class="form-control" placeholder="NISN">
        </div>
        <?= session('errors.nisn')?'<div class="text-sm text-danger mt-n3 mb-3  text-left">'.session('errors.nisn').'</div>':''; ?>
      </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label class="d-block text-left mb-n1">Tanggal Lahir</label>
          <input type="date" name="tgl" class="form-control" >
        </div>
        <?= session('errors.tgl')?'<div class="text-sm text-danger mt-n3 mb-3 text-left">'.session('errors.tgl').'</div>':''; ?>
      </div>
      
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-6"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Cari Data</button></div>
    </div>
    <div class="row justify-content-center mt-3 mx-1">
    <?php if(!empty($nisn)):?>
      <div class="col-sm-6 info-box w-100">
        <span class="info-box-icon bg-danger"><i class="far fa-file-pdf"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">
          <a href="<?= base_url('cetak_pdf/'.$nota.'/'.$nisn.'/2')?>" class="btn btn-outline-danger" target="blank">Cetak Kartu PDF NISN <?=$nisn?></a>
          </span>
        </div>
      </div>
    <?php endif;?>
    </div>
  </div>
  </form>

<?= $this->endSection() ?> 

<?= $this->extend('template/tpublik') ?>
<?= $this->section('js') ?>

<?= $this->endSection() ?> 