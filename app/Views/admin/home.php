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
            <h4 class="m-0">Beranda</h4>
          </div>
          <div class="col-sm-6">
          <?php if(session()->get('level')==='sup'): ?>
            <button type="button" class="btn btn-sm btn-primary float-right" id="openModalBtn"><i class="fas fa-plus-circle"></i> Tambah Nota</button>
          <?php endif;?>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 table-responsive">
          <?php
      ?>
      
      <?php if (! empty(session()->getFlashdata('errors'))): ?>
        <?php $errors= session()->getFlashdata('errors'); ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Input Gagal!!! 
              <?php foreach ($errors as $error): ?>
                  <?= esc($error) ?>
              <?php endforeach ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
      <?php endif ?>
      <?php if (! empty(session()->getFlashdata('success'))): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session('success');?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <?php endif ?>

          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Nota</th>
                <th>Sekolah</th>
                <th>Anggota</th>
                <th>KS</th>
                <th>Tgl</th>
                <th>Template</th>
                <th>Gambar</th>
                <th>Aksi</th>

              </tr>
            </thead>
            <tbody>
              <?php foreach($notas as $nt): ?>
              <tr>
                <td rowspan=2><?= $nt->nt_id; ?> <br>[<?= date('y-m-d',strtotime($nt->nt_cr));?>]</td>
                <td><?= $nt->nt_sch; ?></td> 
                <td><a href="<?=base_url('admin/daftar_anggota/'.$nt->nt_id);?>" class="btn btn-primary btn-sm"><i class="fas fa-users"></i> <?=$ct_agg[$nt->nt_id];?> </a></td> 
                <td><?= !empty($nt->nt_ks)?$nt->nt_ks:'<i class="fas fa-chalkboard-teacher"></i>';?></td>
                <td><?= !empty($nt->nt_tgl)?$nt->nt_tgl:'<i class="fas fa-calendar-alt"></i>';?></td>
                <td><?= !empty($nt->nt_tmpl)?$nt->nt_tmpl:'<i class="fas fa-plus-circle"></i>'; ?></td>
                <td>
                 
                  <?php 
                  $f_bg1= 'uploads/'.$nt->nt_id.'/bg1_'.$nt->nt_id.'.jpg';
                  if(file_exists(FCPATH.$f_bg1)){
                    echo '<img src="'.base_url($f_bg1).'" style="height:25px" alt="bgfr'.$nt->nt_id.'">';
                  }else{
                    echo '<i class="far fa-id-card"></i> ';
                  }

                  $f_bg2= 'uploads/'.$nt->nt_id.'/bg2_'.$nt->nt_id.'.jpg';
                  if(file_exists(FCPATH.$f_bg2)){
                    echo '<img src="'.base_url($f_bg2).'" style="height:25px" alt="bgbk'.$nt->nt_id.'">';
                  }else{
                    echo '<i class="far fa-credit-card"></i> ';
                  }

                  $f_stp= 'uploads/'.$nt->nt_id.'/stp_'.$nt->nt_id.'.png';
                  if(file_exists(FCPATH.$f_stp)){
                    echo '<img src="'.base_url($f_stp).'" style="height:25px" alt="ttd'.$nt->nt_id.'">';
                  }else{
                    echo '<i class="fas fa-stamp"></i>';
                  }
                  ?>

                </td>
                <td>
                <?php if(session()->get('level')==='sup'): ?> 
                <a href="<?= base_url('admin/tambah_gambar/'.$nt->nt_id);?>" class="btn btn-sm btn-primary" role="button" data-toggle="tooltip" data-placement="top" title="Upload Gambar"><i class="fas fa-upload"></i></a></td>
                <?php endif; ?>
              </tr>
              <tr><td colspan=7>
                <?php
                if (isset($jurs[$nt->nt_id])){
                  foreach ($jurs[$nt->nt_id] as $jur):
                    $jrnick=str_replace('dan','',$jur->ag_jurusan);
                    preg_match_all('/\b\w/',$jrnick, $matches);
                    ?>
                    <a href="<?=base_url('admin/cetak_kelas/'.$nt->nt_id.'/'.str_replace(' ','-',$jur->ag_jurusan).'/'.$jur->ag_klas);?>" class="btn btn-sm btn-danger" target="_blank"><i class="far fa-file-pdf"></i> <?=implode('', $matches[0]).$jur->ag_klas;?></a>
                    
                    <?php
                    
                  endforeach;
                }else{
                  echo 'tidak ada data';
                }
                ?>
                <a href="<?=base_url('admin/cetak_nota/'.$nt->nt_id);?>" class="btn btn-sm btn-success " target="_blank"><i class="far fa-file-pdf"></i> Cetak Nota</a>
              </td></tr>
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
<?php if(session()->get('level')==='sup'): ?>
<script>
  $(document).ready(function () {
    $('#openModalBtn').click(function () {
      $.ajax({
        url: '<?= base_url('admin/tambah_nota'); ?>',
        type: 'GET',
        success: function (data) {
            $('body').append(data);
            $('#myModal').modal('show');
        },
        error: function () {
            alert('Gagal memuat konten modal.');
        }
      });
    });
  });
</script>
<?php endif; ?>
<?= $this->endSection() ?> 