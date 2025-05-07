<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url()?>/favicon.ico" type="image/ico" />
  <title><?= $title; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url()?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url()?>plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url()?>dist/css/adminlte.min.css">
  <?= $this->renderSection('css'); ?>
</head>
<?php
$clr='purple';
?>
<body class="layout-top-nav layout-footer-fixed" style="height: auto;">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white ">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="<?=base_url();?>dist/img/favicon.png" alt="cetaKartu Logo" class="brand-image img-circle elevation-1" style="opacity: .8">

        <span class="brand-text font-weight-light">cetaKartu</span>
      </a>

      <!-- <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
        <h6 id="date-time" class="text-center nav-link"></h6>
        </li>
      </ul>
    </div>
  </nav>

  <div class="content-wrapper" style="min-height: 537px;">
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 mt-3">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <?= $this->renderSection('konten'); ?>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <footer class="main-footer text-sm">
    <!-- <div class="float-right d-none d-sm-inline">
      dikembangkan oleh SMKN<strong>Ngadirojo</strong>
    </div> -->
    <strong>Copyright © 2025 <a href="https://www.smknngadirojo.sch.id/">kdir</a>.</strong> All rights reserved.
  </footer>
</div>

<script src="<?= base_url()?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url()?>dist/js/adminlte.js"></script>
<?= $this->renderSection('js'); ?>
<script>
  function updateDateTime() {
    var now = new Date();
    var day = now.getDate().toString().padStart(2, '0');
    var year = now.getFullYear();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');
    var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    var month = months[now.getMonth()]; 
    var currentDateTime = `${day} ${month} ${year} ${hours}:${minutes}:${seconds}`;
    document.getElementById("date-time").innerText = currentDateTime;
  }

  setInterval(updateDateTime, 1000); 
  updateDateTime(); 
</script>
</body>
</html>