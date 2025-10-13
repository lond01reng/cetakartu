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
      'nota'=>$this->request->getUri()->getSegment(3)
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
    }else{
      if($file = $this->request->getFile('f_csv')) {
        if ($file->isValid() && ! $file->hasMoved()) {
          $newName = $file->getRandomName();
          // $uploadPath = FCPATH . 'csvfile';
          $uploadPath = WRITEPATH . 'uploads';
          $file->move($uploadPath, $newName);
          $filePath = ($uploadPath .'/'. $newName);

          if($this->prosesCSV($filePath, $nota)===true){  
            return redirect()->to('admin/daftar_anggota/'.$nota)->with('success', 'Data berhasil diupload.');
          }else{
            return redirect()->to('admin/daftar_anggota/'.$nota)->with('errors', ['File CSV salah, gunakan CSV dari template.']);
          }
        }
      }
    }
  }

  private function prosesCSV($filePath, $nota)
  {
    $file = fopen($filePath, "r");
    $header = fgetcsv($file, 1000, ";");

    if(!in_array('ag_nisn',$header)){
      unlink($filePath);
      fclose($file);
      return false;
      exit();
    }else{
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
      unlink($filePath);
      fclose($file);
      return true;
    }
  }

  private function prosesCSVRow($rowData, $nota)
  {
    $this->angg->simpan_csv($rowData, $nota);
  }

  public function edit_bio($nisn)
  {
    $data=$this->angg->getNisn($nisn);
    return view('admin/modal_edit', ['data' => $data]);
  }

  public function simpan_bio($nisn){
    $valRule=[
      'bio_nama'=>'required|regex_match[/^[a-zA-Z\' ]+$/]|min_length[3]|max_length[100]',
      'bio_nick'=>'required|regex_match[/^[a-zA-Z\' ]+$/]|min_length[3]|max_length[16]',
      'bio_tempat'=>'required|alpha_space|min_length[3]|max_length[24]',
      'bio_tgl'=>'required|valid_date',
      'bio_bapak'=>'required|regex_match[/^[a-zA-Z\' ]+$/]|min_length[3]|max_length[100]',
      'bio_rt'=>'required|numeric|max_length[2]',
      'bio_rw'=>'required|numeric|max_length[2]',
      'bio_dusun'=>'required|alpha_space|min_length[3]|max_length[24]',
      'bio_desa'=>'required|alpha_space|min_length[3]|max_length[24]',
      'bio_kec'=>'required|alpha_space|min_length[3]|max_length[24]',
    ];
    $valError=[
      'bio_nama'=>[
        'required'=> 'Nama Wajib Diisi',
        'alpha_space' => 'Karakter Nama yang diperbolehkan hanya huruf, spasi dan petik tunggal',
        'min_length'=> 'Minimal 3 karakter',
        'max_length' => 'Maksimal 24 karakter'
      ],
      'bio_nick'=>[
        'required'=> 'Nama Pendek Wajib Diisi',
        'alpha_space' => 'Karakter Nama yang diperbolehkan hanya huruf, spasi dan petik tunggal',
        'min_length'=> 'Minimal 3 karakter',
        'max_length' => 'Maksimal 24 karakter'
      ],
      'bio_tempat'=>[
        'required'=> 'Tempat Lahir Wajib Diisi',
        'alpha_space' => 'Karakter Tempat Lahir yang diperbolehkan hanya huruf',
        'min_length'=> 'Minimal 3 karakter',
        'max_length' => 'Maksimal 100 karakter'
        ],
      'bio_tgl'=>[
        'required'=>'Tanggal Lahir Wajib Diisi',
        'valid_date'=> 'Format tanggal "yyyy-mm-dd"'
      ],
      'bio_bapak'=>[
        'required'=> 'Nama Bapak Wajib Diisi',
        'alpha_space' => 'Karakter Nama Bapak yang diperbolehkan hanya huruf, spasi dan petik tunggal',
        'min_length'=> 'Minimal 3 karakter',
        'max_length' => 'Maksimal 100 karakter'
      ],
      'bio_rt'=>[
        'required'=>'RT Wajib Diisi',
        'numeric'=>'RT Hanya angka yang boleh digunakan',
        'max_length'=> 'Maksimal 2'
      ],
      'bio_rw'=>[
        'required'=>'RW Wajib Diisi',
        'numeric'=>'RW Hanya angka yang boleh digunakan',
        'max_length'=> 'Maksimal 2'
      ],
      'bio_dusun'=>[
        'required'=> 'Dusun Wajib Diisi',
        'alpha_space' => 'Karakter Dusun yang diperbolehkan hanya huruf',
        'min_length'=> 'Minimal 3 karakter',
        'max_length' => 'Maksimal 24 karakter'
        ],
      'bio_desa'=>[
        'required'=> 'Desa Wajib Diisi',
        'alpha_space' => 'Karakter Desa yang diperbolehkan hanya huruf',
        'min_length'=> 'Minimal 3 karakter',
        'max_length' => 'Maksimal 24 karakter'
        ],
      'bio_kec'=>[
        'required'=> 'Kecamatan Wajib Diisi',
        'alpha_space' => 'Karakter Kecamatan yang diperbolehkan hanya huruf',
        'min_length'=> 'Minimal 3 karakter',
        'max_length' => 'Maksimal 24 karakter'
        ],
    ];
    if(!$this->validate($valRule,$valError)){
      $data=$this->angg->getNisn($nisn);
      session()->setFlashdata('errors', $this->validator->getErrors());
      return redirect()->back();
    }else{
      $ag_nama = $this->request->getPost('bio_nama');
      $ag_nick = $this->request->getPost('bio_nick');
      $ag_tempat=$this->request->getPost('bio_tempat');
      $ag_tgl=$this->request->getPost('bio_tgl');
      $ag_bapak=$this->request->getPost('bio_bapak');
      $ag_rt=$this->request->getPost('bio_rt');
      $ag_rw=$this->request->getPost('bio_rw');
      $ag_dusun=$this->request->getPost('bio_dusun');
      $ag_desa=$this->request->getPost('bio_desa');
      $ag_kec=$this->request->getPost('bio_kec');
      $check=$this->request->getPost('bio_dl');
      if(isset($check)){
        $ag_dl=NULL;
      }else{
        $ag_dl=date('Y-m-d H:i:s');
      }
      $data=[
        'ag_nama'=>$ag_nama,
        'ag_nick'=>$ag_nick,
        'ag_tempat'=>$ag_tempat,
        'ag_tgl'=>$ag_tgl,
        'ag_bapak'=>$ag_bapak,
        'ag_rt'=>$ag_rt,
        'ag_rw'=>$ag_rw,
        'ag_dusun'=>$ag_dusun,
        'ag_desa'=>$ag_desa,
        'ag_kec'=>$ag_kec,
        'ag_dl'=>$ag_dl
      ];
      $this->angg->updateBio($nisn,$data);
      return redirect()->back();
    }
  }

  public function status_cetak()
  {
    $nisn=$this->request->getPost('ag_nisn');
    $this->angg->status_cetak($nisn);
    return redirect()->to(previous_url() . '#'.$nisn);
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
        $row->ag_nama,
        $row->ag_nick,
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