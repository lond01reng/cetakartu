<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>cetaKartu | Log in</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url(); ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?= base_url(); ?>"><b>ceta</b>KARTU</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start <b>ceta</b>Kartu</p>
      <?=form_open(base_url('admin/proses'));?>
      <!-- <form action="<?= base_url('admin/proses'); ?>" method="post" accept-charset="utf-8"> -->
      <?php
      if(session('errors.username')){
        $ubor=' border-danger';
        $usrmsg='<div class="text-sm text-danger mt-n3 mb-3">'.session('errors.username').'</div>';
      }else{
        $ubor='';
        $usrmsg='';
      }
      ?>
      <div class="input-group mb-3">
        <input type="text" class="form-control<?=$ubor?>" placeholder="Username" name="username" value="<?= old('username'); ?>" autocomplete="username">
        <div class="input-group-append">
          <div class="input-group-text<?=$ubor?>">
            <span class="fas fa-envelope"></span>
          </div>
        </div>
      </div>
      <?= $usrmsg; ?>
      <?php
      if(session('errors.password')){
        $border=' is-invalid';
        $pasmsg='<div class="text-sm text-danger mt-n3 mb-3">'.session('errors.password').'</div>';
      }else{
        $border='';
        $pasmsg='';
      }
      ?>
      <div class="input-group mb-3">
        <input type="password" class="form-control<?=$border?>" placeholder="Password" name="password">
        <div class="input-group-append">
          <div class="input-group-text<?=$border?>">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>
      <?= $pasmsg; ?>
      <div class="">
        <button type="submit" class="btn btn-sm btn-primary btn-block">Sign In</button>
      </div>
      <!-- </form> -->
      <?= form_close() ?>

  </div>
</div>

<script src="<?= base_url(); ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>dist/js/adminlte.min.js"></script>
</body>
</html>
