<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('pencarian', 'Home::cariSiswa');
$routes->get('cetak_pdf/(:num)/(:num)/(:num)', 'Admin\Cetakkelas::pribadiPdf/$1/$2/$3');
$routes->post('font/upload', 'FontController::upload');

$routes->group('admin',['filter'=>'cekadmin'], static function($routes){
  $routes->get('beranda', 'Admin\Home::index');
  $routes->get('tambah_nota', 'Admin\Home::mTambahNota');
  $routes->post('simpan_nota', 'Admin\Home::save_nota');
  // $routes->get('simpan_nota', 'Admin\Home::save_nota');
  $routes->get('tambah_gambar/(:num)', 'Admin\Home::tambah_gambar/$1');
  $routes->post('simpan_gambar/(:num)', 'Admin\Home::save_gambar/$1');
  $routes->get('jsch', 'Admin\Home::jsch');

  $routes->get('daftar_anggota/(:num)', 'Admin\Anggota::index/$1');
  $routes->get('tambah_anggota/(:num)', 'Admin\Anggota::mTambahAnggota/$1');
  $routes->post('simpan_anggota/(:num)', 'Admin\Anggota::simpan_anggota/$1');
  $routes->get('upload_foto', 'Admin\Anggota::upload_foto');
  $routes->post('simpan_foto/(:num)/(:num)', 'Admin\Anggota::simpan_foto/$1/$2');
  $routes->get('download_anggota/(:num)', 'Admin\Anggota::dlAnggota/$1');
  $routes->get('edit_biodata/(:num)', 'Admin\Anggota::edit_bio/$1');
  $routes->post('simpan_biodata/(:num)', 'Admin\Anggota::simpan_bio/$1');
  $routes->post('status_cetak', 'Admin\Anggota::status_cetak');

  // $routes->get('cetak_kartu/(:num)', 'Admin\Cetakkartu::generatePdf/$1');
  // $routes->get('cetak_kartu/(:num)/(:num)', 'Admin\Cetakkartu::generatePdf/$1/$2');
  // $routes->get('cetak_kartu/(:num)/(:segment)', 'Admin\Cetakkartu::generatePdf/$1/$2');
  
  $routes->get('cetak_nota/(:num)', 'Admin\Cetaknota::index/$1');
  

  $routes->get('cetak_kelas/(:num)/(:segment)/(:num)', 'Admin\Cetakkelas::generatePdf/$1/$2/$3');
  // $routes->get('cetak_pribadi/(:num)/(:num)', 'Admin\Cetakkelas::pribadiPdf/$1/$2');
  $routes->get('cetak_pribadi/(:num)/(:num)/(:num)', 'Admin\Cetakkelas::pribadiPdf/$1/$2/$3');
  // $routes->get('cetak_tunggal/(:num)/(:segment)', 'Admin\Cetaktunggal::generatePdf/$1/$2');
  $routes->get('cetak_all/(:num)', 'Admin\Cetakkelas::allpdf_pecah/$1');

  $routes->get('list_sekolah', 'Admin\DaftarSekolah::index');

  $routes->get('font', 'FontController::index');
  $routes->get('logout', 'Auth::logout');
});

$routes->group('admin',['filter'=>'isadmin'], static function($routes){
  $routes->get('/', 'Auth::index');
  $routes->get('login', 'Auth::index');
  $routes->post('proses', 'Auth::proses');

});