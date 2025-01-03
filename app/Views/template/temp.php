<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url()?>/favicon.ico" type="image/ico" />
  <title><?= $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url()?>plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>dist/css/adminlte.min.css">
  <?= $this->renderSection('css') ?>
</head>

<body class="layout-fixed sidebar-closed control-sidebar-slide-open layout-navbar-fixed sidebar-open sidebar-mini-xs accent-warning layout-footer-fixed" style="height: auto;">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="d-block"><?= session()->get('name'); ?></a>
      </li> -->
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <!-- <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" id="cari_data">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form> -->
        </div>
      </li>


      <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-user-cog text-dark"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- <a href="#" class="dropdown-item">
                <i class="fas fa-envelope mr-2"></i> 4 new messages
                <span class="float-right text-muted text-sm">3 mins</span>
              </a> -->
              <a href="#" class="dropdown-item"><i class="fas fa-user-circle mr-2"></i><?= session()->get('name'); ?></a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url(); ?>admin/logout" class="dropdown-item">
                <i class="fas fa-power-off mr-2 text-warning"></i>Logout
                <span class="float-right text-muted text-sm"></span>
              </a>
            </div>
          </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url();?>" class="brand-link">
      <img src="<?=base_url();?>dist/img/favicon.png" alt="cetaKartu Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><b>ceta</b>Kartu</span>
    </a>

    <!-- Sidebar -->

    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=base_url();?>dist/img/favicon.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          
        </div>
      </div> -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= base_url('admin/beranda');?>" class="nav-link<?= $act=='beranda'?' active text-warning':''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Pengguna
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alumni</p>
                </a>
              </li>
            </ul>
          </li> -->
          <?php if(session()->get('isAdmin')): ?>

          <li class="nav-item">
            <a href="<?= base_url('admin/list_sekolah');?>" class="nav-link<?= $act=='list_sekolah'? ' active text-warning':'' ?>">
              <i class="nav-icon fas fa-school"></i>
              <p>
                Daftar Sekolah
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link<?= $act=='daftar_anggota'? ' active text-warning':'' ?>">
            <i class="nav-icon fas fa-users"></i>
              <p>
                Daftar Anggota
              </p>
            </a>
          </li>   

          <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
    <?= $this->renderSection('konten'); ?>

  <footer class="main-footer text-sm">
    <strong>Copyright &copy; 2023 <a href="#">cetaKartu</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<script src="<?= base_url()?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url()?>dist/js/adminlte.js"></script>
<?= $this->renderSection('js') ?>
</body>
</html>