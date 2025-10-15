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
            <h5 class="m-0">Daftar Anggota </h5> Nota No. <?= $nt;?>
          </div>
          <div class="col-sm-6">
            <?php if(session()->get('level')==='sup'):?>
            <button type="button" class="btn btn-sm btn-primary float-right" id="modalAnggota"><i class="fas fa-plus-circle"></i> Tambah Anggota</button>  
            <a href="<?= base_url('admin/download_anggota/'.$nt)?>" class="btn btn-sm btn-success float-right mr-3"><i class="far fa-file-excel"></i> Download Data</a>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 table-responsive">
          <?php if (! empty(session()->getFlashdata('errors'))): ?>
            <?php $errors= session()->getFlashdata('errors'); ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Input Gagal!!! <br>
                  <?php foreach ($errors as $error): ?>
                      <?= esc($error).'<br>' ?>
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
                <th>NISN</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Induk</th>
                <th>Lahir</th>
                <th>Ortu</th>
                <th>Alamat</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($anggota as $agg): ?>
              <?php 
              if(empty($agg->ag_dl)){
                $actk= 'href="'.base_url('admin/cetak_pribadi/'.$agg->ag_nota.'/'.$agg->ag_nisn.'/2').'"  target="_blank"';
                $apdf= 'href="'.base_url('admin/cetak_pribadi/'.$agg->ag_nota.'/'.$agg->ag_nisn.'/1').'" target="_blank"';
                $opac=1;
              }else{
                $actk='href="#"';
                $apdf='href="#"';
                $opac=0.2;
              }
              ?>
              <tr id="<?=$agg->ag_nisn; ?>" style="opacity:<?= $opac; ?>">
                <td>
                  <div><?=$agg->ag_nisn; ?></div>
                  <div class="d-flex">
                  <i class="fas fa-user-edit text-info modalEdit" data-id="<?=$agg->ag_nisn;?>"></i>
                  <a <?=$actk;?>><i class="fas fa-file-pdf mx-2"></i></a>
                  <form action="<?= base_url('admin/status_cetak') ?>" method="post" onsubmit="return confirm('Yakin ingin mengubah status cetak <?=$agg->ag_nama;?>?')">
                      <?= csrf_field() ?>
                      <input type="hidden" name="ag_nisn" value="<?= esc($agg->ag_nisn) ?>">
                      <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;">
                          <i class="fas fa-<?=$agg->ag_cetak=="1"?"print":"sync-alt";?> <?=$agg->ag_cetak=="1"?"text-primary":"text-dark";?>"></i>
                      </button>
                  </form>
                  </div>
                </td>
                <td>
                <?php
                $poto='uploads/'.$agg->ag_nota.'/'.$agg->ag_nisn;
                if (file_exists(FCPATH . $poto.'.jpg')) {
                  $lastmod = filemtime(FCPATH.$poto.'.jpg');
                  $imgsrc=base_url($poto.'.jpg').'?v='.$lastmod;
                  $avtr='fa-portrait text-primary';
                } 
                elseif (file_exists(FCPATH . $poto.'.png')) {
                  $lastmod = filemtime(FCPATH.$poto.'.png');
                  $imgsrc = base_url($poto.'.png').'?v='.$lastmod;
                  $avtr='fa-portrait text-primary';
                }
                else {
                  $imgsrc = base_url('dist/img/no-user.jpg');
                  $avtr='fa-plus-circle text-warning';
                }                
                ?>
                <i class="modalFoto fas <?=$avtr?> fa-3x"  data-id="<?=$agg->ag_nisn?>"  data-label="<?=$agg->ag_nama?>" data-img="<?=$imgsrc?>"></i>
                
                </td>
                <td><?=$agg->ag_nama; ?></td>
                <td><?=$agg->ag_induk.' '.$agg->ag_jurusan; ?></td> 
                <td><?=$agg->ag_tempat; ?>, <?= $agg->ag_tgl!='0000-00-00'?date_id(date('Y-m-d', strtotime($agg->ag_tgl))):$agg->ag_tgl;?></td>
                <td><?=$agg->ag_bapak; ?></td>
                <td>RT <?=$agg->ag_rt; ?> RW <?=$agg->ag_rw; ?>, <?=$agg->ag_dusun; ?>, <?=$agg->ag_desa; ?>, <?=$agg->ag_kec; ?></td>
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
<?php if(session()->get('level')==='sup'): ?> 
<script>
  $(document).ready(function () {
    $('#modalAnggota').click(function () {
      $.ajax({
        url: '<?= base_url('admin/tambah_anggota/'.$nt); ?>',
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


  $(document).ready(function () {
    $(document).on('click','.modalFoto',function () {
      var id = $(this).data('id');  
      var label = $(this).data('label');  
      var img = $(this).data('img');
      $.ajax({
        url: '<?= base_url('admin/upload_foto'); ?>',
        type: 'GET',
        success: function (data) {
            $('body').append(data);
            $('#ft_id').html('<img src="'+img+'" class="w-75"/><br>'+label + ' (' + id + ')');
            $('#fotoForm').attr('action', '<?= base_url('admin/simpan_foto/'.$nt.'/'); ?>' + id);
            $('#ftModal').modal('show');
        },
        error: function () {
            alert('Gagal memuat konten modal.');
        }
      });
    });
  });

  $(document).ready(function () {
    $(document).on('click','.modalEdit',function () {
      var id = $(this).data('id');  
      var label = $(this).data('label');  
      $('#edModal').remove();
      $.ajax({
        url: '<?= base_url('admin/edit_biodata/'); ?>'+id,
        type: 'GET',
        success: function (data) {
            $('body').append(data);
            $('#edModal').modal('show');
        },
        error: function () {
            alert('Gagal memuat konten modal.');
        }
      });
    });
    $('#edModal').on('hidden.bs.modal', function () {
      $(this).remove();
    });
  });

</script>
<?php endif; ?>
<?= $this->endSection() ?> 