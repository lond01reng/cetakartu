<?php

namespace App\Controllers\Admin;
use App\Models\AnggotaModel;
use App\Models\NotaModel;
use App\Controllers\BaseController;

use CodeIgniter\Images\Image;

class Anggota extends BaseController
{
  public function __construct()
  {
    $this->angg = new AnggotaModel();
    $this->nt= new NotaModel();
  }
  public function index($nota)
  {
    $data=[
      'act'=>'daftar_anggota',
      'title'=>'Daftar Anggota',
      'nt'=>$nota,
      'anggota'=>$this->angg->getAnggota($nota)
    ];

    if(!empty($this->nt->getNota1($nota))){
      return view('admin/daftar_anggota', $data); 
    }else{
      return redirect()->to(base_url('admin/beranda'));
    }
  }

  public function mTambahAnggota()
  {
    $data=[
      'nota'=>$this->request->uri->getSegment(3)
    ];
    return view('admin/modal_anggota', $data);
  }

  public function simpan_anggota($nota)
  {
    $csvRule=[
      'f_csv'=>'uploaded[f_csv]|max_size[f_csv,2048]|ext_in[f_csv,csv]'
    ];
    $csvErr=[
      'f_csv'=>[
        'uploaded' => 'Harap pilih file csv.',
        'max_size' => 'Ukuran file tidak boleh melebihi 1 MB.',
        'mime_in' => 'Format file harus berupa CSV.'
      ]
    ];
    if(!$this->validate($csvRule, $csvErr)){
      $err=session()->setFlashdata('errors', $this->validator->getErrors());
      print_r($err);
    }else{
      if($file = $this->request->getFile('f_csv')) {
        if ($file->isValid() && ! $file->hasMoved()) {
          $newName = $file->getRandomName();
          $file->move('../public/csvfile', $newName);
          $filePath = ("../public/csvfile/" . $newName);

          $this->prosesCSV($filePath, $nota);

          unlink($filePath);
          return redirect()->to('admin/daftar_anggota/'.$nota)->with('success', 'Data berhasil diupload.');

        }
      }
    }
  }

  private function prosesCSV($filePath, $nota)
  {
    $file = fopen($filePath, "r");
    $header = fgetcsv($file, 1000, ";");
    $ctHead = count($header);
    $i=0;
    $csvArr=array();
    while(($filedata=fgetcsv($file, 1000, ";"))!== FALSE){
      $num = count($filedata);
      if($i>=0 && $num == $ctHead){
        $csvArr[$i] = array_combine($header, $filedata);
        $this->prosesCSVRow($csvArr[$i],$nota );
      }
      $i++;
    }
    fclose($file);
  }

  private function prosesCSVRow($rowData, $nota)
  {
    $this->angg->simpan_csv($rowData, $nota);
  }

  public function upload_foto()
  {
    $data=[
    ];
    return view('admin/modal_foto', $data);
  }
  public function simpan_foto($nota,$nisn) {
    $path= ROOTPATH. 'public/uploads/'.$nota;
    if (!is_dir($path)) {
      mkdir($path, 0755, true);
    }

    $file=$this->request->getFile('foto');
    $xtipe=$file->getExtension();
    $nama = $nisn . '.'.$xtipe; 

    $valRule=[
      'foto' => 'uploaded[foto]|max_size[foto,3072]|ext_in[foto,jpg,png]',
    ];
    $valError=[
      'foto' => [
                'uploaded' => 'Harap pilih file foto.',
                'max_size' => 'Ukuran file foto tidak boleh melebihi 3 MB.',
                'ext_in' => 'Format file foto harus berupa JPG atau PNG.'
            ],
    ];

    if(!$this->validate($valRule,$valError)){
      session()->setFlashdata('errors', $this->validator->getErrors());
      return redirect()->back();
    }else{
      if($file->isValid()&&!$file->hasMoved()){
        $filefoto=FCPATH.'uploads/'.$nota.'/'.$nama;
        if (file_exists($filefoto)) {
          unlink($filefoto); 
        }
        $file->move($path,$nama);
           
        $this->resize_foto($filefoto);
        session()->setFlashdata('success', 'Foto berhasil diupload.');
        return redirect()->to(base_url('admin/daftar_anggota/').$nota.'#'.$nisn);
      }
      session()->setFlashdata('errors', ['foto' => 'Terjadi kesalahan saat mengupload foto.']);
    return redirect()->back();
    }

  }

  private function resize_foto($filefoto) {
    if (!file_exists($filefoto)) {
      throw new \Exception('File gambar tidak ditemukan: ' . $filefoto);
    }

    $image = \Config\Services::image()->withFile($filefoto);
    $image->resize(500,666,true,'width');
    $image->save($filefoto);

  }
  public function dlAnggota($nota){
    $data=$this->angg->getAnggota($nota);
    header('Content-Type: text/csv, charset=utf-8');
    header('Content-Disposition: attachment; filename="DataAnggota_'.$nota.'.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');
    $judul = array('NISN','Nama','Nama Pendek','No Induk','Jurusan','Tgl Lahir','Tempat Lahir','Bapak','RT','RW','Dusun','Desa','Kec','Kab','Kelas');
    $output = fopen('php://output', 'w');
    fputcsv($output,$judul,';');
    foreach ($data as $row) {
      $csv_row=array(
        strval($row->ag_nisn),
        $row->ag_nick,
        $row->ag_nama,
        $row->ag_induk,
        $row->ag_jurusan,
        (string)date('Y-m-d', strtotime($row->ag_tgl)),
        $row->ag_tempat,
        $row->ag_bapak,
        $row->ag_rt,
        $row->ag_rw,
        $row->ag_dusun,
        $row->ag_desa,
        $row->ag_kec,
        $row->ag_kab,
        $row->ag_klas
      );
      fputcsv($output,$csv_row,';');
    }
    fclose($output);
    exit;
  }
    
}