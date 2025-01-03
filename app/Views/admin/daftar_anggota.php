<?= $this->extend('template/temp') ?>
<?= $this->section('css') ?>
<!-- <link rel="stylesheet" href="<?= base_url()?>dist/select2/css/select2.min.css"> -->
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
                <tr id="<?=$agg->ag_nisn; ?>"><td>
                  <?=$agg->ag_nisn; ?><br>
                  <a href="<?=base_url('admin/cetak_pribadi/'.$agg->ag_nota.'/'.$agg->ag_nisn.'/2')?>" target="_blank"><i class="fas fa-file-pdf mx-3"></i></a> 
                  <a href="<?=base_url('admin/cetak_pribadi/'.$agg->ag_nota.'/'.$agg->ag_nisn.'/1')?>" target="_blank"><i class="fas fa-print"></i></a>
                </td>
                <td>
                <?php
                // $filePath = FCPATH . 'uploads/' . $agg->ag_nota . '/' . $agg->ag_nisn . '.jpg';

                // if (file_exists($filePath)) {
                //   echo '<img src="'.base_url().'uploads/'.$agg->ag_nota.'/'.$agg->ag_nisn.'.jpg" style="height:50px">';
                // } 
                
              if (file_exists(FCPATH . 'uploads/' . $agg->ag_nota . '/' . $agg->ag_nisn . '.jpg')) {
                  echo '<img src="'.base_url().'uploads/'.$agg->ag_nota.'/'.$agg->ag_nisn.'.jpg" style="height:50px">';
              } 
              // Jika tidak ada, cek untuk file dengan ekstensi .png
              else if (file_exists(FCPATH . 'uploads/' . $agg->ag_nota . '/' . $agg->ag_nisn . '.png')) {
                  echo '<img src="'.base_url().'uploads/'.$agg->ag_nota.'/'.$agg->ag_nisn.'.png" style="height:50px">';
              }
              else {
                  if(session()->get('level')==='sup'){
                    echo '<button type="button" class="btn btn-sm btn-primary modalFoto" data-id="'.$agg->ag_nisn.'"  data-label="'.$agg->ag_nama.'"><i class="fas fa-plus-circle"></i> </button>';
                  }
                }                
                ?>
                
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
<!-- <script src="<?= base_url()?>plugins/select2/js/select2.full.min.js"></script> -->
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
      $.ajax({
        url: '<?= base_url('admin/upload_foto'); ?>',
        type: 'GET',
        success: function (data) {
            $('body').append(data);
            $('#ft_id').text(label + ' ('+id+')');
            $('#fotoForm').attr('action', '<?= base_url('admin/simpan_foto/'.$nt.'/'); ?>' + id);
            $('#ftModal').modal('show');
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